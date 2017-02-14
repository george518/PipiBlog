<?php
/************************************************************
** @Description: 栏目管理
** @Author: haodaquan
** @Date:   2017-01-14 01:49:17
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-14 01:50:23
*************************************************************/
class Category_model extends MY_Model
{
	protected $_table;
	/**
	 * [__construct 初始化方法]
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'pp_category';
	}
}