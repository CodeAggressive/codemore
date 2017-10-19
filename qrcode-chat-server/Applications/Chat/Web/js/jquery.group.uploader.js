var gilContainer = [];
var gFileUUID = [];
var gGroupFileInfo = [];
$(function () {
    $(document).on('click', "#page-upload-group-image .delete-w-thumb", function () {
        var fileId = $(this).siblings(".file-item").attr("id");
        console.log($(this).siblings(".file-item"));
        groupUploader.removeFile(fileId, true);
        var idx = $(this).parent().index();
        $(this).parent().remove();

        if ($(".thumbnail-container").length < MAX_UPLOAD_COUNT) {
            $(".upload-icon").css("display", "block");
        }
    });
    var groupUploader = WebUploader.create({
        auto: true, // 选完文件后，是否自动上传。
        quality: 90,// 图片质量，只有type为`image/jpeg`的时候才有效。
        duplicate: true,
        allowMagnify: false, // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
        preserveHeaders: true, // 是否保留头部meta信息。
        fileNumLimit: 6, //验证文件总数量, 超出则不允许加入队列。
        // swf文件路径
        swf: 'js/webuploader-0.1.5/Uploader.swf',
        server: 'groupImageUpload.php',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {id: '#group-file-picker', multiple: true},
        accept: {   // 只允许选择图片文件。
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        sendAsBinary: false,
        thumb: {
            width: thumbnailWidth,
            height: thumbnailHeight,
            quality: 90, // 图片质量，只有type为`image/jpeg`的时候才有效。
            allowMagnify: false, // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
            crop: true,// 是否允许裁剪。
            type: 'image/png'
        }
    });
    groupUploader.on('fileQueued', function (file) {
        var $li = $(
                '<div class="w-thumb-container">' +
                '<input class="file-url" type="hidden" value=""/>' +
                '<div id="' + file.id + '" class="file-item w-thumbnail">' +
                '<img class="w-thumb-img">' +
                '</div>' +
                '<div class="delete-w-thumb"><img src="img/delete.png"/></div>' +
                '<div class="pic-progress"><span></span></div>'),
            $img = $li.find('.w-thumb-img'),
            $delete = $li.find(".delete-w-thumb");

        // $list为容器jQuery实例
        $("#groupImageList").append($li);
        if ($(".w-thumb-container").length == MAX_UPLOAD_COUNT) {
            $(".upload-icon").css("display", "none");
        }
        groupUploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr('src', src);
            $img.jqthumb({
                width: thumbnailWidth,
                height: thumbnailHeight
            });
            $delete.show();
        });
    });
    groupUploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#' + file.id),
            $percent = $li.siblings('.pic-progress span');
        $percent.empty().append($percent * 100 + '%');
    });
    groupUploader.on('uploadSuccess', function (file, response) {
        $('#' + file.id).addClass('upload-state-done');
        var $li = $('#' + file.id);
        gilContainer[response.id] = response.dest_path;
        $li.siblings('.pic-progress').hide();
    });
    groupUploader.on('uploadStart', function (file) {
        var uuid = Now() + "_" + file.id;
        groupUploader.option('formData', {
            uuid: uuid
        });
    });
    groupUploader.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }

        $error.text('上传失败');
    });
    groupUploader.on('uploadComplete', function (file) {
        $('#' + file.id).find('.progress').remove();
    });

    /***************************
     * 群文件上传
     **************************/
    var gFileUploader = WebUploader.create({
        auto: true, // 选完文件后，是否自动上传。
        fileNumLimit: 100, //验证文件总数量, 超出则不允许加入队列。
        // swf文件路径
        swf: 'js/webuploader-0.1.5/Uploader.swf',
        server: 'groupFileUpload.php',
        chunked: true,
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {id: '.g-file-picker', multiple: false},
        sendAsBinary: false,
        resize: false
    });
    gFileUploader.on('fileQueued', function (file) {
        var sname = file.name.toLowerCase();
        var filesize = WebUploader.Base.formatSize(file.size);
        var filetype = sname.substr(sname.lastIndexOf('.') + 1);
        var filename = sname.length > 24? sname.substr(0,24)+'...'+filetype:sname;
        gFileUUID[file.id] = WebUploader.Base.guid();
        var o = {
            'file_name':sname,
            'file_path':'',
            'file_size':filesize,
            'file_type':filetype
        }
        gGroupFileInfo[file.id]= o;
        console.log("filetype = " + filetype);
        var icon = GetUploadFileIcon(filetype);
        var $li = $(
            '<div class="w-file-container">' +
            '<input type="hidden" class="w-file-id-'+file.id+'" value="' + file.id + '"/>' +
            '<img class="w-file-icon" src="'+icon+'"/>' +
            '<div class="w-file-right">' +
            '<div class="w-file-name">' + filename + '</div>' +
            '<div class="w-file-size">' + filesize + '</div>' +
            '<div class="w-file-progress"><span></span></div></div></div>');
        // $list为容器jQuery实例
        $("#groupFileList").append($li);
        if ($(".w-thumb-container").length == MAX_UPLOAD_COUNT) {
            $(".upload-icon").css("display", "none");
        }
    });
    gFileUploader.on('uploadProgress', function (file, percentage) {
        var $li = $('.w-file-id-' + file.id),
            $percent = $li.parent().find('.w-file-progress').find('span');
        $percent.css('width', percentage * 100 + '%');
    });
    gFileUploader.on('uploadSuccess', function (file, response) {
        $('#' + file.id).addClass('upload-state-done');
        var $li = $('#' + file.id);
        gilContainer[response.id] = response.dest_path;
        $li.siblings('.pic-progress').hide();
    });
    gFileUploader.on('uploadBeforeSend', function (object, data, headers) {
        var guid = gFileUUID[data.id];
        data = $.extend(data, {
            guid: guid
        });
        console.log("upload guid = " + guid);
    });
    gFileUploader.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }

        $error.text('上传失败');
    });
    gFileUploader.on('uploadSuccess', function (file,response) {
        gGroupFileInfo[file.id].file_path = response.dest_path;
        var o = gGroupFileInfo[file.id];
        var group_id = $("#page-upload-group-file .hidden-group-id").val();
        SendNewGroupFileMsg(group_id, o.file_name, o.file_path, o.file_type, o.file_size);
        setTimeout(function(){
            $('.w-file-id-' + file.id).parent().fadeOut(1500).remove();
            if($('#page-upload-group-file .w-file-container').length ==0){
                history.back();
            }
        },300);

    });
});