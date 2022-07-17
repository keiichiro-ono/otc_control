<?php

require_once('config/config.php');

$app = new \MyApp\Warehousing_list();
$ym = isset($_GET['ym']) ? $_GET['ym'] : date("Y-m");
$timeStamp = strtotime($ym. "-01");
if($timeStamp === false){
	$timeStamp = time();
	$ym = date("Y",$timeStamp).date("m",$timeStamp);
}
$prev = date("Y-m", mktime(0,0,0,date('m',$timeStamp)-1,1,date('Y',$timeStamp)));
$next = date("Y-m", mktime(0,0,0,date('m',$timeStamp)+1,1,date('Y',$timeStamp)));

$dayList = $app->daylist($ym);

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>入庫一覧画面</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style>
	img{
		width: 40px;
		height: auto;
	}
	.date{
		color: blue;
		cursor: pointer;
	}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">

		<div class="page-header">
		  <h1>入庫一覧画面</h1>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<nav aria-label="ページャー">
				  <ul class="pager">
				    <li><a href="?ym=<?= h($prev); ?>">&larr; 前</a></li>
				    <li><a href="?ym=<?= h(date("Y-m")); ?>">今月</a></li>
				    <li><a href="?ym=<?= h($next); ?>">次 &rarr;</a></li>
				  </ul>
				</nav>
				<div id="dayList" class="list-group">
				<?php foreach($dayList as $day): ?>
					<button type="button" class="list-group-item date"><?= h($day->date) ; ?></button>
				<?php endforeach; ?>
				</div>
			</div>
			<div class="col-sm-9" id="main">

			</div>

		</div>



	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script>
$(function(){
	$('#dayList').on('click', '.date', function(){
		var date = $(this).text();
		$('#main').load('_warehousingList_day.php?date='+date);
	});
});
</script>

</body>
</html>
