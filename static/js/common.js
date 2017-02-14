//列表页基础
//haodaquan
//2016-11-17

//高级搜索控制
$('#show_advance_search').on('click',function(){
    //$(this).find('span').css();
    var classicon = $('#span-icon').attr('class');
    if (classicon.lastIndexOf('glyphicon-zoom-in')>0) {
        $('#span-icon').removeClass('glyphicon-zoom-in');
        $('#span-icon').addClass('glyphicon-zoom-out');
    }
     if (classicon.lastIndexOf('glyphicon-zoom-out')>0) {
        $('#span-icon').removeClass('glyphicon-zoom-out');
        $('#span-icon').addClass('glyphicon-zoom-in');
    }
    $('#advance_search').toggle();
});

/**
 * [getSelectIndex 获取选中的字段]
 * @param  {string}  field [description]
 * @return {[type]}        [description]
 */
function getSelectIndex(field='id'){
    var selectedIndexes = mmg.selectedRowsIndex();
    if(selectedIndexes.length<1) return false;

    var selectInfo = [];

    $.each(selectedIndexes,function(k,v){
        var rowInfo = mmg.row(v);
        selectInfo.push(rowInfo[field]);
    });
    return selectInfo;
}
/**
 * [ajaxRequest 普通ajax请求 ]
 * @param  {[type]} param  [json data]
 * @param  {[type]} url    [ajax url]
 * @param  {[type]} button [btn id]
 * @param  {[type]} method [GET,OR POST]
 * @param  {[type]} is_list [是否含有列表页，1含有，0不含,2弹出框]
 * 
 * @return {[type]}        [description]
 */
function ajaxRequest(param,url,button,method='POST',is_list=1)
{
    $('#'+button).attr('disabled',true);
    $.ajax({
        type: method,
        url: url,
        data: param,
        dataType: 'json',
        success: function(data) {
            $('#'+button).removeAttr('disabled');
            if(data.status=="200"){
                alert(data.message);
                if(is_list==1)
                {
                    $("#_CustomizedQueryFormSubmit").click();
                }else if(is_list==2)
                {
                    $('.close').click();
                    $("#_CustomizedQueryFormSubmit").click();
                }else
                {
                   
                    window.location.reload();
                }
            }else{
                alert(data.message);
                return;
            }
        }
    });  
}

//查看详情
function detailAction(id)
{
    var url_path = window.location.pathname;
    var new_url = url_path.replace('index','detail');
    window.parent.openTab('详情-'+id, new_url+'?id='+id);
}
//删除
function deleteAction(id)
{
    if (confirm("确认要删除吗？")) {
        $.ajax({
            type: "POST",
            url: "delete",
            data: {id:id},
            dataType: 'json',
            success: function(data) {
                if(data.status=='200'){
                    alert(data.message);
                    $("#_CustomizedQueryFormSubmit").click();
                }else{
                   alert(data.message);
                }
            }
        });  
    };
}

//修改状态
function changeStatusAction(id)
{
    if (confirm("确认要修改状态吗？")) {
        $.ajax({
            type: "POST",
            url: "changeStatus",
            data: {id:id},
            dataType: 'json',
            success: function(data) {
                if(data.status=='200'){
                    alert(data.message);
                    $("#_CustomizedQueryFormSubmit").click();
                }else{
                   alert(data.message);
                }
            }
        });  
    };
}

//修改状态
function disableAction(id)
{
    if (confirm("确认修改状态吗？")) {
        $.ajax({
            type: "POST",
            url: "disable",
            data: {id:id},
            dataType: 'json',
            success: function(data) {
                if(data.status=='200'){
                    alert(data.message);
                    $("#_CustomizedQueryFormSubmit").click();
                }else{
                   alert(data.message);
                }
            }
        });  
    };
}


//未开发
$('.no-develop').on('click',function(){
    alert('sorry,该功能还没启用');
});

//编辑
function editAction(id)
{
    //获取索引
    edit_data_to_form(id);//页面实现数据填充
    $("#edit").click();
}


















