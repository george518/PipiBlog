<?php
/************************************************************
** @Description: 
** @Author: haodaquan
** @Date:   2017-01-15 12:39:16
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-02-06 14:10:58
*************************************************************/

class Ad extends MY_Controller
{
    public $data = [];
    //列表字段，必须设置
    public $showFields = array(
                                'id'          => '广告ID',
                                'ad_name'     => '广告名称',
                                'ad_tag'      => '调用标志',
                                'ad_detail'	  => '广告备注',
                                'add_time'    => '添加时间',
                                'action'      => '操作'
                            );
    public $columnsWidth = array(
                                'action'        => 150,
                            );
    public $pageTitle = '广告管理';
    public $modelName   = 'ad_model';
    public $searchFile  = 'admin/ad_search.html';#搜索文件
    public $pageTips    = '广告管理';
    public $checkCol    = 0;

    // private $queue_stock_name;#库存更新
    function __construct()
    {
        parent::__construct();
        $this->user_model->check_user();
        $this->load->model('admin/ad_model');
    }


    /**
     * [index 上架商品管理]
     * @Date   2016-10-09
     * @return [type]     [description]
     */
    public function index()
    {
        
        parent::index();
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
            );
        $data['totalCount'] = $listData['totalCount'];
        foreach ($listData['items'] as $key => $value) {
            $value['add_time'] = date('Y-m-d H:i:s',$value['add_time']);
        	$value['action'] = getButton($value['id'],$buttons);
            $data['items'][$key] = $value;
        }
        return $data;
    }

    /**
     * [save_ad 保存广告]
     * @return [type] [description]
     */
    public  function save_ad()
    {
        $form_data = format_ajax_data($this->input->post('data'));
        
        if (isset($form_data['id'])) {
        	 $result = $this->ad_model->editData($form_data,'id='.(int)$form_data['id']);
        }else
        {
        	$result = $this->ad_model->addData($form_data);
        }

        if($result===false || $result<1)
        {
        	$this->ajaxReturn($result,300,'保存失败');
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
    	$res = $this->ad_model->editData($data,'id='.(int)$id);
    	($res!=-1 && $res!=false) ? $this->ajaxReturn($res) : $this->ajaxReturn($res,300,'操作失败');
    }

    /**
     * [get_detail 根据ID获取配置信息]
     * @return [type] [description]
     */
    public  function get_detail()
    {
        $id = $this->input->post('id');
        $data = $this->ad_model->getConditionData('*','id='.(int)$id);
        $this->ajaxReturn($data);
    }
}