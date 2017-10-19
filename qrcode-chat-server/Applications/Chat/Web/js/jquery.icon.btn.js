/**
 * Created by Administrator on 16-4-2.
 */
(function ($) {
    $.fn.extend({
        "ldIconBtn": function (options) {
            var options = $.extend(defaults, options);
            initOptions = options;
            $this = $(this);
            activeBtn(options.initIndex);
        }
    });// end of emotion

    $(document).on("click",".ld-icon-btn",function(){
        var index = $(this).index();
        activeBtn(index);
    });

    var activeBtn = function(index){
        var $btns = $this.find(".ld-icon-btn");
        $btns.each(function(i,ele){
            $btns.eq(i).css("background",'url("'+initOptions.base+"/"+(initOptions.unactiveIcons)[i]+'.png") no-repeat');
        });
        $btns.eq(index).css("background",'url("'+initOptions.base+"/"+(initOptions.activeIcons)[index]+'.png") no-repeat');
        $btns.css("background-size","100% 100%");
        if(initOptions.callback){
            initOptions.callback(index);
        }
    }
    var defaults = {
        callback:null,
        unactiveIcons:[],
        activeIcons:[],
        initIndex:0,
        base:'',
    };
    var initOptions = {};
    var $this = null;
})(jQuery);