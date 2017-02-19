<?php
/************************************************************
** @Description: 图片管理
** @Author: haodaquan
** @Date:   2017-02-19 02:27:30
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-02-19 02:27:30
*************************************************************/
class Images_model extends MY_Model
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

	/**
	 * [get_images 获取图片]
	 * @param  integer $every_page   [description]
	 * @param  integer $current_page [description]
	 * @return [type]                [description]
	 */
	public function get_images($every_page=30,$current_page=1)
	{
		$sql = 'SELECT
					DISTINCT pa.img_src
				FROM
					(select * from pp_article ORDER BY id desc) as pa
				WHERE
					pa.img_src LIKE "%Uploads%"
				LIMIT '.($current_page-1)*$every_page.','.$every_page;

		return $this->db_pp->query($sql)->result_array();
	}
}