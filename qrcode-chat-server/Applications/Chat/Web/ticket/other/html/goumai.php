<!DOCTYPE html>
<html>
<head>
    <title>购买门票</title>
    <script src="../js/dengbili.js" type="text/javascript"></script>
    <meta content="telephone=no" name="format-detection" />   <!--去除iPhone端默认数字为a-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <!--编码格式-->
    <meta name="viewport" content="initial-scale=1,maximum-scale=1, minimum-scale=0.5">
    <meta name="format-detection" content="telephone=no">
    <link href="../css/global.css" type="text/css" rel="stylesheet"> <!--公共CSS-->
    <link href="../css/goumai.css" type="text/css" rel="stylesheet"> <!--css-->
    <script src="../js/zepto.min.js" type="text/javascript"></script>
    <script src="../js/fastclick.js" type="text/javascript"></script>
</head>
<body>
<div id="image">
    <img src="../image/3-2_02.png"/>
    <div id="notice">
        <span class="chebox po"></span>
        <input type="hidden" id="che">
        <label for="che" class="xieyi">我已阅读并同意<a href="../html/goupiaoxuzhi.php">购票须知</a></label>
    </div>
</div>
<!--票型 -->
<div id="piao_type">
    <p id="title_type">选择票型</p>
    <ul>
        <li id="red_position">
            <div class="center">
                <div class="center_left">
                    <p>￥<span class="pic">1200.00</span> /一张</p>
                    <p class="queyu">体育场红色座位区域</p>
                    <span class="jian">-</span>
                    <span class="sum">1</span>
                    <span class="jia">+</span>
                    <label class="lianpiao">连票</label>
                </div>
                <div class="center_right">
                    <input type="button" value="确认购买" class="bg_red" >
                </div>
            </div>
        </li>
        <li id="orange_position">
            <div class="center">
                <div class="center_left">
                    <p>￥<span class="pic">1200.00</span> /一张</p>
                    <p class="queyu">体育场红色座位区域</p>
                    <span class="jian">-</span>
                    <span class="sum">1</span>
                    <span class="jia">+</span>
                    <label class="lianpiao">连票</label>
                </div>
                <div class="center_right">
                    <input type="button" value="确认购买" class="bg_orange" >
                </div>
            </div>
        </li>
        <li id="violet_position">
            <div class="center">
                <div class="center_left">
                    <p>￥<span class="pic">1200.00</span> /一张</p>
                    <p class="queyu">体育场红色座位区域</p>
                    <span class="jian">-</span>
                    <span class="sum">1</span>
                    <span class="jia">+</span>
                    <label class="lianpiao">连票</label>
                </div>
                <div class="center_right">
                    <input type="button" value="确认购买" class="bg_violet" >
                </div>
            </div>
        </li>
        <li id="green_position">
            <div class="center">
                <div class="center_left">
                    <p>￥<span class="pic">1200.00</span> /一张</p>
                    <p class="queyu">体育场红色座位区域</p>
                    <span class="jian">-</span>
                    <span class="sum">1</span>
                    <span class="jia">+</span>
                    <label class="lianpiao">连票</label>
                </div>
                <div class="center_right">
                    <input type="button" value="确认购买" class="bg_green" >
                </div>
            </div>
        </li>
        <li id="blue_position">
            <div class="center">
                <div class="center_left">
                    <p>￥<span class="pic">1200.00</span> /一张</p>
                    <p class="queyu">体育场红色座位区域</p>
                    <span class="jian">-</span>
                    <span class="sum"></span>
                    <span class="jia">+</span>
                    <label class="lianpiao">连票</label>
                </div>
                <div class="center_right">
                    <input type="button" value="确认购买" class="bg_blue" >
                </div>
            </div>
        </li>
    </ul>
</div>
<!--票型end -->
</body>
<script>
    $(function(){
        $(".chebox").click(function(){
            $(".chebox").toggleClass("position")
        });
        $(".jian").each(function(){
            $(this).click(function(){
               var sum=$(this).next().text();
                if(sum<=1){
                    return
                }
               $(this).next().text((sum*1)-1);
            });
        });
        $(".jia").each(function(){
            $(this).click(function(){
                var sum=$(this).prev().text();
                if(sum>=9){
                    return
                }
                $(this).prev().text((sum*1)+1);
            });
        });
    });
</script>
</html>