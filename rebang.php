<?php

/**
 * 开发者：TANKING
 * 时间：2022-09-27
 * 博客：https://segmentfault.com/u/tanking
 * GitHub：https://github.com/likeyun
 * WeChat：sansure2016
 * 如何使用？例如需要获取百度热榜，浏览器访问 http://www.nideyuming.com/rebang.php?plaform=baidu
 * 建议自己爬下来存到自己数据库，定时刷新，这样才不会那么容易被封禁IP
 */

// 返回JSON格式
header("Content-type:application/json");

// 需要拉取的平台
$plaform = trim($_GET["plaform"]);

// 实例化类
$Hotlist = new Hotlist();
echo $Hotlist -> getHotlist($plaform);

class Hotlist{

	// 获取各平台的热榜
	public function getHotlist($plaform){

		if ($plaform == 'toutiao') {

			// 获取头条热榜
			$htmlcontent = file_get_contents('https://www.toutiao.com/hot-event/hot-board/?origin=toutiao_pc');
			$hotList = $htmlcontent;

		} else if ($plaform == 'qqnews') {

			// 获取腾讯新闻热榜
			$htmlcontent = file_get_contents('https://i.news.qq.com/trpc.qqnews_web.kv_srv.kv_srv_http_proxy/list?sub_srv_id=24hours&srv_id=pc&offset=0&limit=20&strategy=1&ext={%22pool%22:[%22top%22],%22is_filter%22:7,%22check_type%22:true}');
			$hotList = $htmlcontent;

		} else if ($plaform == 'zhihu') {

			// 获取知乎热榜
			$htmlcontent = file_get_contents('https://www.zhihu.com/api/v4/search/top_search/tabs/hot/items');
			$hotList = $htmlcontent;

		} else if ($plaform == 'weibo') {

			// 获取微博热榜
			$htmlcontent = file_get_contents('https://weibo.com/ajax/side/hotSearch');
			$hotList = $htmlcontent;
			
		} else if ($plaform == 'baidu') {

			// 获取百度热榜
			$htmlcontent = file_get_contents('https://top.baidu.com/board?tab=realtime');
			$jq_1 = substr($htmlcontent, strripos($htmlcontent, "hotList") + 19);
			$jq_2 = substr($jq_1, 0, strrpos($jq_1, "moreAppUrl") - 11);
			$hotList = $jq_2;
			
		}

		// 返回热榜JSON
		return $hotList;
	}
}
?>
