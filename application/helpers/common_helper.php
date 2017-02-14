<?php
/************************************************************
** @Description: 基础函数库
** @Author: haodaquan
** @Date:   2016-06-03 12:21:01
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-02-04 12:20:05
*************************************************************/
/**
 * [authcode 加密函数]
 * @Date   2016-06-03
 * @param  [type]     $string    [description]
 * @param  string     $operation [description]
 * @param  string     $key       [description]
 * @param  integer    $expiry    [description]
 * @return [type]                [description]
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 2592000)
{
    $oristr = $string;
    $orikey = $key;
    $string = $oristr;
    $key = $orikey;
    $ckey_length = 4;
    $key = md5 ( $key ? $key : '6g1Y780G2udU5seSeecSdb1' );
    $keya = md5 ( substr ( $key, 0, 16 ) );
    $keyb = md5 ( substr ( $key, 16, 16 ) );
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '';
    $cryptkey = $keya . md5 ( $keya . $keyc );
    $key_length = strlen ( $cryptkey );
    if ($operation == 'DECODE') {
        $string = str_replace ( '.', '+', $string );
        $string = str_replace ( '-', '/', $string );
        $string = base64_decode ( substr ( $string, $ckey_length ) );
    } else {
        $string = sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string;
    }
    $string_length = strlen ( $string );
    $result = '';
    $box = range ( 0, 255 );
    $rndkey = array ();
    for($i = 0; $i <= 255; $i ++) {
        $rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
    }
    for($j = $i = 0; $i < 256; $i ++) {
        $j = ($j + $box [$i] + $rndkey [$i]) % 256;
        $tmp = $box [$i];
        $box [$i] = $box [$j];
        $box [$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i ++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box [$a]) % 256;
        $tmp = $box [$a];
        $box [$a] = $box [$j];
        $box [$j] = $tmp;
        $result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
    }
    if ($operation == 'DECODE') {
        if ((substr ( $result, 0, 10 ) == 0 || substr ( $result, 0, 10 ) - time () > 0) && substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 )) {
            return substr ( $result, 26 );
        } else {
            return '';
        }
    } else {
        $result = str_replace ( '=', '', base64_encode ( $result ) );
        $result = str_replace ( '+', '.', $result );
        $result = str_replace ( '/', '-', $result );
        return $keyc . $result;
    }
}

/**
 * 浏览器友好的变量输出,调试函数
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}


/**
 * [getButton 生成操作按钮]
 * @Author haodaquan
 * @Date   2016-04-07
 * @param  int        $id     [操作id]
 * @param  string     $btnArr [array('edit'=>'编辑','delete'=>'删除')]
 * @return [type]             [button字符串]
 */
function getButton($id=0,$btnArr='')
{
    
    if (empty($btnArr) || $id===0) return '';
    $btn = '';
    $relation = [
            'detail'        => 'info', //查看
            'edit'          => 'primary',//编辑
            'delete'        => 'danger',//删除
            'changeStatus'  => 'warning',//改变状态
            'disable'       => 'default',//禁止或者默认
            'default'       => 'success',//普通操作
        ];

    foreach ($btnArr as $key => $value) 
    {
        $btn .= '<button type="button" onClick="return '.$key.'Action('.$id.')" class="btn btn-xs btn-'.$relation[$key].'">'.$value.'</button>&nbsp;';
    }
    return $btn;
}

/**
 * [curl_request 接口请求函数]
 * @param  [type] $url    [地址]
 * @param  [type] $post   [数据]
 * @param  [type] $header [header头数据]
 * @return [type]         [description]
 */
function curl_request($url, $post = null, $header = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($post) {
        if (is_array($post)) {
            $post = http_build_query($post);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_POST, 1);
    } else {
        $postData = "";
        curl_setopt($ch, CURLOPT_POST, 0);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    if ($header) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    } else {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($post)));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT,180);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

/**
 * [make_dir 创建文件夹]
 * @Date   2016-06-30
 * @param  string     $file_path [文件地址]
 * @return [type]                [description]
 */
function make_dir($file_path)
{
    //$date_file_path = $file_path;
    if (!is_dir($file_path)) return  mkdir($file_path,0777,true);
    return true;
}

/**
 * [change_array_map 字段映射的关联数组转化]
 * @param  [type] $map [映射关系，键名与arr对应]
 * @param  [type] $arr [数组]
 * @return [type]      [description]
 */
function change_array_map($map,$arr)
{
    $new_arr = [];
    foreach ($arr as $key => $value) {
        if(isset($arr[$key])) $new_arr[$map[$key]] = $arr[$key];
        continue;
    }

    return $new_arr;
}

/**
 * [tree 获取文件树]
 * @param  [type] $directory [文件夹名称]
 * @return [type]            [description]
 */
function tree($directory) 
{ 
    $mydir = dir($directory);
    if(!$mydir) return false;

    $data = [];
    while($file = $mydir->read())
    { 
        if (($file==".") || ($file=="..") || ($file==".DS_Store")) continue;
        $data[$file] = is_dir("$directory/$file") ? tree("$directory/$file") : $file;
    } 
    $mydir->close(); 

    return $data;
} 


/**导出excel
 * @param $head 表头中文
 * @param $fields 字段列表
 * @param $data 数据集合
 * @param $name 文件名
 */
function export_excel($head, $fields,$data, $name)
{
    require_once "application/libraries/php_excel/lib/Classes/PHPExcel.php";
    $key_array = array();
    for ($i = 0; $i < 26; $i++) {
        $key_array[] = chr($i + 65);
    }
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objActSheet = $objPHPExcel->getActiveSheet();
    $objActSheet->setTitle("Sheet");
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    /*$temp_img = "application/helpers/temp_img";
    mkdir($temp_img);
    $objActSheet->getDefaultRowDimension()->setRowHeight(80);*/
    foreach($head as $key=>$value) {
        $column = num_to_excel_column($key + 1, $key_array);
        $objActSheet->setCellValueExplicit($column . 1, $value, PHPExcel_Cell_DataType::TYPE_STRING);
    }
    foreach ($data as $k => $obj) {
        $num = $k + 2;
        $j = 1;
        foreach($fields as $field){
            $column = num_to_excel_column($j,$key_array);
            /*if($j==1){
                $objActSheet->getColumnDimension($column)->setWidth(40);
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                url_to_local_img($obj[$field],$temp_img."/".$k.".jpg");
                $objDrawing->setPath($temp_img."/".$k.".jpg");
                $objDrawing->setHeight(80);
                $objDrawing->setWidth(80);
                $objDrawing->setCoordinates($column.$num);
                $objDrawing->setOffsetX(50);
                $objDrawing->setWorksheet($objActSheet);
            }else{
                $objActSheet->setCellValueExplicit($column.$num, $obj[$field], PHPExcel_Cell_DataType::TYPE_STRING);
            }*/
            $objActSheet->setCellValueExplicit($column.$num, $obj[$field], PHPExcel_Cell_DataType::TYPE_STRING);
            $j++;
        }
    }
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save($name.".xlsx");
     /*header('Content-Type: application/vnd.ms-excel');
     header('Content-Disposition: attachment;filename="' . $name . '.xlsx"');
     header('Cache-Control: max-age=0');
     $objWriter->save('php://output');*/
     /*delete_dir($temp_img);*/
}

//数字转换为A、B...AZ
function num_to_excel_column($n, $key_array) {
    $str = "";
    while($n>0){
        $yu = $n%26;
        $n = intval($n/26);
        if($yu==0){
            $str = $str.$key_array[25];
            $n--;
        }else{
            $str = $str.$key_array[$yu-1];
        }
    }
    return strrev($str);
}

/**
 * [set_headers 设置文件头]
 * @Date  2016-07-11
 * @param [type]     $file_path  [description]
 * @param [type]     $excel_name [description]
 */
function set_headers($file_path,$excel_name) 
{
   //文件的类型 
    header("Content-Type: application/force-download");
    //下载显示的名字 
    header('Content-Disposition: attachment; filename="'.$excel_name.'"'); 
    readfile($file_path); 
    exit(); 
}



/**
 * [weixin_remind 微信企业号提醒]
 * @param  [type] $tag_id  [渠道号，7-小红书，8-小红书测试]
 * @param  [type] $content [提醒内容]
 * @param  string $pass    [密码]
 * @return [type]          [description]
 */
function weixin_remind($tag_id,$content,$pass='buzhidao.')
{
    $url = "http://wx.shoplinq.cn/SendTextMsg";
    $tag_ids = [7,8];
    if (!in_array($tag_id,$tag_ids)) $tag_id = 8;
    if(!$content) $content = '没有内容，请检查相关应用';
    $content = urlencode($content);
    $param = '?tag='.$tag_id.'&msg='.$content.'&pass='.$pass;
    $url .= $param;
    $data = http($url,[], 'GET', [], 5,false);
    return json_decode($data,true);
}


/**
 * [http 调用接口函数]
 * @Date   2016-07-11
 * @Author GeorgeHao
 * @param  string       $url     [接口地址]
 * @param  array        $params  [数组]
 * @param  string       $method  [GET\POST\DELETE\PUT]
 * @param  array        $header  [HTTP头信息]
 * @param  integer      $timeout [超时时间]
 * @param  boolean      $sign    [是否加密]
 * @return [type]                [接口返回数据]
 */
function http($url, $params, $method = 'GET', $header = array(), $timeout = 5,$sign=false)
{
    $opts = array(
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header
    );

    if($sign)
    {
        $ts = time();
        $check =[
            "app_key=" . APP_KEY,
            "app_secret=" . APP_SECRET,
            "method=" . $method,
            "ts=" . $ts];
        sort($check);      
        $url .= '?sign='.md5(sha1(join("&", $check))).'&ts='.$ts.'&app_key='.APP_KEY.'&method='.$method;
    }
    /* 根据请求类型设置特定参数 */
    switch (strtoupper($method)) {
        case 'GET':
            if($params)
            {
               $opts[CURLOPT_URL] = $url . '?' . http_build_query($params); 
            }else
            {
                $opts[CURLOPT_URL] = $url;
            }
            break;
        case 'POST':
            $params = http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        case 'DELETE':
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_HTTPHEADER] = array("X-HTTP-Method-Override: DELETE");
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        case 'PUT':
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 0;
            $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
  
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    return $data;
}


/**
 * [format_ajax_data 格式化ajax 传过来的字符串]
 * @Date   2016-06-12
 * @param  [type]     $str [name=val&name1=val2]
 * @return [type]          [description]
 */
function format_ajax_data($str)
{
    $perfs = explode("&", $str);
    $data = [];
    foreach($perfs as $perf) {
        $perf_key_values = explode("=", $perf);
        $_perf_key_values =  isset($perf_key_values[1])?$perf_key_values[1]:'';
        $data[urldecode($perf_key_values[0])] = urldecode($_perf_key_values);
    }
    return $data;
}

/**
 * [image_handdle 图片处理]
 * @Date   2016-08-26
 * @param  [type]     $url    [图片地址，目前仅支持shoplinqCDN]
 * @param  integer    $width  [要切割图片宽度]
 * @param  integer    $height [要切割的高度]
 * @return [type]             [status,message,data]
 */
function image_handdle($url,$width=430,$height=430,$is_deal=true)
{
    $img_url = BASE_URL.'/public/api_image/get_image_crop';#获取买家信息接口
    if(strpos($url,'shoplinq')!=false && $is_deal==true) $url .= '!500'; 
    $data['data']['url']    = $url;
    $data['data']['width']  = $width;
    $data['data']['height'] = $height;
    return json_decode(http($img_url, $data,'POST', [],30,false),true);
}

/**
 * [str_to_realstr 将字符串转为真正的字符串，查询等使用 如 “a,b,c”=>"a","b","c"]
 * @param  [type] $str [含有分隔符的字符串]
 * @param  [type] $sign [含有分隔符的字符串]
 * @return [type]      [description]
 */
function str_to_realstr($str,$sign=",")
{
    if(!$str) return "";
    $str = rtrim($str,$sign);
    if(strpos($str,$sign)===false) return "'".$str."'";
    
    $str_arr = explode($sign,$str);
    $realstr = '';
    foreach ($str_arr as $key => $value) {
        $realstr .="'".$value."'".$sign."";
    }
    return rtrim($realstr,$sign);
}


/**
 * aliyunSms 
 * @param  string $telphone       手机号
 * @param  string $templatCode  固定话术对应编码
 * @param  json   $json_data      对应的参数信息
 */
function send_sms($telphone, $templatCode, $json_data)
{
    include 'tools/aliyunsms/AliyunSms.php';
    $aliyunSms = new AliyunSms();
    $res = $aliyunSms->sendMsg($telphone, $templatCode, $json_data);
    return $res;
}


/**
 * 生成随机的验证码
 * @param  int $count 验证码位数
 */
function createVerifyCode($count=6)
{
    $res = '';
    $str = '0123456789';
    for ($i=0; $i < $count; $i++) { 
        $str = str_shuffle($str);
        $res .= $str[8];
    }
    return $res;
}


/**
 * [U url生成器]
 * @param string $param1 [参数1]
 * @param string $param2 [参数2]
 */
function U($param1='',$param2='')
{
    $url = '/';

    $url .= $param1 ? $param1.'/' : '';
    $url .= $param2 ? $param2 : '';

    return $url.'.html';
}

/**
 * [PU url参数解析]
 */
function PU()
{
    $param = rtrim($_SERVER['REQUEST_URI'],'.html');
    return explode('/',ltrim($param,'/'));
}

