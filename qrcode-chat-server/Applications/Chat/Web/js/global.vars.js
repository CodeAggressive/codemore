
/*********** 消息类型 ****************/
var MSG_C_PING = "pong" //心跳数据包
var MSG_S_PING = "ping"; //服务器ping客户端心跳数据包
var MSG_C_REGISTER = "c_register"; //用户注册
var MSG_S_REGISTER = "s_register"; //用户注册
var MSG_C_LOGIN_IN = "c_login_in"; //用户登录
var MSG_S_LOGIN_IN = "s_login_in"; //用户登录
var MSG_C_LOGIN_OUT = "c_login_out"; //用户退出
var MSG_S_LOGIN_OUT = "s_login_out"; //用户退出
var MSG_C_GROUP_LIST = "c_group_list"; //获取加入的群列表
var MSG_S_GROUP_LIST = "s_group_list"; //获取加入的群列表
var MSG_C_GROUP_MEMBER_LIST = "c_group_member_list"; //群组用户列表
var MSG_S_GROUP_MEMBER_LIST = "s_group_member_list"; //获取所有用户列表
var MSG_C_ALL_REGISTER_USER_LIST = "c_all_register_user_list"; //获取群成员列表
var MSG_S_ALL_REGISTER_USER_LIST = "s_all_register_user_list"; //获取群成员列表
var MSG_C_GENERAL_CONTACTS = "c_general_contacts"; //获取常见联系人
var MSG_S_GENERAL_CONTACTS = "s_general_contacts"; //获取常见联系人
var MSG_C_GROUP_CHAT = "c_group_chat"; //群里发言
var MSG_S_GROUP_CHAT = "s_group_chat"; //群里发言
var MSG_C_USER_CHAT = "c_user_chat"; //私聊
var MSG_S_USER_CHAT = "s_user_chat"; //私聊
var MSG_S_GROUP_NOTICE_LIST = 's_group_notice_list'; //群通知列表
var MSG_C_GROUP_NOTICE_LIST = "c_group_notice_list"; //群通知列表
var MSG_C_GROUP_CHAT_HISTORY = "c_group_chat_history"; //群聊历史记录
var MSG_S_GROUP_CHAT_HISTORY = "s_group_chat_history"; //群聊历史记录
var MSG_C_USER_CHAT_HISTORY = "c_user_chat_history"; //私聊历史记录
var MSG_S_USER_CHAT_HISTORY = "s_user_chat_history"; //私聊历史记录
var MSG_C_USER_DETAIL = "c_user_detail"; //用户详细资料
var MSG_S_USER_DETAIL = "s_user_detail"; //用户详细资料
var MSG_C_ABOUT_ME = "c_about_me"; //关于自己的资料
var MSG_S_ABOUT_ME = "s_about_me"; //关于自己的资料
var MSG_C_MODIFY_USER_COMPANY = "c_modify_user_company"; //修改用户公司
var MSG_S_MODIFY_USER_COMPANY = "s_modify_user_company"; //修改用户企业
var MSG_C_MODIFY_USER_JOB = "c_modify_user_job"; //修改用户工作
var MSG_S_MODIFY_USER_JOB = "s_modify_user_job"; //修改用户工作
var MSG_C_MODIFY_USER_FIELD = "c_modify_user_field"; //修改用户行业
var MSG_S_MODIFY_USER_FIELD = "s_modify_user_field"; //修改用户行业
var MSG_C_UNREAD_GROUP_CHAT_LIST = "c_unread_group_chat_list"; //未读群消息列表
var MSG_S_UNREAD_GROUP_CHAT_LIST = "s_unread_group_chat_list"; //未读群消息列表
var MSG_C_UNREAD_USER_CHAT_LIST = "c_unread_user_chat_list"; //未读用户消息列表
var MSG_S_UNREAD_USER_CHAT_LIST = "s_unread_user_chat_list"; //未读用户消息列表
var MSG_C_USER_FOLLOW_LIST = "c_user_follow_list"; //用户关注列表
var MSG_S_USER_FOLLOW_LIST = "s_user_follow_list"; //用户关注列表
var MSG_C_CREATE_PRIVATE_GROUP = "c_create_private_group"; //创建私聊群
var MSG_S_CREATE_PRIVATE_GROUP = "s_create_private_group"; //创建私聊群
var MSG_C_GROUP_DETAIL = "c_group_detail"; //获取群详细资料
var MSG_S_GROUP_DETAIL = "s_group_detail"; //获取群详细资料
var MSG_C_FOLLOW_SINGLE_USER = "c_follow_single_user"; //关注单个用户
var MSG_S_FOLLOW_SINGLE_USER = "s_follow_single_user"; //关注单个用户
var MSG_C_UNFOLLOW_SINGLE_USER = "c_unfollow_single_user"; //取消关注单个用户
var MSG_S_UNFOLLOW_SINGLE_USER = "s_unfollow_single_user"; //取消关注单个用户
var MSG_C_FOLLOW_MULTI_USER = "c_follow_multi_user"; //关注多个用户
var MSG_S_FOLLOW_MULTI_USER = "s_follow_multi_user"; //关注多个用户
var MSG_C_UNFOLLOW_MULTI_USER = "c_unfollow_multi_user"; //取消关注多个用户
var MSG_S_UNFOLLOW_MULTI_USER = "s_unfollow_multi_user"; //取消关注多个用户
var MSG_C_USER_LIST_ABOUT_FOLLOW = "c_user_list_about_follow"; //可以关注的用户列表
var MSG_S_USER_LIST_ABOUT_FOLLOW = "s_user_list_about_follow"; //可以关注的用户列表
var MSG_C_RESET_UNREAD_USER_MSG = "c_reset_unread_user_msg"; //清空未读用户消息数据
var MSG_S_RESET_UNREAD_USER_MSG = "s_reset_unread_user_msg"; //清空未读用户消息数据
var MSG_C_RESET_UNREAD_GROUP_MSG = "c_reset_unread_group_msg"; //清空未读群消息数据
var MSG_S_RESET_UNREAD_GROUP_MSG = "s_reset_unread_group_msg"; //清空未读群消息数据
var MSG_C_INVITE_NEW_GROUP_MEMBER = "c_invite_new_group_member"; //邀请新群成员
var MSG_S_INVITE_NEW_GROUP_MEMBER = "s_invite_new_group_member"; //邀请新群成员
var MSG_C_USER_LIST_ABOUT_INVITE = "c_user_list_about_invite"; //邀请新成员入群时的操作
var MSG_S_USER_LIST_ABOUT_INVITE = "s_user_list_about_invite"; //邀请新成员入群时的操作
var MSG_C_UNREAD_SYS_NOTICE = "c_unread_sys_notice"; //未读系统通知
var MSG_S_UNREAD_SYS_NOTICE = "s_unread_sys_notice"; //未读系统通知
var MSG_S_USER_NONE_EXIST = "s_user_none_exist"; //用户不存在
var MSG_S_NOTICE_JOIN_GROUP_SUCCESS = "s_notice_join_group_success"; //入群成功
var MSG_C_NEW_POST = "c_new_post"; //发布朋友圈说说
var MSG_S_NEW_POST = "s_new_post"; //发布朋友圈说说
var MSG_C_DELETE_POST = "c_delete_post"; //删除朋友圈说说
var MSG_S_DELETE_POST = "s_delete_post"; //删除朋友圈说说
var MSG_C_POST_FAVORITE = "c_post_favorite"; //朋友圈说说点赞
var MSG_S_POST_FAVORITE = "s_post_favorite"; //朋友圈说说点赞
var MSG_C_POST_UN_FAVORITE = "c_post_un_favorite"; //取消朋友圈说说点赞
var MSG_S_POST_UN_FAVORITE = "s_post_un_favorite"; //取消朋友圈说说点赞
var MSG_C_POST_REVIEW = "c_post_review"; //朋友圈说说评论
var MSG_S_POST_REVIEW = "s_post_review"; //朋友圈说说评论
var MSG_C_DELETE_POST_REVIEW = "c_delete_post_review"; //删除朋友圈说说评论
var MSG_S_DELETE_POST_REVIEW = "s_delete_post_review"; //删除朋友圈说说评论
var MSG_C_POST_IMG_FAVORITE = "c_post_img_favorite"; //朋友圈说说图片点赞
var MSG_S_POST_IMG_FAVORITE = "s_post_img_favorite"; //朋友圈说说图片点赞
var MSG_C_POST_IMG_UN_FAVORITE = "c_post_un_img_favorite"; //取消朋友圈说说图片点赞
var MSG_S_POST_IMG_UN_FAVORITE = "s_post_un_img_favorite"; //取消朋友圈说说图片点赞
var MSG_C_POST_IMG_REVIEW = "c_post_img_review"; //朋友圈说说图片评论
var MSG_S_POST_IMG_REVIEW = "s_post_img_review"; //朋友圈说说图片评论
var MSG_C_DELETE_POST_IMG_REVIEW = "c_delete_post_img_review"; //删除朋友圈说说图片评论
var MSG_S_DELETE_POST_IMG_REVIEW = "s_delete_post_img_review"; //删除朋友圈说说图片评论
var MSG_C_POST_LIST = "c_post_list"; //朋友圈说说列表
var MSG_S_POST_LIST = "s_post_list"; //朋友圈说说列表
var MSG_S_ERROR_MSG = "s_error_msg"; //发生错误了
var MSG_S_GROUP_ANNOUNCE_LIST = "s_group_announce_list"; //群公告列表
var MSG_C_GROUP_ANNOUNCE_LIST = "c_group_announce_list"; //群公告列表
var MSG_S_NEW_GROUP_ANNOUNCE = "s_new_group_announce";
var MSG_C_NEW_GROUP_ANNOUNCE = "c_new_group_announce";  //新建群公告
var MSG_C_EDIT_GROUP_ANNOUNCE = "c_edit_group_announce"; //编辑群公告
var MSG_C_DELETE_GROUP_ANNOUCE = "c_delete_group_announce"; //删除群公告
var MSG_S_GROUP_FILE_LIST = "s_group_file_list"; //群文件列表
var MSG_C_GROUP_FILE_LIST = "c_group_file_list"; //群文件列表
var MSG_S_GROUP_ALBUM_LIST = "s_group_album_list"; //群相册列表
var MSG_C_GROUP_ALBUM_LIST = "c_group_album_list"; //群相册列表
var MSG_S_GROUP_IMAGE_LIST = "s_group_image_list"; //群照片列表
var MSG_C_GROUP_IMAGE_LIST = "c_group_image_list"; //群照片列表
var MSG_C_AGREE_JOIN_NEW_GROUP = "c_agree_join_new_group"; //同意加入新群
var MSG_C_NEW_GROUP_ALBUM = 'c_new_group_album'; //新的群相册
var MSG_S_NEW_GROUP_ALBUM = 's_new_group_album'; //新的群相册
var MSG_C_UPLOAD_IMG_TO_GROUP_ALBUM = 'c_upload_img_to_group_album'; //上传群图片
var MSG_S_UPLOAD_IMG_TO_GROUP_ALBUM = 's_upload_img_to_group_album'; //上传群图片
var MSG_C_NEW_GROUP_FILE = 'c_new_group_file'; //上传群文件
var MSG_S_NEW_GROUP_FILE = 's_new_group_file'; //上传群文件

var MSG_S_NOTICE_GROUP = "s_notice_group"; //群通知


var  MSG_TYPE_NORMAL_CHAT = 1;
var  MSG_TYPE_SYSTEM = 2;
var  MSG_TYPE_REGISTER = 2;
var  MSG_TYPE_PICTURE = 4;
var  MSG_TYPE_VIDEO = 5;
var  MSG_TYPE_ATTACHMENT = 6;

// 可编辑列表
//可编辑列表项
var ELI_STATE_DISABLE = "disable";
var ELI_STATE_SELECTED = "select";
var ELI_STATE_UNSELECT = "unselect";
var ELI_TYPE_FOLLOW_LIST = "follow-list";
var ELI_TYPE_GROUP_MEMBER_LIST = "group-m-list";

/******** 首页消息通知类型 ***********/
var NOTICE_JOIN_GROUP_SUCCESS = "notice_jgs"; //新注册用户提示
var NOTICE_NEW_GROUP_ANNOUNCE = "notice_ngn"; //新群公告
var NOTICE_NEW_INVITE_JOIN_GROUP = "notice_nijg"; //邀请新加入群
var NOTICE_NEW_OTHER_FOLLOW_YOU = "notice_nofy"; //别的用户关注了你
var NOTICE_UNREAD_GROUP_CHAT = "notice_ugc";//未读群聊信息
var NOTICE_UNREAD_USER_CHAT = "notice_uuc";//未读用户聊天信息
var NOTICE_GROUP = 'notice_grp'; //群通知列表

/*********  群通知列表  ***************/
var GROUP_NOTICE_INVITE = 101; //群邀请
var GROUP_NOTICE_REMOVE = 102; //被移出群
var GROUP_NOTICE_JOIN = 103;   //入群申请通过

// 页面状态常量 PS is short for page state
var PS_INDEX = "index"; //首页
var PS_TAB_RELATION = "tab_relation"; //查看联系人
var PS_TAB_ME = "tab_me"; //查看我
var PS_GROUP_CHAT = "group_chat"; //群聊界面
var PS_USER_CHAT = "user_chat"; //群聊界面
var PS_GROUP_MEMBER_LIST = "group_member_list"; //群成员列表
var PS_GROUP_LIST = "group_list"; //群列表
var PS_USER_DETAIL = "user_detail"; //用户详细资料
var PS_MODIFY_gUserInfo = "modify_gUserInfo"; //修改用户资料
var PS_MODIFY_GROUP_INFO = "modify_group_info"; //修改群资料
var PS_USER_FOLLOW_LIST = "user_follow_list"; //用户关注列表
var PS_CREATE_PRIVATE_GROUP = "create_private_group"; //创建私密用户群
var PS_GROUP_DETAIL = "group_detail"; //查看群详情
var PS_FOLLOW_MULTI_USER = "follow_multi_user"; //关注多个用户
var PS_INVITE_NEW_GROUP_MEMBER = "invite_new_group_member"; //邀请新成员
var PS_PUBLISH_CIRCLE = "publish_circle"; //发表朋友圈
var PS_ALL_FRIEND_CIRCLE = "all_friend_cricle"; //进入所有人的朋友圈
var PS_SINGLE_FRIEND_CIRCLE = "single_friend_circle"; //进入单个人的朋友圈
var PS_GROUP_NOTICE_LIST = "group_notice_list"; //群通知列表
var PS_GROUP_ANNOUNCE_LIST = "group_announce_list"; //群公告列表
var PS_GROUP_IMAGE_LIST ="group_image_list"; //群照片列表
var PS_UPLOAD_GROUP_IMAGE = "upload_group_image"; //上传群照片
var PS_UPLOAD_GROUP_FILE  = "upload_group_file";  //上传群文件
var PS_NEW_GROUP_ALBUM = "new_group_album"; //新建群相册
var PS_ADD_NEW_GROUP_ANNOUNCE = "add_new_group_announce"; //添加群公告
var PS_GROUP_FILE_LIST = "group_file_list"; //群文件列表
var PS_GROUP_ALBUM_LIST ="group_album_list"; //群相册列表


// LeaderListItem 类型
var LLI_ALL_REGISTER_USER = "lli_all_register_user";
var LLI_ALL_USER_FOLLOW = "lli_all_user_follow";

var gPostId =0;