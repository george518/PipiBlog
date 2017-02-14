<?php
/************************************************************
** @Description: 文件图片上传基础类
** @Author: haodaquan
** @Date:   2016-11-28 13:52:48
** @Last Modified by:   haodaquan
** @Last Modified time: 2017-01-15 00:52:52
*************************************************************/

class Upload extends MY_Controller
{
    public $file_path    = UPLOAD_PATH;
    public $allow_type   = ["jpg", "png", "gif",'xlsx'];//允许上传文件格式 
    public $allow_size   = 2097152;//上传文件大小 2M2*1024*1024

    /**
     * [file 文件上传]
     * @return [type] [description]
     */
    public function file()
    {
        $file = $this->input->get('file');
        $size = $this->input->get('size');

        if(!$file) $this->return_error('上传文件配置有误');
        if(!isset($_POST)) $this->return_error('上传有误！');

        $name     = $_FILES['file']['name']; 
        $size     = $_FILES['file']['size']; 
        $name_tmp = $_FILES['file']['tmp_name']; 
        if (empty($name)) $this->return_error('您还未选择文件');
        #判断文件类型
        $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型 
        if (!in_array($type, $this->allow_type)) $this->return_error('请上传正确类型的文件！');
        if ($size > $this->allow_type)  $this->return_error('文件大小已超过2M限制！');
        
        #上传地址 

        $path = $this->file_path.$file.'/'.date('Y-m-d',time()).'/';
        if(!is_dir($path)) make_dir($path);
        $file_name = time() . rand(10000, 99999) . "." . $type;//名称 
        $file_path = $path .  $file_name; //上传后路径+名称
        $return_file_path = $file.'/'.date('Y-m-d',time()).'/'. $file_name;//返回后的地址

        if (move_uploaded_file($name_tmp, $file_path)) 
        { 
            //临时文件转移到目标文件夹 
            echo json_encode(array("error"=>"0","path"=>$return_file_path,"name"=>$name)); 
            exit();
        } 
        $this->return_error('上传有误，请检查服务器配置！');
    }


    /**
     * [return_error 返回错误]
     * @param  [type] $msg [错误信息]
     * @return [type]      [description]
     */
    public function return_error($msg)
    {
    	echo json_encode(["error"=>$msg]);
    	exit();
    }

    public function image()
    {
        $file   = $this->input->get('file');
        $width  = $this->input->get('w');
        $height = $this->input->get('h');

        if (!$file) $this->return_error('上传文件配置有误');
        if (isset($_POST)) 
        { 
            $name     = $_FILES['file']['name']; 
            $size     = $_FILES['file']['size']; 
            $name_tmp = $_FILES['file']['tmp_name']; 
           
            if (empty($name)) $this->return_error('您还未选择图片');
            $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型 
            if (!in_array($type, $this->allow_type)) $this->return_error('请上传正确类型的图片！');
            if ($size > $this->allow_size) $this->return_error('图片大小已超过2M限制！');
            
            $imageInfo = $this->getImageInfo($name_tmp);
            if($width!=0 && $imageInfo['width']!=$width) $this->return_error('图片宽度不符合要求！');
            if($height!=0 && $imageInfo['height']!=$height) $this->return_error('图片高度不符合要求！');
            $time = date('Y-m-d',time()); 
            $path = $this->file_path.$file.'/'.$time.'/';
            if(!is_dir($path)) make_dir($path);
            $pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称 
            // $path_arr = explode('/', $file);
            // $img_path = isset($path_arr[1]) ? '/'.$path_arr[1] : '';
            $pic_url = $path . $pic_name;//上传后图片路径+名称
            //$img_url = $img_path.'/'.$time.'/'.$pic_name; #访问名称
            if (move_uploaded_file($name_tmp, $pic_url)) 
            { 
                //临时文件转移到目标文件夹 
                echo json_encode(array("error"=>"0","pic"=>'/'.$pic_url,"name"=>$pic_name)); 
            } else 
            { 
                $this->return_error('上传有误，请检查服务器配置！');
            } 
        }
    }

    /**
     * [getImageInfo 获取图片信息]
     * @Author haodaquan
     * @Date   2016-04-14
     * @param  [type]     $img [图片临时存储地址]
     * @return [type]          [description]
     */
    public function getImageInfo($img)
    {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) 
        {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
            $imageSize = filesize($img);
            $info = array(
                "width" => $imageInfo[0],
                "height" => $imageInfo[1],
                "type" => $imageType,
                "size" => $imageSize,
                "mime" => $imageInfo['mime']
            );
            return $info;
        } else 
        {
            return false;
        }
    }

    
}
