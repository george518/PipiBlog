<?php
/************************************************************
** @Description: 网站配置
** @Author: haodaquan
** @Date:   2017-01-12 02:16:10
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-14 01:17:35
*************************************************************/
class Config extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->user_model->check_user();
        $this->load->model('admin/config_model');
    }


    /**
     * [default_set 默认设置]
     * @return [type] [description]
     */
    public function index()
    {
        $data['config']    = $this->config_model->get_config();
        $data['pageTitle'] = '基础设置';
       $this->display('admin/config.html',$data);
    }

    /**
     * [config_set_save 保存默认设置]
     * @return [type] [description]
     */
    public function save_config()
    {
        $_data = $this->input->post('data');

        $this->load->model('admin/config_model');
        foreach ($_data as $key => $value) {
            $data = [];
            $data['key']       = $value['name'];
            $data['value']     = $value['value'];
            $data['status']    = 0;
            $res[] = $this->config_model->saveData($data,' `key`="'.$data['key'].'"');
        }
        if (in_array(false,$res) || in_array(-1,$res)) {
            $this->ajaxReturn($res,300,'保存错误');
        }else
        {
            $this->ajaxReturn($res);
        }
    }



}