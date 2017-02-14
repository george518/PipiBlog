<?php
/************************************************************
** @Description: 首页广告位
** @Author: haodaquan
** @Date:   2017-01-17 00:02:04
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-17 00:02:43
*************************************************************/
class Banner_model extends MY_Model
{
	protected $_table;
	/**
	 * [__construct 初始化方法]
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'pp_banner';
	}
}