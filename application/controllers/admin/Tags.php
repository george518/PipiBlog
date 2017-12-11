<?php
/************************************************************
** @Description: 
** @Author: haodaquan
** @Date:   2017-02-12 17:52:19
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-02-12 18:51:39
*************************************************************/

class Tags extends MY_Controller
{
    public $data = [];
    //列表字段，必须设置
    public $showFields = array(
                                'id'            => 'id',
                                'tag_name'      => '标签名称',
                                'is_top'        => '是否置顶',
                                'action'        => '操作'
                            );
    public $columnsWidth = array(
                                'action'        => 150,
                            );
    public $pageTitle   = '标签管理';
    public $modelName   = 'tags_model';
    public $searchFile  = 'admin/tags_search.html';#搜索文件
    public $pageTips    = '标签管理';
    public $checkCol    = 0;

    function __construct()
    {
        parent::__construct();
        $this->user_model->check_user();        
        $this->load->model('admin/tags_model');
    }


    /**
     * [query 查询配置 这里继承父类方法，也可以这里配置查询条件]
     * @Author haodaquan
     * @Date   2016-08-07
     * @return [type]     [description]
     */
    public function query()
    {
        $_POST['status|='] = 0;
        $_POST['sort'] = 'is_top.desc';
        parent::query();
    }

    /**
     * [listDataFormat 对数据进行格式化]
     * @param  [type] $listData [description]
     * @return [type]           [description]
     */
    public function listDataFormat($listData)
    {
        $buttons = array(
                'delete' => '删除',
                'edit'   => '编辑',
                'changeStatus'=>'置顶',
            );


        $data['totalCount'] = $listData['totalCount'];
        foreach ($listData['items'] as $key => $value) {
            if ($value['is_top']==1) {
                unset($buttons['changeStatus']);
                $value['action'] = getButton($value['id'],$buttons).'<button type="button" onclick="return changeStatusAction('.$value['id'].')" class="btn btn-xs btn-default">取消</button>';;
            }else{
                $buttons['changeStatus'] = '置顶';
                $value['action'] = getButton($value['id'],$buttons);
            }

            $value['is_top'] = $value['is_top']==1 ? '顶':'';
        	
            $data['items'][$key] = $value;
        }
        return $data;
    }

    /**
     * [changeStatus 是否置顶]
     * @return [type] [description]
     */
    public function changeStatus()
    {
         $id = $this->input->post('id');
        
        if(!$id){
            $this->ajaxReturn("",300,'数据不完整');
        }

        $res = $this->tags_model->getConditionData('is_top','id="'.$id.'"');
        if (isset($res[0]['is_top']) && $res[0]['is_top']==1 ) {
            $data['is_top'] = 0;
        }else{
            $data['is_top'] = 1;
        }
        $data['id'] = $id;
        $data['edit_time']   = time();
        $res = $this->tags_model->editData($data,'id="'.$id.'"');
        $res ? $this->ajaxReturn($res) : $this->ajaxReturn($res,300,'置顶失败');
    }

    /**
     * [save_tags 保存标签]
     * @return [type] [description]
     */
    public  function save_tags()
    {
        $form_data = format_ajax_data($this->input->post('data'));
        
        if (isset($form_data['id'])) {
        	 $result = $this->tags_model->editData($form_data,'id='.(int)$form_data['id']);
        }else
        {
        	#判断是否存在
        	$res = $this->tags_model->getConditionData('*','tag_name="'.$form_data['tag_name'].'"');
        	if($res) 
        	{
        		$result = false;
        	}else
        	{
        		$result = $this->tags_model->addData($form_data);
        	}
        }

        if($result===false || $result<1)
        {
        	$this->ajaxReturn($result,300,'保存失败,标签已存在');
        }else
        {
        	 $this->ajaxReturn($result);
        }
    }

    /**
     * [delete 逻辑删除]
     * @return [type] [ajax]
     */
    public function delete()
    {
    	$id = $this->input->post('id');
    	if(!$id) $this->ajaxReturn($id,300,'数据错误');
    	$data['id'] = $id;
    	$data['status'] = 1;
    	$res = $this->tags_model->editData($data,'id='.(int)$id);
    	($res!=-1 && $res!=false) ? $this->ajaxReturn($res) : $this->ajaxReturn($res,300,'操作失败');
    }

    /**
     * [get_detail 根据ID获取配置信息]
     * @return [type] [description]
     */
    public  function get_detail()
    {
        $id = $this->input->post('id');
        $data = $this->tags_model->getConditionData('*','id='.(int)$id);
        $this->ajaxReturn($data);
    }

    /**
     * [get_tags 获取全部tags]
     * @return [type] [description]
     */
    public  function get_tags()
    {
        $id = $this->input->post('id');
        $data = $this->tags_model->getConditionData('*',' status=0');
        $this->ajaxReturn($data);
    }


}