<?php
/************************************************************
** @Description: 首页广告图
** @Author: haodaquan
** @Date:   2017-01-16 23:50:05
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-17 00:33:38
*************************************************************/

class Banner extends MY_Controller
{
    public $data = [];
    //列表字段，必须设置
    public $showFields = array(
                                'id'          	=> 'ID',
                                'title'   		=> '标题',
                                'img_src'     	=> '图片',
                                'detail'     	=> '备注',
                                'sort'    		=> '排序',
                                'status' 		=> '状态',
                                'add_time' 		=> '发布日期',
                                'action'      	=> '操作'
                            );
    public $columnsWidth = array(
                                'action'        => 150,
                            );
    public $pageTitle   = 'Banner管理';
    public $modelName   = 'banner_model';
    public $searchFile  = 'admin/banner_search.html';#搜索文件
    public $pageTips    = '首页banner显示图设置，可以做广告';
    public $checkCol    = 0;
    public $category    = [];

    // private $queue_stock_name;#库存更新
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/banner_model');
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
                'detail'   => '编辑',
            );
        $status = ['正常','停用'];
        $data['totalCount'] = $listData['totalCount'];

        foreach ($listData['items'] as $key => $value) {
        	$value['action']  = getButton($value['id'],$buttons);
        	$value['img_src'] = "<img src='".$value['img_src']."' width='164' height='40' />";
        	$value['status']  = $status[$value['status']];
        	$value['add_time']= date('Y-m-d H:i:s',$value['add_time']);
            $data['items'][$key] = $value;
        }
        return $data;
    }

    /**
     * [add 默认设置]
     * @return [type] [description]
     */
    public function add()
    {
        $data['pageTitle'] = '新增Banner';
       $this->display('admin/banner_add.html',$data);
    }

    /**
     * [save_banner 保存]
     * @return [type] [description]
     */
    public function save_banner()
    {
    	$form_data = format_ajax_data($this->input->post('form_data'));
    	if (isset($form_data['id'])) {
        	 $result = $this->banner_model->editData($form_data,'id='.(int)$form_data['id']);
        }else
        {
        	$result = $this->banner_model->addData($form_data);
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
     * [detail 修改]
     * @return [type] [description]
     */
    public function detail()
    {
        $id = $this->input->get('id');
        $ban = $this->banner_model->getConditionData('*','id='.(int)$id);
        $data['pageTitle'] = '编辑Banner';
        $data['ban'] = $ban[0];
        $this->display('admin/banner_edit.html',$data);
    }
}