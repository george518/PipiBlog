<?php
/************************************************************
** @Description: 分类
** @Author: haodaquan
** @Date:   2017-01-14 01:41:33
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-15 12:17:32
*************************************************************/

class Category extends MY_Controller
{
    public $data = [];
    //列表字段，必须设置
    public $showFields = array(
                                'id'          => '栏目ID',
                                'cate_name'   => '栏目名称',
                                'is_nav'      => '是否导航显示',
                                'sort'        => '排序',
                                'keywords'    => '栏目关键字',
                                'description' => '栏目描述',
                                'action'      => '操作'
                            );
    public $columnsWidth = array(
                                'action'        => 150,
                            );
    public $pageTitle = '栏目管理';
    public $modelName   = 'category_model';
    public $searchFile  = 'admin/category_search.html';#搜索文件
    public $pageTips    = '栏目管理';
    public $checkCol    = 0;

    // private $queue_stock_name;#库存更新
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/category_model');
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
    	if(!isset($_POST['sort']))
        {
            $_POST['sort'] = 'sort.asc';
        }
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
        $is_nav = ['否','是'];
        $data['totalCount'] = $listData['totalCount'];
        foreach ($listData['items'] as $key => $value) {
        	$value['action'] = getButton($value['id'],$buttons);
        	$value['is_nav'] = $is_nav[$value['is_nav']];
            $data['items'][$key] = $value;
        }
        return $data;
    }

    /**
     * [save_category 保存分类]
     * @return [type] [description]
     */
    public  function save_category()
    {
        $form_data = format_ajax_data($this->input->post('data'));
        
        if (isset($form_data['id'])) {
        	 $result = $this->category_model->editData($form_data,'id='.(int)$form_data['id']);
        }else
        {
        	$result = $this->category_model->addData($form_data);
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
        $this->load->model('admin/article_model');
        $num = $this->article_model->getCount(' WHERE cate_id='.(int)$id);
        if($num>0) $this->ajaxReturn($num,300,'请先删除该栏目下的文章');
    	$data['id'] = $id;
    	$data['status'] = 1;
    	$res = $this->category_model->editData($data,'id='.(int)$id);
    	($res!=-1 && $res!=false) ? $this->ajaxReturn($res) : $this->ajaxReturn($res,300,'操作失败');
    }

    /**
     * [get_detail 根据ID获取配置信息]
     * @return [type] [description]
     */
    public  function get_detail()
    {
        $id = $this->input->post('id');
        $data = $this->category_model->getConditionData('*','id='.(int)$id);
        $this->ajaxReturn($data);
    }
}