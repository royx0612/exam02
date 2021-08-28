<?php
include "class/database.class.php";

$do = $_GET['do'] ?? 'home';

/******************************************* */
$dbVisiter = new Database('visiters');
//今日瀏覽
$dbVisiter->setWhere([
	['date', '=', date('Y-m-d')]
]);
$rowVisiter = $dbVisiter->fetch();

//新增一筆當天的瀏覽資料
if (!$rowVisiter) {
	$insertIDVisiter = $dbVisiter->create([
		'date' => date('Y-m-d'),
		'visited' => 0
	]);
}
//未瀏覽過
if (!isset($_SESSION['visiter'])) {
	$dbVisiter->update([
		'visited' => $rowVisiter['visited'] + 1
	]);
	$_SESSION['visiter'] = '1';
}
//更新今日人數
$rowVisiter = $dbVisiter->fetch();

//總瀏覽人數
$totoalVisited = $dbVisiter->math('sum', 'visited');
/******************************************* */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0039) -->
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<title>健康促進網</title>
	<link href="./css/css.css" rel="stylesheet" type="text/css">
	<script src="./js/jquery-1.9.1.min.js"></script>
	<script src="./js/js.js"></script>
</head>

<body>
	<div id="alerr" style="background:rgba(51,51,51,0.8); color:#FFF; min-height:100px; width:300px; position:fixed; display:none; z-index:9999; overflow:auto;">
		<pre id="ssaa"></pre>
	</div>
	<iframe name="back" style="display:none;"></iframe>
	<div id="all">
		<div id="title">
			<?= date('m月d日 l') ?> | 今日瀏覽: <?= $rowVisiter['visited'] ?> | 累積瀏覽: <?= $totoalVisited ?> </div>
		<div id="title2">
			<a href="/"><img src="./icon/02B01.jpg" width="100%">
		</div></a>
		<div id="mm">
			<div class="hal" id="lef">
				<a class="blo" href="?do=admin">帳號管理</a>
				<a class="blo" href="?do=news">分類網誌</a>
				<a class="blo" href="?do=article">最新文章管理</a>
				<a class="blo" href="#">講座管理</a>
				<a class="blo" href="?do=questionnaire">問卷管理</a>
			</div>
			<div class="hal" id="main">
				<div>
					<marquee style="width:80%">請民眾踴躍投稿電子報，讓電子報成為大家相互交流、分享的園地！詳見最新文章</marquee>
					<span style="width:18%; display:inline-block;">
						<?php if (isset($_SESSION['username'])) : ?>
							歡迎，<?= $_SESSION['username'] ?><input type="button" value="登出" onclick="location.href='/api/logout.php'">
						<?php else : ?>
							<a href="?do=login">會員登入</a>
						<?php endif ?>
					</span>
					<div class="">
						<?php include "layouts/backend/{$do}.php" ?>
					</div>
				</div>
			</div>
		</div>
		<div id="bottom">
			本網站建議使用：IE9.0以上版本，1024 x 768 pixels 以上觀賞瀏覽 ， Copyright © 2021健康促進網社群平台 All Right Reserved
			<br>
			服務信箱：health@test.labor.gov.tw<img src="./icon/02B02.jpg" width="45">
		</div>
	</div>

</body>

</html>