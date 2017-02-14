/*
* @Author: haodaquan
* @Date:   2017-01-14 01:04:11
* @Last Modified by:   haodaquan
* @Last Modified time: 2017-01-14 01:04:33
*/

resizewindow();
$(window).resize(function () {
	resizewindow();
});
function resizewindow()
{
	var windowH = $(window).height();;//window.screen.availWidth;
	var obj = $(".row");
	var len = obj.length;
	var hgt = 0;
	for (var i = 0; i < len; i++) {
		if(i!=len-1)
		{
			hgt += $(obj[i]).height();
		}
	}
	var main_h = windowH-hgt;
	$("#main_div").height(main_h);
}