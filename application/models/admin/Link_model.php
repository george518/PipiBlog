<?php
/************************************************************
** @Description: 友情链接
** @Author: haodaquan
** @Date:   2017-01-15 12:09:36
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-15 12:10:02
*************************************************************/
class Link_model extends MY_Model
{
	protected $_table;
	/**
	 * [__construct 初始化方法]
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'pp_link';
	}
}