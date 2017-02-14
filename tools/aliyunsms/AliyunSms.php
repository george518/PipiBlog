<?php

/**
* 阿里云短信平台
*/
include_once "aliyun-php-sdk-core/Config.php";
include_once "aliyun-php-sdk-core/RpcAcsRequest.php";
include_once "aliyun-php-sdk-sms/Sms/Request/V20160927/SingleSendSmsRequest.php";

class AliyunSms
{
	private $key 		= "BPEmlIOoSo8MDvOa";
	private $secret 	= "kNtJD794gV64XvH3GMtnJI45IBxtv9";
	private $signName 	= "西有全球好店";

	public function sendMsg($telphone, $templatCode, $json_data)
	{
		// $telphone 		= '18612701228';
		// $templatCode 	= 'SMS_34955268';
		// $json_data 		= json_encode(['code'=>'12345']);

	    $iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $this->key, $this->secret);
	    $client 		= new DefaultAcsClient($iClientProfile);
	    $request 		= new SingleSendSmsRequest();
	    $request->setSignName($this->signName);/*签名名称*/
	    $request->setTemplateCode($templatCode);/*模板code*/
	    $request->setRecNum($telphone);/*目标手机号*/
	    $request->setParamString($json_data);/*模板变量，数字一定要转换为字符串*/

	    //将发送的结果返回 
	    $res = [];
	    try {
	    	//发送成功
	        $response = $client->getAcsResponse($request);
	        $res = [
	        	'code' 	=> 200,
	        	'msg' 	=> 'Sms send ok!',
	        	'data' 	=> $response
	        ];
	    } catch (ClientException  $e) {
	    	//发送失败
	        $res = [
	        	'code' 	=> $e->getErrorCode(),
	        	'msg' 	=> $e->getErrorMessage(),
	        	'data' 	=> []
	        ];
	    } catch (ServerException  $e) {  
	    	//发送失败      
	        $res = [
	        	'code' 	=> $e->getErrorCode(),
	        	'msg' 	=> $e->getErrorMessage(),
	        	'data' 	=> []
	        ];
	    }
	    return json_encode($res);
	}

}