SELECT * FROm `yd_user`;
SELECT * FROM `yd_group`;
select * From yd_groupmsg;
SELECT * FROM yd_user;


UPDATE `yd_user` SET avatar = REPLACE(avatar,'101.233.153.174','192.168.1.109');


SELECT A.id as chat_id,A.msg_content AS chat,A.send_time AS chat_time, 
 C.user_name AS name,C.leader_id,C.avatar FROM `yd_groupmsg` AS A
 LEFT JOIN `yd_group` AS B ON A.group_id = B.group_id
 LEFT JOIN `yd_user` AS C ON A.sender_id = C.leader_id WHERE 
                    A.group_id =10000 AND A.id > (SELECT MAX(id) FROM `yd_groupmsg`) -15;

SELECT MAX(id) FROM `yd_groupmsg` WHERE send_time < "2016-03-02 14:28:38";


SELECT A.id,A.msg_content AS chat, A.send_time AS chat_time,
                    C.user_name AS name, C.leader_id, C.avatar FROM `yd_groupmsg` AS A
                    LEFT JOIN `yd_group` AS B ON A.group_id = B.group_id
                    LEFT JOIN `yd_user` AS C ON A.sender_id = C.leader_id  WHERE A.send_time > "2016-03-02 12:00:00" AND
                     A.group_id = 10000 AND A.id < 33;