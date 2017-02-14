<?php
/************************************************************
** @Description: 文章管理模块
** @Author: haodaquan
** @Date:   2017-01-14 12:15:36
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-14 12:16:27
*************************************************************/

class Article_model extends MY_Model
{
	protected $_table;
	/**
	 * [__construct 初始化方法]
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'pp_article';
	}
}