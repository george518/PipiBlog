<?php
/************************************************************
** @Description: 
** @Author: haodaquan
** @Date:   2017-01-15 13:03:48
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-15 13:04:11
*************************************************************/

class Ad_model extends MY_Model
{
	protected $_table;
	/**
	 * [__construct 初始化方法]
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'pp_ad';
	}
}