<?php
/************************************************************
** @Description: 文章管理
** @Author: haodaquan
** @Date:   2017-01-14 12:05:47
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-02-12 21:41:11
*************************************************************/

class Article extends MY_Controller
{
    public $data = [];
    //列表字段，必须设置
    public $showFields = array(
                                'id'          	=> '文章ID',
                                'title'   		=> '标题',
                                'cate_id'     	=> '栏目名称',
                                'recommand'     => '是否推荐',
                                'headline'    	=> '是否头条',
                                'hits' 			=> '点击量',
                                'add_time' 		=> '发布日期',
                                'action'      	=> '操作'
                            );
    public $columnsWidth = array(
                                'action'        => 150,
                            );
    public $pageTitle   = '文章管理';
    public $modelName   = 'article_model';
    public $searchFile  = 'admin/article_search.html';#搜索文件
    public $pageTips    = '文章管理';
    public $checkCol    = 0;
    public $category    = [];

    // private $queue_stock_name;#库存更新
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/article_model');
        $this->load->model('admin/category_model');
    	$category_ = $this->category_model->getConditionData('*','status=0',' sort ASC');

    	foreach ($category_ as $key => $value) {
    		$this->category[$value['id']] = $value['cate_name'];
    	}
    }


    /**
     * [index 上架商品管理]
     * @Date   2016-10-09
     * @return [type]     [description]
     */
    public function index()
    {
        $this->data['category'] = $this->category;
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
                'detail'   => '编辑',
            );
        $status = ['否','是'];
        $data['totalCount'] = $listData['totalCount'];

        foreach ($listData['items'] as $key => $value) {
        	$value['action'] = getButton($value['id'],$buttons);
        	$value['recommand'] = $status[$value['recommand']];
        	$value['headline'] = $status[$value['headline']];
        	$value['add_time'] = date('Y-m-d H:i:s',$value['add_time']);
        	$value['cate_id']  = $this->category[$value['cate_id']];

        	// $value['is_nav'] = $is_nav[$value['is_nav']];
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
    	$data['category'] = $this->category;
        $data['pageTitle'] = '发布文章';
       $this->display('admin/article_add.html',$data);
    }



    /**
     * [save_article 保存]
     * @return [type] [description]
     */
    public function save_article()
    {
    	$form_data = format_ajax_data($this->input->post('form_data'));
        $id  = $type = 0;
    	if (isset($form_data['id'])) {
        	 $result = $this->article_model->editData($form_data,'id='.(int)$form_data['id']);
             $id     = $form_data['id'];
        }else
        {
        	$result = $this->article_model->addData($form_data);
            $id     = $result;
            $type   = 1;
        }

        if($result===false || $result<1)
        {
        	$this->ajaxReturn($result,300,'保存失败');
        }else
        {
            $this->tag_handle($id,$form_data['tag'],$type);
        	$this->ajaxReturn($result);
        }
    }

    /**
     * [tag_handle 标签处理]
     * @param  [type]  $tags [标签字符串，逗号隔开]
     * @param  integer $type [1-新增，0-修改]
     * @return [type]        [description]
     */
    private function tag_handle($aid,$tags,$type=1)
    {
        $tags_arr = explode(',',$tags);
        $this->load->model('admin/tags_model');
        $this->load->model('admin/article_tag_model');
        $tag_id_arr = [];
        foreach ($tags_arr as $key => $value) {
            if(!$value) continue;
            #判断是否存在
            $res = $this->tags_model->getConditionData('*','tag_name="'.$value.'"');
            if(!isset($res[0]['id']))
            {
                $tag_id = $this->tags_model->addData(['tag_name'=>$value]);
                $tag_id_arr[] = $tag_id;
            }else
            {
                $tag_id_arr[] = $res[0]['id'];
            }
        }
        return $this->article_tag_model->save_art_tag($aid,$tag_id_arr,$type);
    }

    /**
     * [detail 修改]
     * @return [type] [description]
     */
    public function detail()
    {
        $id = $this->input->get('id');
        $art = $this->article_model->getConditionData('*','id='.(int)$id);
        $data['category'] = $this->category;
        $data['pageTitle'] = '编辑文章';
        $data['art'] = $art[0];
        $this->display('admin/article_edit.html',$data);
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
        $res = $this->article_model->editData($data,'id='.(int)$id);
        ($res!=-1 && $res!=false) ? $this->ajaxReturn($res) : $this->ajaxReturn($res,300,'操作失败');
    }
}