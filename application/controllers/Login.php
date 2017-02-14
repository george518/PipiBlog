<?php
/************************************************************
** @Description: 
** @Author: haodaquan
** @Date:   2017-01-10 14:32:10
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-14 01:12:16
*************************************************************/
class Login extends MY_Controller 
{

	public function __construct()
	{
		parent::__construct();

        $user_info = $this->user_model->get_user();
	}
	
	/**
	 * [index 登录首页]
	 * @Date   2016-05-27
	 * @return [type]     [登录页面]
	 */
	public function index()
	{
       $this->load->view('public/login.html',[]);
	}

	/**
	 * [do_login 登录处理]
	 * @Date   2016-06-03
	 * @return [type]     [description]
	 */
	public function do_login()
	{
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        //用户名只能是字母+数字，4位-20位
        if(!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9]{3,19}$/", $username))
        {
            echo -1;
            return;
        }

        //密码要6位-32位
        if(strlen($password)<6 || strlen($password)>32)
        {
            echo -1;
            return;
        }

        $username = htmlentities($username);
        $user = $this->user_model->get_user_by_username($username);
        
        if(!$user || !$user["password"])
        {
            echo -1;
            return;
        }
        
        if($user["password"] != md5(sha1($password)))
        {
            echo -1;
            return;
        }

        $login_key = $this->user_model->calculate_cookie_key($user);
        setcookie ( 'pipi_passport', $login_key, time () + 3600 * 20, "/", $_SERVER['HTTP_HOST'] );
        echo 1;
    }

    /**
     * [do_login_out 退出登录]
     * @Date   2016-06-03
     * @return [type]     [description]
     */
    public function do_login_out()
    {
        setcookie('pipi_passport','',time ()-1, "/", $_SERVER['HTTP_HOST']);

        $url = "http://".$_SERVER['HTTP_HOST']."/";
        header("Location:".$url);
        exit(); 
    }
}