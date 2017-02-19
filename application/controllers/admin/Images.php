<?php
/************************************************************
** @Description: 上传图片管理
** @Author: haodaquan
** @Date:   2017-02-19
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-02-19
*************************************************************/
class Images extends MY_Controller
{
	 public $data = [];
    //列表字段，必须设置
    public $showFields = array(
                                'img_src'     => '图片',
                                'action'      => '操作'
                            );
    public $columnsWidth = array(
                                'id'        => 10,
                            );
    public $pageTitle = '图片管理';
    public $modelName   = 'images_model';
    public $searchFile  = 'admin/images_search.html';#搜索文件
    public $pageTips    = '图片管理,待完善……';
    public $checkCol    = 0;
    public $indexCol    = 1;


    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/images_model');
        $this->user = $this->user_model->check_user();
    }


    public function query()
    {
        $_POST['img_src|like'] = 'Uploads';
        parent::query();
    }


    public function listDataFormat($listData)
    {
        $data['totalCount'] = $listData['totalCount'];
        foreach ($listData['items'] as $key => $value) {
        	$value['action'] = '';
        	$value['img_src'] = '<img src="'.$value['img_src'].'" width="88" />';
            $data['items'][$key] = $value;
        }
        return $data;
    }

    /**
     * [get_images 获取图片]
     * @return [type] [description]
     */
    public function get_images()
    {
        $page = $this->input->post('page');
        if(!$page) $page = 1;
        $every_page = 20;

        $data = $this->images_model->get_images($every_page,$page);
        $this->ajaxReturn($data);
    }
    

}