<?php
/************************************************************
** @Description: 修改密码
** @Author: haodaquan
** @Date:   2017-01-12 02:16:10
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-14 01:17:35
*************************************************************/
class User extends MY_Controller
{
	public $user;
    function __construct()
    {
        parent::__construct();
        $this->user = $this->user_model->check_user();
    }


    /**
     * [index 修改密码页]
     * @return [type] [description]
     */
    public function index()
    {
        $data['pageTitle'] = '修改密码';
        $data['user'] = $this->user;
       $this->display('admin/user.html',$data);
    }

    /**
     * [save_user 保存设置]
     * @return [type] [description]
     */
    public function save_user()
    {
        $_data = $this->input->post('data');
        $data = [];
        foreach ($_data as $key => $value) {  
        	if(!$value['value']) $this->ajaxReturn($value['name'],300,'请填写数据完整');
            $data[$value['name']]  = $value['value'];
        }

        $user_info = $this->user_model->get_user_by_username($data['login_name']);

        if(md5(sha1($data['password']))!==$user_info['password']){
			$this->ajaxReturn($user_info['user_name'],300,'请输入正确的原密码');
		}

		//密码要6位-32位
        if(strlen($data['password1'])<6 || strlen($data['password1'])>20)
        {
           $this->ajaxReturn($user_info['user_name'],300,'密码位数不对，请重新输入');
        }

		

		if(trim($data['password1'])!==trim($data['password2']))
		{
			$this->ajaxReturn($user_info['user_name'],300,'两次密码不一致，请重新输入');
		}

		$data['password'] = md5(sha1($data['password1']));
		unset($data['password1']);
		unset($data['password2']);

         $res = $this->user_model->saveData($data,' id='.(int)$user_info['id']);
        if (!$res) {
            $this->ajaxReturn($res,300,'保存错误');
        }else
        {
            $this->ajaxReturn($res,200,'修改成功，请退出重新登录');
        }
    }

}