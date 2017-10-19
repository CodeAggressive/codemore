<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>斗信</title>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0 user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="format-detection" content="telephone=no, email=no"/>
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="portrait"/>
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait"/>
    <link rel="dns-prefetch" href="//ld-kj.cn"/>
    <!-- 不缓存页面 -->
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <!-- <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="Wed, 26 Feb 1997 08:21:57 GMT">
    <meta HTTP-EQUIV="expires" CONTENT="0">-->
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="css/jquery.mobile.emotion.4.css" type="text/css" rel="stylesheet">
    <link href="js/swiper-3.3.1.min.css" type="text/css" rel="stylesheet">
    <link href="js/webuploader-0.1.5/webuploader.css" type="text/css" rel="stylesheet">
    <link href="css/components.7.css" type="text/css" rel="stylesheet">
    <link href="css/chatroom.21.css" type="text/css" rel="stylesheet">
    <link href="css/page.14.css" type="text/css" rel="stylesheet">
    <link href="js/sweetalert.css" type="text/css" rel="stylesheet">
    <link href="css/friend.circle.4.css" type="text/css" rel="stylesheet">
    <link href="css/jquery.mobile.uploader.11.css" type="text/css" rel="stylesheet">
</head>
<body>
<!-----  注册界面 ----->
<div class="page" id="page-2">
    <div class="register-pane">
        <div class="pane-top">
            <div class="thumbnail-container"></div>
            <!-- <img class="thumbnail" src="img/thumbnail.png"/>-->
            <div class="thumbnail-blur"></div>
            <div class="thumbnail-opacity"></div>
            <div class="thumbnail-view"></div>
            <div class="thumbnail-tip">
                <button class="thumbnail-file-picker">选取头像</button>
                <input type="file" name="file" id="file" accept="image/*">
            </div>
            <button class="thumbnail-save">保存头像</button>
        </div>
        <div class="pane-bottom">
            <div class="ld-row">
                <label class="ld-col-1">用户昵称</label>
                <input type="text" id="nickname" minlength="2" maxlength="8" class="form-control ld-col-max"
                       placeholder="请输入2~8个字符"/>
            </div>
            <div class="ld-row">
                <label class="ld-col-1">手机号码</label>
                <input type="tel" id="mobile" minlength="11" maxlength="11" class="form-control ld-col-mid"
                       placeholder="请输入手机号码"/>
                <button class="btn btn-primary ld-col-min" id="get-verify-code">获取验证码</button>
            </div>
            <div class="ld-row">
                <label class="control-label ld-col-1">短信验证</label>
                <input class="form-control ld-col-max" id="verify-code" type="tel"/>
            </div>
            <div class="ld-row">
                <button class="ld-col-full btn btn-primary btn-lg" id="register-btn">注&nbsp;&nbsp;&nbsp;册</button>
            </div>
        </div>
    </div>
</div>
<!-----  斗信首页   ----->
<div class="page" id="page-index">
    <div class="ld-tab tab-notice">
        <div class="tab-notice-inner"></div>
    </div> <!-- 消息通知 --->
    <div class="ld-tab tab-relation">
        <div class="icon-btn-wrapper">
            <div class="icon-btn" id="btn-follow">
                <div class="icon"></div>
                <div class="text">特别关注</div>
            </div>
            <div class="icon-btn" id="btn-group">
                <div class="icon"></div>
                <div class="text">群组</div>
            </div>
            <div class="icon-btn" id="btn-friend-circle">
                <div class="icon"></div>
                <div class="text">朋友圈</div>
            </div>
        </div>
        <div id="arul-wrapper">
            <div id="all_register_user_list">
            </div>
        </div>
    </div>
    <!----- 关于我 ----->
    <div class="ld-tab tab-me">
        <div class="ud-top">
            <div class="user-avatar"></div>
            <div class="user-info">
                <div class="user-name"></div>
                <div class="user-leader-id"></div>
                <div class="user-mobile"></div>
            </div>
        </div>
        <div class="ud-bottom">
            <div class="ud-item user-company">
                <div>公司</div>
                <div class="sub-item-2"></div>
            </div>
            <div class="ud-item user-job">
                <div>职位</div>
                <div class="sub-item-2"></div>
            </div>
            <div class="ud-item user-field">
                <div>行业</div>
                <div class="sub-item-2"></div>
            </div>
            <div class="ud-item user-register-time">
                <div>注册时间</div>
                <div class="sub-item-2"></div>
            </div>
        </div>
        <div class="eud-bottom">
            <div class="ud-item user-company">
                <div>公司</div>
                <div class="sub-item-2"></div>
                <div class="edit-arrow"></div>
                <input type="hidden" value="c_modify_user_company"/></div>
            <div class="ud-item user-job">
                <div>职位</div>
                <div class="sub-item-2"></div>
                <div class="edit-arrow"></div>
                <input type="hidden" value="c_modify_user_job"/></div>
            <div class="ud-item user-field">
                <div>行业</div>
                <div class="sub-item-2"></div>
                <div class="edit-arrow"></div>
                <input type="hidden" value="c_modify_user_field"/></div>
            <div class="ud-item user-register-time">
                <div>注册时间</div>
                <div class="sub-item-2"></div>
            </div>
        </div>
		<!--<div class="yd_public">
            <div class="yd_public_t1">一斗公众号</div>
            <div class="yd_public_t2">长按二维码<br/>关注公众号</div>
		<img src="img/yidou.public.jpg"/>
		</div>-->
    </div> <!-- 我 -->
    <div class="ld-tab-head">
        <div class="tab-btn">
            <div class="tab-btn-icon"></div>
            <div class="tab-btn-text">斗信</div>
        </div>
        <div class="tab-btn">
            <div class="tab-btn-icon"></div>
            <div class="tab-btn-text">通讯录</div>
        </div>
        <div class="tab-btn">
            <div class="tab-btn-icon"></div>
            <div class="tab-btn-text">我</div>
        </div>
    </div>
</div>
<!-----  查看用户资料  ----->
<div class="page" id="page-user-detail">
    <div class="ud-top">
        <div class="user-avatar"></div>
        <div class="user-info">
            <div class="user-name"></div>
            <div class="user-leader-id"></div>
            <div class="user-mobile"></div>
        </div>
    </div>
    <div class="ud-bottom">
        <div class="ud-item user-company">
            <div>公司</div>
            <div class="sub-item-2"></div>
        </div>
        <div class="ud-item user-job">
            <div>职位</div>
            <div class="sub-item-2"></div>
        </div>
        <div class="ud-item user-field">
            <div>行业</div>
            <div class="sub-item-2"></div>
        </div>
        <div class="ud-item user-register-time">
            <div>注册时间</div>
            <div class="sub-item-2"></div>
        </div>
    </div>
    <div class="eud-bottom">
        <div class="ud-item user-company">
            <div>公司</div>
            <div class="sub-item-2"></div>
            <div class="edit-arrow"></div>
            <input type="hidden" value="c_modify_user_company"/></div>
        <div class="ud-item user-job">
            <div>职位</div>
            <div class="sub-item-2"></div>
            <div class="edit-arrow"></div>
            <input type="hidden" value="c_modify_user_job"/></div>
        <div class="ud-item user-field">
            <div>行业</div>
            <div class="sub-item-2"></div>
            <div class="edit-arrow"></div>
            <input type="hidden" value="c_modify_user_field"/></div>
        <div class="ud-item user-register-time">
            <div>注册时间</div>
            <div class="sub-item-2"></div>
        </div>
    </div>
    <div class="btn-talk-with-user">发消息</div>
    <div class="btn-follow-user">特别关注</div>
    <div class="btn-unfollow-user">取消关注</div>
</div>
<!-----  修改用户资料  ----->
<div class="page" id="page-modify-text">
    <div><input type="text" malength="8" minlength="2" class="modify-text"/><input type="hidden" value="" class="modify-text-msg"/></div>
    <button id="save-modify-text-btn">保&nbsp;存&nbsp;修&nbsp;改</button>
</div>
<!-----  群通知 ------->
<div class="page" id="page-group-notice-list"></div>
<!-----  用户关注好友列表 ----->
<div class="page" id="page-user-follow-list">
    <div class="exist-user-follow">
        <div class="ufl-top">
        </div>
        <div class="ufl-bottom">
            <div class="btn-add-multi-follow ld-hilight-btn">添加特别关注好友</div>
        </div>
    </div>
    <div class="no-user-follow">
        <img src="img/no_user_follow.png"/>
        <div class="error-tip">你暂无特别关注好友</div>
        <div class="error-tip">将用户添加到特别关注,更方便查找。</div>
        <div class="btn-add-multi-follow ld-hilight-btn">添加特别关注好友</div>
    </div>
</div>
<!-----  用户加入的群组 ------->
<div class="page" id="page-groups">
    <div class="pg-top">

    </div>
    <div class="create-private-group-btn">
        创建私聊群
    </div>
</div>
<!-----  创建私聊群 ----->
<div class="page" id="page-create-private-group">
    <div class="cpg-top">
        <div class="ld-thumbnail-container"></div>
        <div class="ld-thumbnail-blur"></div>
        <div class="ld-thumbnail-opacity"></div>
        <div class="ld-thumbnail-view"></div>
        <div class="ld-thumbnail-tip">
            <button class="ld-thumbnail-file-picker">选取头像</button>
            <input type="file" name="file" class="ld-file" accept="image/*">
        </div>
        <button class="ld-thumbnail-save">保存头像</button>
    </div>
    <div class="cpg-bom">
        <div><input class="create-group-name" type="text" placeholder="群名称（2-8个字符）" minlength="2" maxlength="8"/></div>
        <div><textarea class="create-group-intro" placeholder="群介绍（6-60个字符）" minlength="6" maxlength="60"></textarea>
        </div>
        <div class="btn-finish-create-group">完成</div>
    </div>
</div>
<!----   添加多个关注用户 ----->
<div class="page" id="page-add-multi-follow">
    <div class="follow-list"></div>
    <div class="amf-bom">
        <div class="ld-fix-btn finish-add-multi-follow">完成</div>
    </div>
</div>
<!-----  群详情   ----->
<div class="page" id="page-group-detail">
    <input type="hidden" class="hidden-group-id" value=""/>
    <input type="hidden" class="hidden-group-name" value=""/>
    <div class="gd-group-avatar">
        <div></div>
        <img src=""/>
    </div>
    <div class="gd-group-btns">
        <div class="gd-btn gd-btn-announce-list" ><img class="icon" src="img/group_bullhorn.1.png"/>
            <div class="text">公告</div>
        </div>
        <div class="gd-btn gd-btn-image-list"><img class="icon" src="img/group-photo.1.png"/>
            <div class="text">相册</div>
        </div>
        <div class="gd-btn gd-btn-file-list"><img class="icon" src="img/group-folder.1.png"/>
            <div class="text">文件</div>
        </div>
    </div>
    <div class="gd-title gml-title">
        <span>群成员</span>
        <span></span>
    </div>
    <div class="gd-group-member-list">
        <div class="btn-invite-group-member"><img src="img/add.png"/>
            <div>邀请</div>
        </div>
    </div>
    <div class="gd-title">
        <span>群介绍</span>
    </div>
    <div class="gd-group-intro">
    </div>
</div>
<!-----  群公告列表 ----->
<div class="page" id="page-group-announce-list"></div>
<!-----  新建群公告 ----->
<div class="page" id="page-new-group-announce">
    <input type="text" class="new-group-announce-title" placeholder="标题(必填),  4-30字" maxlength="30">
    <input type="hidden" class="hidden-group-id" value=""/>
    <textarea class="new-group-announce-content" placeholder="正文(必填), 15-300字" maxlength="300"></textarea>
    <div class="btn-finish-new-group-announce">完成</div>
</div>
<!-----  编辑群公告 ----->
<div class="page" id="page-group-edit-announce">
    <input type="text" class="edit-group-announce-title" placeholder="标题（必填），4-30字" maxlength="30">
    <input type="hidden" class="hidden-group-id" value=""/>
    <textarea class="edit-group-announce-content" placeholder="正文（必填），15-300字" maxlength="300"></textarea>
    <div class="btn-finish-edit-group-announce">完成</div>
</div>
<!-----  群相册列表 ----->
<div class="page" id="page-group-image-list"></div>
<!-----  上传群照片 ----->
<div class="page" id="page-upload-group-image">
    <input type="hidden" class="hidden-group-id"/>
    <input type="hidden" class="hidden-group-album-id" value="0"/>
    <div class="ugi-album"><span>群相册</span><span class="group-album-name">默认相册</span><span class="select-group-album"></span></div>
    <div class="ugi-container">
       <div class="upload-img-container">
            <div id="groupImageList" class="uploader-list"></div>
            <div class="upload-icon"><img src="img/add-pic.png"/>
                <div class="filePicker" id="group-file-picker"></div>
            </div>
        </div>
    </div>
    <div class="btn-finish-upload-group-image">
        上传
    </div>
</div>
<!-----  新建群相册 ----->
<div class="page" id="page-new-group-album">
    <input type="hidden" class="hidden-group-id">
    <div class="nga-wrapper">
        <div><input class="nga-album-name" type="text" placeholder="请输入相册名称(必填), 10字以内" maxlength="10"/></div>
        <div><input class="nga-album-desc" type="text" placeholder="请输入相册描述(必填), 50字以内" maxlength="50"/></div>
    </div>
    <div class="btn-finish-new-group-album">
        完成
    </div>
</div>
<!-----  群相册列表 ----->
<div class="page" id="page-group-album-list"></div>
<!-----  群文件列表 ----->
<div class="page" id="page-group-file-list"></div>
<!-----  上传群文件 ----->
<div class="page" id="page-upload-group-file">
    <input type="hidden" class="hidden-group-id">
    <div class="ugf-container">
        <div class="upload-file-container">
            <div id="groupFileList" class="uploader-list"></div>
            <div class="upload-file">
                <div class="g-file-picker">添加文件</div>
            </div>
        </div>
    </div>
</div>
<!-----  邀请新成员 ----->
<div class="page" id="page-invite-new-group-member">
    <input type="hidden" class="invite-grp-id" value=""/>
    <input type="hidden" class="invite-grp-name" value=""/>
    <input type="hidden" class="invite-grp-avatar" value=""/>
    <div class="invite-group-member-list"></div>
    <div class="amf-bom">
        <div class="ld-fix-btn finish-invite-group-member">完成</div>
    </div>
</div>
<!-----  发表朋友圈说说  ----->
<div class="page" id="page-publish-circle">
    <div class="publish-circle-text" contenteditable="true" placeholder="说点什么吧...">
    </div>
    <div class="publish-circle-release">
        <div class="ld-icon-btn-group">
            <div class="ld-icon-btn"></div>
            <div class="ld-icon-btn"></div>
        </div>
        <button class="btn-public-circle" id="publish-circle-btn">发表</button>
    </div>
    <div class="publish-circle-image">
         <div class="upload-img-container">
            <div id="circlefileList" class="uploader-list"></div>
            <div class="upload-icon"><img src="img/add-pic.png"/>
                <div class="filePicker" id="file-picker"></div>
            </div>
        </div>
    </div>
    <div class="circle-emotion">
    </div>
</div>
<!----- third party plugin ----->
<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/web_socket.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/webuploader-0.1.5/webuploader.js"></script>
<script type="text/javascript" src="js/jqthumb.min.js"></script>
<script type="text/javascript" src="js/hammer.js"></script>
<script type="text/javascript" src="js/iscroll-zoom.js"></script>
<script type="text/javascript" src="js/jquery.photoClip.min.js"></script>
<script type="text/javascript" src="js/iscroll-probe.js"></script>
<!----- the index of iscroll-probe is very important ----->
<script type="text/javascript" src="js/swiper-3.3.1.jquery.min.js"></script>
<!----- global var & function ----->
<script type="text/javascript" src="js/global.vars.js"></script>
<script type="text/javascript" src="js/util.5.js"></script>
<!----- module ----->
<script type="text/javascript" src="js/chatroom.class.js"></script>
<script type="text/javascript" src="js/friend.circle.4.js"></script>
<script type="text/javascript" src="js/jquery.group.uploader.js"></script>
<script type="text/javascript" src="js/jquery.mobile.emotion.2.js"></script>
<script type="text/javascript" src="js/jquery.icon.btn.js"></script>
<script type="text/javascript" src="js/index.31.js"></script>
</body>
</html>
