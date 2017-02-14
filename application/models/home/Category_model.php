<?php
/************************************************************
** @Description: 
** @Author: haodaquan
** @Date:   2017-01-15 13:33:07
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-15 13:37:32
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