<?php
/************************************************************
** @Description: 用户model
** @Author: haodaquan
** @Date:   2017-01-09 21:21:01
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-10 13:21:33
*************************************************************/
define ( 'UM_MYKEY', '6g1Y780G290udU5seSeecSdlek4Qbia99x0hco8b7ldRbEdv430c9fdT7x8O0vb1' );
class User_model extends MY_Model
{
    public $_table = 'uc_user';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_user_by_username 根据用户名获取用户信息]
	 * @Date   2016-06-03
	 * @param  string     $username [用户名]
	 * @return array                [用户信息数组]
	 */
	function get_user_by_username($username='')
	{
		$username = addslashes($username);
		if (!$username) return false;

        $user_info = $this->getConditionData('*','`login_name`="'.$username.'"');
        if (empty($user_info)) return false;
		return $user_info[0];
	}

	/**
	 * [calculate_cookie_key 加密用户信息]
	 * @Date   2016-06-03
	 * @param  [type]     $user [description]
	 * @return [type]           [description]
	 */
	public function calculate_cookie_key($user) 
	{
        if (empty($user)) return false;
        $uid = $user['id'];
        $pwd = $user['password'];
        $key = authcode($uid.','.$pwd, 'ENCODE', UM_MYKEY);
        return $key;
    }

    /**
     * [get_user 获取user信息]
     * @Date   2016-06-03
     * @return [type]     [description]
     */
    function get_user()
    {
        if(!array_key_exists('pipi_passport',$_COOKIE)){

            return false;
        }else{
            $login_key = $_COOKIE['pipi_passport'];
        }

        if (!$login_key) {
            return false;
        }
        $login_user = null;
        if(!$login_user){
            $uid_pwd_str = authcode($login_key,'DECODE',UM_MYKEY);
            $uid_pwd_str = explode(',', $uid_pwd_str);
            $login_user = null;
            if(count($uid_pwd_str) != 2){
                return false;
            }else{
                $uid = $uid_pwd_str[0];
                $pwd = $uid_pwd_str[1];
                $login_user = $this->get_user_by_uid($uid,TRUE);
                if(empty($pwd) || $pwd != $login_user['password']){
                    return false;
                }
                if (!$login_user) {
                    return false;
                }
            }
            unset($login_user['password']);
            
        }
        return $login_user;
    }

    /**
     * [get_user_by_uid 根据uid获取用户信息]
     * @Date   2016-06-03
     * @param  integer    $uid [用户id]
     * @return [type]          [description]
     */
    function get_user_by_uid($uid = 0)
    {
        $uid = (int)$uid;
        if($uid==0) return false;
        $user_info = $this->getConditionData('*','`id`='.(int)$uid);
        if (empty($user_info)) return false;
        return $user_info[0];
    }

    /**
     * [check_user 检查登录]
     * @Date   2016-06-03
     * @return [type]     [description]
     */
    function check_user()
    {
        $login_user = $this->get_user();
        if(!$login_user){
            $url = "http://".$_SERVER['HTTP_HOST']."/login";
            header("Location:".$url);
            exit();
        }
        return $login_user;
    }
}
