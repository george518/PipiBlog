//文件图片上传
//haodaquan
//2016-11-28

/**
 * [plupFile 上传文件]
 * @param  {String} file        [文件地址]
 * @param  {String} btn         [按钮]
 * @param  {String} inputName   [file path and file name and alert]
 * @param  {String} maxFileSize [文件最大]
 * @return {[type]}             [description]
 */
function plupFile(file='',btn='upload_file',inputName='upload_file',maxFileSize='2mb')
{

    var url = "/public/upload/file/?size="+maxFileSize+"&file="+file;
    var uploader = new plupload.Uploader({ //创建实例的构造方法 
        runtimes: 'html5,flash,silverlight,html4', 
        //上传插件初始化选用那种方式的优先级顺序 
        browse_button: btn, 
        // 上传按钮 
        url: url, 
        //远程上传地址 
        flash_swf_url: '/static/Plugins/plupload-2.1.2/js/Moxie.swf', 
        //flash文件地址 
        silverlight_xap_url: '/static/Plugins/plupload-2.1.2/js/Moxie.xap', 
        //silverlight文件地址 
        filters: { 
            max_file_size: maxFileSize, 
            //最大上传文件大小（格式100b, 10kb, 10mb, 1gb） 
            mime_types: [ //允许文件上传类型 
            { 
                title: "files", 
                extensions: 'xlsx' 
            }] ,
        }, 
        multi_selection: false, 
        //true:ctrl多文件上传, false 单文件上传 
        init: { 
            FilesAdded: function(up, files) { //文件上传前 
                uploader.start();
                //uploader.destroy();
            }, 
            UploadProgress: function(up, file) { //上传中，显示进度条 
                // $("#" + file.id).find('.bar').css({ 
                //     "width": file.percent + "%"  
                // }).find(".percent").text(file.percent + "%"); 
                // 

            }, 
            FileUploaded: function(up, file, info) { //文件上传成功的时候触发 

                var data = JSON.parse(info.response); 
                if(data.error!=0){
                    alert(data.error);
                    return false;
                }else
                {
                    $('input[name='+inputName+'_path]').val(data.path);
                    $('input[name='+inputName+'_name]').val(data.name);
                    $('#'+inputName+'_alert').html(data.name+'上传成功！');
                }
            }, 
            Error: function(up, err) { 
                //上传出错的时候触发 
                //console.log(err.error);
                //alert(err.message); 
            } 
        } 
    }); 
	uploader.init();
}

/**
 * [plupImage 单图上传js]
 * @Author haodaquan
 * @Date   2016-04-12
 * @param  {String}   file        [文件名]
 * @param  {String}   width       [图片宽度]
 * @param  {String}   height      [图片高度]
 * @param  {String}   btn         [图片按钮]
 * @param  {String}   imgShowId   [显示图片的id]
 * @param  {String}   inputName   [提交input按钮]
 * @param  {String}   maxFileSize [最大上传大小]
 * @return {[type]}               [void]
 */
function plupImage(file='',width='',height='',btn='upload_img',imgShowId='show_img',inputName='img_src',maxFileSize='2mb')
{

    var url = "/public/upload//image?w="+width+"&h="+height+"&size="+maxFileSize+"&file="+file;
    var uploader = new plupload.Uploader({ //创建实例的构造方法 
        runtimes: 'html5,flash,silverlight,html4', 
        //上传插件初始化选用那种方式的优先级顺序 
        browse_button: btn, 
        // 上传按钮 
        url: url, 
        //远程上传地址 
        flash_swf_url: '/static/Plugins/plupload-2.1.2/js/Moxie.swf', 
        //flash文件地址 
        silverlight_xap_url: '/static/Plugins/plupload-2.1.2/js/Moxie.xap', 
        //silverlight文件地址 
        filters: { 
            max_file_size: maxFileSize, 
            //最大上传文件大小（格式100b, 10kb, 10mb, 1gb） 
            mime_types: [ //允许文件上传类型 
            { 
                title: "files", 
                extensions: 'jpg,png,gif' 
            }] ,
        }, 
        multi_selection: false, 
        //true:ctrl多文件上传, false 单文件上传 
        init: { 
            FilesAdded: function(up, files) { //文件上传前 
                uploader.start();
                //uploader.destroy();
            }, 
            UploadProgress: function(up, file) { //上传中，显示进度条 
                // $("#" + file.id).find('.bar').css({ 
                //     "width": file.percent + "%"  
                // }).find(".percent").text(file.percent + "%"); 
            }, 
            FileUploaded: function(up, file, info) { //文件上传成功的时候触发 

                var data = JSON.parse(info.response); 
                if(data.error!=0){
                    alert(data.error);
                    return false;
                }else
                {
                    $("#" + imgShowId).attr("src",data.pic); 
                    $('input[name='+inputName+']').val(data.pic);
                }
            }, 
            Error: function(up, err) { 
                //上传出错的时候触发 
                //console.log(err.error);
                //alert(err.message); 
            } 
        } 
    }); 
	uploader.init();
}