<?php

/*******************************************************
*  File: log_session_class.inc                         *
*  Authors: Jeremy Nelson and John Dunning             *
*  Date: April 22, 2003                                *
*******************************************************/

include_once('php-logger.cfg');

class log_instance 
{
    var $messages;
    var $needs_reset;
    var $parent_logger_instance;
    var $instance_is_open;
    var $queue_mode;
    var $type;
    var $thresh;

    function log_instance(&$parent_logger_instance, $parent_application)
    {
        $this->parent_logger_instance = &$parent_logger_instance;
        $this->parent_application = $parent_application;
        $this->syslog_levels = &$parent_logger_instance->syslog_levels;
        $this->thresh = DEFAULT_THRESH;
        $this->queue_mode = DEFAULT_QUEUE_MODE;
        $this->error_condition_trigger_thresh = DEFAULT_ERROR_CONDITION_TRIGGER_THRESH;
        $this->error_condition_thresh = DEFAULT_ERROR_CONDITION_THRESH;
        $this->in_error_condition = FALSE;
        $this->max_queue_size = DEFAULT_MAX_QUEUE_SIZE;
        $this->messages = array();
        $this->needs_reset = TRUE;
    }

    function open()
    {  
        if ( $this->needs_reset )
        {
            $this->reset();
        }
        if ( $this->type_specific_open() )
        {
            $this->instance_is_open = TRUE;
            return (TRUE);
        }
        else
        {
            $msg = sprintf ("Unable to open log instance\n");
            $this->write_logger_log($msg);
            return (FALSE);
        }
    }

    function get_instance_type()
    {
        return ( $this->type );
    }

    function set_max_queue_size($size)
    {
        $this->enable_queue_mode();
        $this->max_queue_size = $size;
    }

    function set_error_condition_trigger_thresh ($thresh)
    {
        $this->enable_queue_mode();
        $this->error_condition_trigger_thresh = $thresh;
    }

    function set_error_condition_thresh ($thresh)
    {
        $this->enable_queue_mode();
        $this->error_condition_thresh = $thresh;
    }

    function set_thresh($threshold)
    {
        $this->thresh = $threshold;
    }

    function enable_queue_mode()
    {
        $this->queue_mode = TRUE;
    }

    function disable_queue_mode()
    {
        $this->flush_queue();
        $this->queue_mode = FALSE;
    }

    function reset()
    {
        $this->close();
        $this->type_specific_reset();
        $this->needs_reset = FALSE;
    }

    function queue_msg($queue_entry)
    {
        $queue_entry[MSG_TIME] = date("r");
        array_push ($this->messages, $queue_entry);
        if ( $queue_entry[MSG_SEVERITY] <= $this->error_condition_trigger_thresh )
        {
            $this->in_error_condition = TRUE;
            $this->flush_queue();
            $this->in_error_condition = FALSE;
            return;
        }
        $queue_has_messages = TRUE;
        while ( ( ( sizeof ( $this->messages ) > $this->max_queue_size ) | ( !$this->queue_mode ) ) & ( $queue_has_messages ) )
        {
            $queue_has_messages = $this->flush_msg();
        }
        return;
    }
        
    function flush_msg()
    {
        $entry = array_shift ($this->messages);
        if ($entry === NULL)
        {
            return (FALSE);
        }
        if ( $entry[MSG_FORCE] )
        { // Message was requested to be forced regardless of thresholds
            $this->type_specific_output_msg($entry);
            return (TRUE);
        }
        if ( $this->in_error_condition )
        {
            $threshold = $this->error_condition_thresh;
        }
        else
        {
            $threshold = $this->thresh;
        }
        if ( $entry[MSG_SEVERITY] <= $threshold )
        {
            $this->type_specific_output_msg($entry);
            return (TRUE);
        }
        // Message did not meet any output criteria - but we did get a message off the queue so return true
        return (TRUE);
    }

    function log_entry($force, $category, $severity, $msg)
    {
        if ( !$this->instance_is_open )
        {
            $this->open();
        }
        $entry = array (    MSG_FORCE       =>  $force,
                            MSG_CATEGORY    =>  $category,
                            MSG_SEVERITY    =>  $severity,
                            MSG_MSG         =>  $msg
                        );
        $this->queue_msg($entry);
    }

    function flush_queue()
    {
        do
        {
            $result = $this->flush_msg();
        } while ($result);
    }

    function close()
    {
        if ( $this->instance_is_open )
        {
            $this->flush_queue();
            $this->type_specific_close();
            $this->instance_is_open = FALSE;
            return (TRUE);
        }
        else
        {
            // Well - we were already closed so nevermind
            return (TRUE);
        }
    }
    function write_logger_log($msg)
    {
        $this->parent_logger_instance->write_logger_log($msg);
    }
}

class syslog_log_instance extends log_instance
{
    var $facility;

    function syslog_log_instance(&$parent_logger_instance, $parent_application)
    {
        parent::log_instance (&$parent_logger_instance, $parent_application);
        $this->syslog_set_facility ( DEFAULT_SYSLOG_FACILITY );
        $this->queue_mode = FALSE;
        $this->type = "syslog";
    }
    
    function enable_queue_mode()
    { // Queue mode is not valid for this queue type
        $msg = sprintf ("Attempt to enable queueing mode for log instance of type syslog\n");
        $this->write_logger_log($msg);
        return (FALSE);
    }
    
    function syslog_set_facility( $facility )
    {
        $this->facility = $facility;
        $this->needs_reset = TRUE;
    }

    function type_specific_reset()
    {
    }

    function type_specific_open()
    {
        openlog ($this->parent_application, LOG_ODELAY | LOG_PID | LOG_CONS, $this->facility );
        return ( TRUE );
    }

    function type_specific_output_msg($entry)
    {
        // We have to pull this out because php doesn't like to use an array as an index to another array
        $severity = $entry[MSG_SEVERITY];
        syslog ($severity,  str_pad($entry[MSG_CATEGORY], 13).str_pad($this->syslog_levels[$severity], 13).$entry[MSG_MSG]);
    }

    function type_specific_close()
    {
        return ( closelog() );
    }

}

class console_log_instance extends log_instance
{
    var $break_character;

    function console_log_instance(&$parent_logger_instance, $parent_application)
    {
        parent::log_instance (&$parent_logger_instance, $parent_application);
        $this->break_character = "";
        $this->queue_mode = FALSE;
        $this->type = "console";
    }
    
    function enable_queue_mode()
    { // Queue mode is not valid for this queue type
        $msg = sprintf ("Attempt to enable queueing mode for log instance of type console\n");
        $this->write_logger_log($msg);
        return (FALSE);
    }
    
    function console_set_web ( )
    {
        $this->break_character = "<br>";
    }

    function type_specific_reset()
    {
    }

    function type_specific_open()
    {
        return ( TRUE );
    }

    function type_specific_output_msg($entry)
    {
        // We have to pull this out because php doesn't like to use an array as an index to another array
        $severity = $entry[MSG_SEVERITY];
        echo str_pad($entry[MSG_TIME], 36).str_pad($entry[MSG_CATEGORY], 13).str_pad($this->syslog_levels[$severity], 13).$entry[MSG_MSG].$this->break_character."\n";
    }

    function type_specific_close()
    {
    }

}


class email_log_instance extends log_instance
{
    var $recipient;
    var $sender;
    var $subject;
    var $mailbody;

    function email_log_instance (&$parent_logger_instance, $parent_application)
    {
        parent::log_instance (&$parent_logger_instance, $parent_application);
        $this->email_set_recipient ( DEFAULT_EMAIL_RECIPIENT );
        $this->email_set_sender ( DEFAULT_EMAIL_SENDER );
        $this->email_set_subject ( DEFAULT_EMAIL_SUBJECT );
        $this->type = "email";
    }
    
    function email_set_recipient ( $recipient )
    {
        $this->recipient = $recipient;
        $this->needs_reset = TRUE;
    }

    function email_set_sender ( $sender )
    {
        $this->sender = $sender;
        $this->needs_reset = TRUE;
    }

    function email_set_subject ( $subject )
    {
        $this->subject = $subject;
        $this->needs_reset = TRUE;
    }

    function type_specific_reset()
    {
    }

    function type_specific_open()
    {
        unset ($this->mailbody);
        return ( TRUE );
    }

    function type_specific_output_msg($entry)
    {
        $severity = $entry[MSG_SEVERITY];
        $this->mailbody .=  str_pad($entry[MSG_TIME], 36).str_pad($entry[MSG_CATEGORY], 13).str_pad($this->syslog_levels[$severity], 13).$entry[MSG_MSG]."\n";
    }

    function type_specific_close()
    {
        if(!mail($this->recipient, $this->subject, $this->mailbody, $this->sender, "-fjenelso2@wsc.edu"))
        {
            $msg = "EMAILING FAILED: to ".$this->recipient.", from ".$this->sender.", subject ".$this->subject.", body ".$this->mailbody;
            $this->write_logger_log($msg);
            return ( FALSE );
        }
        return ( TRUE );
    }

}

class local_log_instance extends log_instance
{
    var $logfile_path;
    var $logfile_name;
    var $logfile;
    var $mode;
    var $file_pointer;

    function local_log_instance(&$parent_logger_instance, $parent_application)
    {
        parent::log_instance (&$parent_logger_instance, $parent_application);
        $this->local_set_logfile_path(DEFAULT_LOCAL_LOGFILE_PATH);
        $this->local_set_logfile_name(DEFAULT_LOCAL_LOGFILE_NAME);
        $this->file_pointer = FALSE;
        $this->type = "local";
    }
    
    function local_set_logfile_mode ($mode)
    {
        $this->mode = $mode;
    }

    function local_set_logfile_name($logfile_name)
    {
        $this->filename = $logfile_name;
        $this->needs_reset = TRUE;
    }

    function local_set_logfile_path($logfile_path)
    {
        if ( substr ($logfile_path, strlen($logfile_path) - 1) !== "/" )
        {
            $logfile_path = $logfile_path."/";
        }
        $this->path = $logfile_path;
        $this->needs_reset = TRUE;
    }

    function type_specific_reset()
    {
        $this->log_file = $this->path.$this->filename;
    }

    function type_specific_open()
    {
        if (file_exists($this->log_file))
        {
            if ($this->mode == "ARCHIVE")
            {
                rename($this->log_file, $this->log_file.date("Ymd-Gis"));
            }
        }
        if ($this->file_pointer = fopen ($this->log_file, "a"))
        {
            $entry[MSG_TIME] = date("r");
            $entry[MSG_CATEGORY] = "LOGS";
            $entry[MSG_SEVERITY] = "INFO";
            $entry[MSG_MSG] = "LOG OPENED, REQUESTED BY APPLICATION ".$this->parent_application;
            $this->type_specific_output_msg($entry);
        }
        else
        {
            $log_error_msg = "Unable to open log file ".$logfile_name;
            parent::write_logger_log($log_error_msg);
            return (FALSE);
        }
        return (TRUE);
    }

    function type_specific_output_msg($entry)
    {
        // We have to pull this out because php doesn't like to use an array as an index to another array
        $severity = $entry[MSG_SEVERITY];
        fputs ($this->file_pointer, str_pad($entry[MSG_TIME], 36).str_pad($entry[MSG_CATEGORY], 13).str_pad($this->syslog_levels[$severity], 13).$entry[MSG_MSG]."\n");
    }

    function type_specific_close()
    {
        return ( fclose ($this->file_pointer) );
    }

}

class log_session
{
    var $parent_application;
    var $message_categories;
    var $syslog_levels;

    var $console_opened;
    var $console_msg_queue;
    var $console_queue_mode;

    var $email_opened;
    var $email_log_recipient;
    var $email_log_sender;
    var $email_log_subject;
    var $email_msg_queue;
    var $email_queue_mode;

// Constructor

    function log_session($parent_app)
    {
        $this->log_mode_array = explode(",", LOG_MODES_LIST);
        $this->message_categories = explode(",", MESSAGE_CATEGORIES_LIST);
        $this->syslog_levels = explode(",", SYSLOG_LEVELS_LIST);
        $this->parent_application = $parent_app;
    }

    function enable_log_instance($type)
    {
        switch ($type)
        {
            case "local":
                {
                    $this->log_instances[] = new local_log_instance(&$this, $this->parent_application);
                    $instance_index = sizeof ($this->log_instances) - 1;
                    break;
                }
            case "syslog":
                {
                    $this->log_instances[] = new syslog_log_instance(&$this, $this->parent_application);
                    $instance_index = sizeof ($this->log_instances) - 1;
                    break;
                }
            case "email":
                {
                    $this->log_instances[] = new email_log_instance(&$this, $this->parent_application);
                    $instance_index = sizeof ($this->log_instances) - 1;
                    break;
                }
            case "console":
                {
                    $this->log_instances[] = new console_log_instance(&$this, $this->parent_application);
                    $instance_index = sizeof ($this->log_instances) - 1;
                    break;
                }
            default:
                {
                    $this->write_logger_log("php-logger->enable_log_instance called with invalid instance type ".$type."\n");
                    return (FALSE);
                }
        }
        return ($instance_index);
    }

    function disable_log_instance($instance)
    {
        if ( is_num ($instance) )
        {
            if ( $instance < sizeof ($this->log_instances) )
            {
                $this->log_instances[$instance]->close();
            }
            else
            {
                $msg = sprintf ("php-logger->disable_log_instance called with non instantiated instance %s", $instance);
                $this->write_logger_log ($msg);
                return (FALSE);
            }
        }
        else
        {
            $msg = sprintf ("php-logger->disable_log_instance called with non integer parameter %s requires instance number", $instance);
            $this->write_logger_log ($msg);
            return (FALSE);
        }
    }
   


// Log entry function - meat and potatoes time

    function log_entry()
    {
        $numargs = func_num_args();

        $severity = NULL; //Just to ensure that we don't have bleedover between calls
        $category = FALSE;
        $good_args = TRUE;

        $override = array();

        switch ($numargs)
        {
            case 0:     $log_error_msg = "Function: log_entry called with no arguements, that's not good";
                        $this->write_logger_log($log_error_msg);    
                        $good_args = FALSE;
                        break;
    
            case 1:     $msg = func_get_arg(0);
                        break;

            default:    $args = func_get_args();
                        for ($i = 0; $i < sizeof($args)-1; $i++)
                        {
                            $good_arg = FALSE;
                            $arg = $args[$i];
                            if (ereg("[\+-].*", $arg)) // This conditional has to come before the severity test since "+/-[0-9]" return true for is_numeric
                            {
                                $action = substr($arg, 0, 1);
                                $requested_instance = substr($arg, 1);
                                for ($x = 0; $x < sizeof ($this->log_instances); $x++)
                                {
                                    $instance = &$this->log_instances[$x];
                                    // OK - this is stupid - but it's because PHP returns true on is_numeric ( string of ints) but does not return true on string of ints===ints
                                    if ( ( ( is_numeric ( $requested_instance ) )& ($requested_instance == $x ) ) | ( $requested_instance === $instance->get_instance_type() ) )
                                    {
                                        $override[$x] = "$action";
                                        $good_arg = TRUE;
                                    }
                                }
                                if (!$good_arg)
                                {
                                    $msg = sprintf ("instance override requested for non enabled instance %s with action %s\n", $requested_instance, $action);
                                    $this->write_logger_log($msg);
                                }
                            }
                            elseif ((is_numeric($arg))&&($arg < 8)) // numeric values < 8 are always interpreted as syslog sev levels
                            {
                                if ($severity)
                                {
                                    $log_error_msg = "Severity was already set - cannot reset!";
                                    $this->write_logger_log($log_error_msg);
                                    $good_arg = FALSE;
                                }
                                else
                                {
                                    $severity = $arg;
                                    $good_arg = TRUE;
                                }
                            }
                            else
                            {
                                foreach ($this->message_categories as $message_category)
                                {
                                    if ($arg == $message_category)
                                    {
                                        $category = $arg;
                                        $good_arg = TRUE;
                                    }
                                }    
                            }
                            if (!$good_arg)
                            {
                                $good_args = FALSE;
                            }
                        }
                        $msg = $args[sizeof($args)-1];
                        break;
        }
        if (!$good_args)
        {
            $log_error_msg = "";
            $log_error_msg .= str_pad(date("r"), 36)." LOGGER CALLED WITH BAD ARGUMENTS from application ".$this->parent_application."\n";
            for ($i = 0; $i < sizeof($args); $i++)
            {
                $log_error_msg .= "\tArguement #".$i." => ".$args[$i]."\n";
            }
            $this->write_logger_log($log_error_msg);
        }

        if (!$category)
        {
            $category = "OTHER";
        }
    
        if ( $severity === NULL )
        {
            $severity = DEFAULT_MSG_SEVERITY;
        }

        for ( $i = 0; $i < sizeof ($this->log_instances); $i++ )
        {
            $force = FALSE;
            if ( $override[$i] == "+" )
            {
                $force = TRUE;
            }
            if ( !( $override[$i] == "-" ) )
            {
                $this->log_instances[$i]->log_entry ($force, $category, $severity, $msg);
            }
            else
            {
            }
        }
    }

// End log entry function - meat and potatoes time is over

    function configure_instance ()
    {
        $found_valid_instance = FALSE;

        $args = func_get_args();
        if ( sizeof( $args ) < 2 )
        {
            $msg = sprintf ("Configure instance requires at least 2 arguments - received %s", array_to_string($args));
            return (FALSE);
        }

        $requested_instance = array_shift ($args);
        $function = array_shift ($args);
        $params = array_shift ($args);
        while ($param_temp = array_shift ($args) )
        {
            $params .= ", ".$param_temp;
        } 

        for ($i = 0; $i < sizeof ($this->log_instances); $i++)
        {
            $instance = &$this->log_instances[$i];
            if ( ( $requested_instance === $i ) | ( $requested_instance === $instance->get_instance_type() ) )
            { // OK - either the requested instance was one of our types or it was an integer for a particular instance
                if ( method_exists ($instance, $function) )
                {
                    $instance->$function($params);
                    $found_valid_instance = TRUE;
                }
                else
                {
                    $msg = sprintf ("Attempt to use a non existant configuration %s function for logger instance %s\n", $function, $requested_instance);
                    $this->write_logger_log($msg);
                    return (FALSE);
                }
            }
        }
        if ( !$found_valid_instance )
        {
            $msg = sprintf ("Attempt to modify a non existant logger instance %s\n", $requested_instance);
            $this->write_logger_log($msg);
            return (FALSE);
        }
        else
        {
            return (TRUE);
        }
    }

// Function to log the logger - YIKES!

    function write_logger_log($msg)
    {
        echo ('LOGGER'.CRITICAL.$msg);
        openlog ("LOGGER", LOG_ODELAY | LOG_PID | LOG_CONS, DEFAULT_LOGGER_LOG_FACILITY );
        syslog (CRITICAL, str_pad("LOGGER", 13).str_pad("CRITICAL", 13).$msg);
        // closelog();
    }

// Function to close all open logs

    function close_log()
    {
        foreach($this->log_instances as $instance)
        {
            $instance->close();
        }
    }
}

// Nifty little function to convert and array to a printable string for log inclusion

function array_to_string ($message_array)
{
    ob_start();
    print_r ($message_array);
    $message_string = ob_get_contents();
    ob_end_clean();
    return ($message_string);
}

?>
