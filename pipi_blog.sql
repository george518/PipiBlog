/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50712
 Source Host           : localhost
 Source Database       : pipi_blog

 Target Server Version : 50712
 File Encoding         : utf-8

 Date: 02/14/2017 23:52:41 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `pp_ad`
-- ----------------------------
DROP TABLE IF EXISTS `pp_ad`;
CREATE TABLE `pp_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ad_name` varchar(128) NOT NULL DEFAULT '0' COMMENT '广告位置名称',
  `ad_detail` varchar(255) NOT NULL COMMENT '广告位备注',
  `ad_code` text NOT NULL COMMENT '广告位代码',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  `edit_time` int(11) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态0-正常1-删除',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '99' COMMENT '排序越大越往前',
  `ad_tag` varchar(32) NOT NULL DEFAULT 'index' COMMENT '广告位置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `pp_ad`
-- ----------------------------
BEGIN;
INSERT INTO `pp_ad` VALUES ('1', '搜索', '顶顶顶顶dd', '水电费水电费sdfs', '1486347968', '1486348137', '0', '99', 'index_right_1'), ('2', 'sds', 'sdsdd', 'sdfsdfds', '1486349389', '1486361515', '0', '99', 'index_right_2'), ('3', '首页', '首页', '<a href=\"www.baidu.com\">广告位置</a>', '1486532904', '1486914379', '0', '99', 'index_main_list_1'), ('4', '首页右下1', 'index_right_3', '<a href=\"#\" target=\"_blank\" rel=\"nofollow\" title=\"测试\" >\r\n		<img style=\"width: 100%\" src=\"/static/img/default.png\" alt=\"测试\" ></a> ', '1486534054', '1486914368', '0', '99', 'index_right_3'), ('5', '首页右下2', 'index_right_4', '<a href=\"#\" target=\"_blank\" rel=\"nofollow\" title=\"测试\" >\r\n		<img style=\"width: 100%\" src=\"/static/img/default.png\" alt=\"测试\" ></a> ', '1486534072', '1486914342', '0', '99', 'index_right_4');
COMMIT;

-- ----------------------------
--  Table structure for `pp_article`
-- ----------------------------
DROP TABLE IF EXISTS `pp_article`;
CREATE TABLE `pp_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '0' COMMENT '标题',
  `from` varchar(20) DEFAULT 'admin' COMMENT '发布人',
  `cate_id` int(11) DEFAULT '0' COMMENT '栏目id',
  `img_src` varchar(100) DEFAULT NULL COMMENT '封面信息',
  `content` text COMMENT '内容',
  `recommand` tinyint(1) DEFAULT '0' COMMENT '推荐0-不推荐，1-表示推荐',
  `headline` tinyint(1) unsigned DEFAULT '0' COMMENT '头条0-正常，1-头条',
  `tag` varchar(30) NOT NULL COMMENT '关键字',
  `detail` char(255) NOT NULL COMMENT '描述',
  `hits` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '点击量',
  `add_time` varchar(11) DEFAULT '0',
  `edit_time` varchar(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否删除0-正常，1-删除',
  `is_original` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否原创 0-非原创，1-原创',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `pp_article`
-- ----------------------------
BEGIN;
INSERT INTO `pp_article` VALUES ('1', 'php 图片指定留白叠加缩放', 'admin', '1', '/Uploads/image/article/2017-02-12/148691296230413.jpg', '<p style=\"margin: 10px auto; padding: 0px; list-style-type: none; list-style-image: none; color: rgb(68, 68, 68); font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">遇到这样一个需求：原图大小不一，而且留白也大小不一，需要将原图切出来一个核心图，然后将图片左右留白，组成一个其他尺寸的图片。换句话说，原图在新图片中的位置是可以控制的。</p><p style=\"margin: 10px auto; padding: 0px; list-style-type: none; list-style-image: none; color: rgb(68, 68, 68); font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">这里思路是：先创建一个规定大小的底图，然后将原图经过缩放后，放到底图中，也就是图片叠加。</p><p style=\"margin: 10px auto; padding: 0px; list-style-type: none; list-style-image: none; color: rgb(68, 68, 68); font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">####这里实现的是第二个箭头所示的效果。</p><p style=\"margin: 10px auto; padding: 0px; list-style-type: none; list-style-image: none; color: rgb(68, 68, 68); font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">（完成第一个箭头效果请移步http://www.cnblogs.com/haodaquan/p/6381636.html）</p><p style=\"margin: 10px auto; padding: 0px; list-style-type: none; list-style-image: none; color: rgb(68, 68, 68); font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><img src=\"http://images2015.cnblogs.com/blog/270062/201702/270062-20170209140113197-1006517330.png\" alt=\"\" width=\"655\" height=\"248\" style=\"border: none; margin-top: 20px; margin-bottom: 20px; max-width: 650px;\"/></p><p style=\"margin: 10px auto; padding: 0px; list-style-type: none; list-style-image: none;\">下面的代码可供参考：</p><p><br/></p><p><br/></p><p>&lt;?php</p><p>/************************************************************</p><p>** @Description: &nbsp;图片叠加demo</p><p>** @Author: haodaquan</p><p>** @Date: &nbsp; 2016-11-30 12:07:51</p><p>** @Last Modified by: &nbsp; haodaquan</p><p>** @Last Modified time: 2017-02-09 13:59:51</p><p>*************************************************************/</p><p>header(&#39;content-type:image/jpeg&#39;);#图片显示</p><p><br/></p><p>$bg_width = $bg_height = 600;</p><p><br/></p><p>#创建真彩色画布并填补灰色</p><p>$final_srouce &nbsp; &nbsp; &nbsp; = imagecreatetruecolor($bg_width,$bg_height);</p><p>$background_color = imagecolorAllocate($final_srouce,255,255,255);#白色底色</p><p>imagefill($final_srouce,0,0,$background_color);&nbsp;</p><p>#获取覆盖图片 大小为121*75</p><p>$source &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; = &#39;/Users/haodaquan/Sites/PyWeb/CoreImage/newImage/new_image.jpg&#39;;</p><p>$img_source &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;= imagecreatefromjpeg($source);</p><p>$info &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; = getimagesize($source);</p><p>######################</p><p>#1、直接覆盖图片加到画布上&nbsp;</p><p>#前两个数字为画布起始xy坐标，中间两个数字为覆盖图片的起始xy坐标，最后两个数字表示覆盖图片的xy长度</p><p>#imagecopy($final_srouce,$img_source,30,50,0,0,121,75);</p><p><br/></p><p>#新图宽度留白，高度留白</p><p>$blank_width &nbsp;= 30;</p><p>$blank_height = 50;</p><p><br/></p><p>#假设宽度优先填满新图,宽度大于高度的图</p><p>#计算缩放比率</p><p>$new_width &nbsp;= $bg_width-2*$blank_width;</p><p>$new_height = $info[1]*($new_width/$info[0]);</p><p><br/></p><p>#2、带缩放的叠加 详见底部函数注释</p><p>imagecopyresampled($final_srouce,$img_source,$blank_width,$blank_height,0,0,$new_width,$new_height,$info[0],$info[1]);</p><p>######################</p><p><br/></p><p>imagejpeg($final_srouce, &#39;./tmp/final_srouce.jpeg&#39;,100);#生成图片 第三个参数为质量[1-100]</p><p>imagejpeg($final_srouce); #页面显示图片</p><p><br/></p><p>#销毁资源</p><p>imagedestroy($final_srouce);</p><p>imagedestroy($img_source);</p><p><br/></p><p><br/></p><p>// bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )</p><p>// $dst_image：新建的图片</p><p>// $src_image：需要载入的图片</p><p>// $dst_x：设定需要载入的图片在新图中的x坐标</p><p>// $dst_y：设定需要载入的图片在新图中的y坐标</p><p>// $src_x：设定载入图片要载入的区域x坐标</p><p>// $src_y：设定载入图片要载入的区域y坐标</p><p>// $dst_w：设定载入的原图的宽度（在此设置缩放）</p><p>// $dst_h：设定载入的原图的高度（在此设置缩放）</p><p>// $src_w：原图要载入的宽度</p><p>// $src_h：原图要载入的高度</p><p><span class=\"cnblogs_code_copy\" style=\"padding-right: 5px; line-height: 1.5 !important;\"><a title=\"复制代码\" style=\"color: rgb(51, 153, 255); border: none !important;\"></a></span><br/></p><p style=\"margin: 10px auto; padding: 0px; list-style-type: none; list-style-image: none;\">&nbsp;</p><p>码代码不易，码文字更不易，转载请注明出处，多谢！ 不仅仅是记录，也是分享</p><p><br/></p>', '0', '1', 'php,图片处理', '遇到这样一个需求：原图大小不一，而且留白也大小不一，需要将原图切出来一个核心图，然后将图片左右留白，组成一个其他尺寸的图片。换句话说，原图在新图片中的位置是可以控制的。', '10', '1486912009', '1486913343', '0', '1'), ('2', '推荐文章1', 'admin', '1', '/Uploads/image/article/2017-02-12/148691296230413.jpg', '<p>这是测试的内容这是测试的内容这是测试的内容这是测试的内容这是测试的内容这是测试的内容</p>', '1', '0', '测试标签,测试标签2,JavaScript,架构', '这是测试的内容', '1', '1486912925', '1487493847', '0', '1'), ('3', '推荐文章2', 'admin', '2', '/Uploads/image/article/2017-02-12/148691296230413.jpg', '<p>sdfsdfsdfsdfs</p>', '1', '0', '对对对,dsfs', 'sdfsdfsd', '3', '1486912968', '0', '0', '1'), ('4', '普通文章1', 'admin', '1', '/Uploads/image/article/2017-02-12/148691300854417.jpg', '<p>是的发送到方式是的发送到方式发</p>', '0', '0', '图片处理,测试标签,测试标签2', '水电费水电费', '1', '1486913010', '0', '0', '1'), ('5', 'sdsdfsd', 'admin', '2', '/Uploads/image/article/2017-02-12/148691296230413.jpg', '<p>是短发是发达时发生</p>', '0', '0', '防守打法', '说的方式发送到发送', '3', '1487400800', '0', '0', '1'), ('6', '修改', 'admin', '1', '/Uploads/image/article/2017-02-12/148691296230413.jpg', '<p>中国字中国字中国字中国字ddsdfsd<img src=\"/Uploads/ueditor/image/20170308/1488966693699264.jpg\" title=\"1488966693699264.jpg\" alt=\"1-140RGK442.jpg\"/>中国字中国字中国字中国字中国字中国《是非得失》字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字是的范德萨发生分是的范德萨sdfsdfdsfdfdddsdfdsfdssdfdsfdsfdsdssdfdsfdsfds水电费山东省地方《》</p>', '0', '0', 'php,图片处理', '中国字中国字中国字中国字ddsdfsd中国字中国字中国字中国字中国字中国《是非得失》字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字中国字是的范德萨发生分是的范德萨sdfsdfdsfdfdddsdfdsfdssdfdsfdsfdsdssd', '20', '1488040966', '1488966898', '0', '1');
COMMIT;

-- ----------------------------
--  Table structure for `pp_article_tag`
-- ----------------------------
DROP TABLE IF EXISTS `pp_article_tag`;
CREATE TABLE `pp_article_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `article_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `pp_article_tag`
-- ----------------------------
BEGIN;
INSERT INTO `pp_article_tag` VALUES ('5', '2', '3'), ('6', '2', '4'), ('7', '3', '5'), ('8', '3', '6'), ('9', '4', '2'), ('10', '4', '3'), ('11', '4', '4'), ('12', '1', '1'), ('13', '1', '2');
COMMIT;

-- ----------------------------
--  Table structure for `pp_banner`
-- ----------------------------
DROP TABLE IF EXISTS `pp_banner`;
CREATE TABLE `pp_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '0' COMMENT '标题',
  `detail` varchar(500) DEFAULT '0' COMMENT '备注',
  `img_src` varchar(500) DEFAULT NULL COMMENT '封面信息',
  `url` varchar(500) DEFAULT NULL COMMENT '内容',
  `sort` tinyint(1) DEFAULT '0' COMMENT '排序 越小越往前',
  `add_time` varchar(11) DEFAULT '0',
  `edit_time` varchar(11) DEFAULT '0',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除0-正常，1-删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `pp_banner`
-- ----------------------------
BEGIN;
INSERT INTO `pp_banner` VALUES ('1', '广告的名字', '这是一个备注', '/Uploads/image/banner/2017-02-11/148681393034503.png', 'http://www.baidu.com', '1', '1484584512', '1486813939', '0'), ('2', '第二个广告', '这是第二个广告', '/Uploads/image/banner/2017-02-11/148681864985453.png', 'http://www.taobao.com', '2', '1484584624', '1486818652', '0'), ('3', 'dsfsd', 'sdfds', '/Uploads/image/banner/2017-02-11/148682814181478.png', 'http://www.tao.com', '4', '1484586174', '1486828148', '0');
COMMIT;

-- ----------------------------
--  Table structure for `pp_category`
-- ----------------------------
DROP TABLE IF EXISTS `pp_category`;
CREATE TABLE `pp_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(30) NOT NULL COMMENT '分类名称',
  `pid` int(11) NOT NULL COMMENT '分类父id',
  `is_nav` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为导航，0为不在导航显示',
  `sort` int(11) NOT NULL DEFAULT '99' COMMENT '排序',
  `keywords` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `add_time` varchar(11) DEFAULT '0',
  `edit_time` varchar(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否删除0-正常，1-删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='栏目分类表';

-- ----------------------------
--  Records of `pp_category`
-- ----------------------------
BEGIN;
INSERT INTO `pp_category` VALUES ('1', '编程语言', '0', '1', '1', 'php,c,python,javascript', '分享编程语php,c,python,javascript方面的心得体会.', '1484363208', '1486831876', '0'), ('2', '数据库', '0', '1', '2', 'mysql,redis,mongoDB', '分享数据库mysql,redis,mongoDB的心得体会', '1484414668', '1486831969', '0'), ('3', '服务器', '0', '1', '3', 'linux,nginx', '分享服务器linux,nginx,python方面等方面的心得体会', '1486832088', '0', '0'), ('4', '技术新闻', '0', '1', '5', '技术新闻,编程新闻', '摘抄或发布一些技术方面的新闻', '1486832263', '1487086357', '0'), ('5', '其他预留', '0', '1', '5', '六畜订单', '水电费', '1484363241', '1486832718', '1'), ('6', '其他', '0', '1', '6', '', '', '1484364656', '1486832725', '1'), ('7', '算法', '0', '1', '4', '算法', '本栏目研讨一些算法', '1487086085', '1487086370', '0'), ('8', '生活点滴', '0', '1', '6', '技术生活', '本栏目记录一些生活感悟', '1487086399', '1487086414', '0');
COMMIT;

-- ----------------------------
--  Table structure for `pp_config`
-- ----------------------------
DROP TABLE IF EXISTS `pp_config`;
CREATE TABLE `pp_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL DEFAULT '0' COMMENT '键值',
  `value` varchar(1000) NOT NULL DEFAULT '0' COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-正常1-删除',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `edit_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `pp_config`
-- ----------------------------
BEGIN;
INSERT INTO `pp_config` VALUES ('1', 'web_name', '在路上_技术分享博客', '0', '0', '1488968033'), ('2', 'keywords', 'c,php,python,mysql,redis,linux', '0', '0', '1488968033'), ('3', 'description', '分享技术之路上所得所思,php,python,mysql,redis,linux等技术使用心得,坚信技术一直在路上,在路上,勤思考,重实践,懂分享.', '0', '0', '1488968033'), ('4', 'slogan', '在路上 勤思考 懂分享', '0', '0', '1488968033'), ('5', 'logo', '', '0', '0', '1488968033'), ('6', 'foot', 'Copyright © 2017.<a href=\'http://www.haodaquan.com\'>在路上</a> All rights reserved.', '0', '0', '1488968033'), ('7', 'host', 'http://www.haodaquan.com', '0', '0', '1488968033'), ('8', 'tongji', '', '0', '0', '1488968033'), ('9', 'duoshuo_name', 'haodaquan', '0', '0', '1488968033'), ('10', 'copyright', '欢迎转载，但任何转载必须保留完整文章，在显要地方显示署名以及原文链接。如您有任何疑问，请给我留言。', '0', '0', '1488968033');
COMMIT;

-- ----------------------------
--  Table structure for `pp_link`
-- ----------------------------
DROP TABLE IF EXISTS `pp_link`;
CREATE TABLE `pp_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(128) NOT NULL DEFAULT '0' COMMENT '友情连接关键字',
  `link_url` text NOT NULL COMMENT '网址',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  `edit_time` int(11) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态0-正常1-删除',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '99' COMMENT '排序越大越往前',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `pp_link`
-- ----------------------------
BEGIN;
INSERT INTO `pp_link` VALUES ('1', '技术博客', 'http://www.haodaquan.com', '1484454156', '1486832633', '0', '1'), ('2', '编程语言', 'http://www.haodaquan.com', '1484454177', '1486832678', '0', '2'), ('3', '连接名称5', 'http://www.baidu.com', '1484454192', '1484454201', '1', '13');
COMMIT;

-- ----------------------------
--  Table structure for `pp_tag`
-- ----------------------------
DROP TABLE IF EXISTS `pp_tag`;
CREATE TABLE `pp_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `tag_name` varchar(64) NOT NULL DEFAULT '0' COMMENT '标签名',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `edit_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0-正常，1-删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `pp_tag`
-- ----------------------------
BEGIN;
INSERT INTO `pp_tag` VALUES ('1', 'php', '1486912009', '0', '0'), ('2', '图片处理', '1486912009', '0', '0'), ('3', 'mysql', '1486912925', '1487086117', '0'), ('4', 'python', '1486912925', '1487086130', '0'), ('5', 'JavaScript', '1486912968', '1487086144', '0'), ('6', '架构', '1486912968', '1487086176', '0');
COMMIT;

-- ----------------------------
--  Table structure for `uc_user`
-- ----------------------------
DROP TABLE IF EXISTS `uc_user`;
CREATE TABLE `uc_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login_name` varchar(32) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL DEFAULT '0' COMMENT '密码',
  `user_name` varchar(32) NOT NULL COMMENT '用户名称',
  `add_time` int(11) NOT NULL,
  `edit_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `uc_user`
-- ----------------------------
BEGIN;
INSERT INTO `uc_user` VALUES ('1', 'admin', 'd3959843213ec8e940dc8953a788619e', '管理员', '1484023044', '1484023044');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
