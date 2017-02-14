<?php
/************************************************************
** @Description: 后台首页
** @Author: haodaquan
** @Date:   2016-05-27 13:52:48
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-14 01:23:12
*************************************************************/

class Home extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->user = $this->user_model->check_user();

	}
	
	/**
	 * [index 登录首页]
	 * @Date   2016-05-27
	 * @return [type]     [登录页面]
	 */
	public function index()
	{
		$data              = $this->user;
		$this->load->view('public/main.html',$data);
	}

	/**
	 * [start 起始页]
	 * @Date   2016-09-07
	 * @return [type]     [description]
	 */
	public function start()
	{
		$this->load->view('public/start.html',[]);
	}

	/**
	 * [report 查找前一天的商品及订单信息]
	 * @Date   2016-09-07
	 * @return [type]     [description]
	 */
	public function report_data()
	{

		$url = BASEURL.'/api/report/index';

		#订单
		$order['style'] = 'order';
		$yestoday = date("Y-m-d",strtotime("-1 day"));
		$order['start'] = $order['end'] = $yestoday;

		$order_data = json_decode(http($url, $order,'POST', [],30,true),true);

		$data['yestoday']  = $yestoday;
		$data['order_num'] = $order_data['data']['order_num'];
		$data['total_money'] = $order_data['data']['total_money'];




		#新增
		$product_increase['type'] = 'increase';
		$product_increase['style'] = 'product';
		$product_increase['start'] = $product_increase['end'] = $yestoday;

		$product_increase_data = json_decode(http($url, $product_increase,'POST', [],30,true),true);

		$data['product_increase'] = $product_increase_data['data']['product_num'];

		#总
		$product_on_sale['type'] = 'on_sale';
		$product_on_sale['style'] = 'product';
		$product_data = json_decode(http($url, $product_on_sale,'POST', [],30,true),true);

		$data['product_on_sale'] = $product_data['data']['product_num'];

		return $data;
	}

	
}