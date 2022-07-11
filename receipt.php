<?php

require_once('config/config.php');

$app = new \MyApp\Receipt();
if(isset($_GET['mgId']) && !empty($_GET['mgId'])){
	$receipt = $app->getIdData();
	$existSelfMed = $app->existSelfMed($receipt);
	$date = explode("-", $app->getDate());
	$sum = $app->getSumPrice();
	$tax = (int)round($sum - ($sum / (1+TAX/100)));
} else {
	$list = $app->getList();
	$dayList = $app->getDayList();
}

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>領収書</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<link rel="stylesheet" media="print" href="lib/js/print.css">
	<style>
	.noPrintIcon > span {
	  color: red;
	  cursor: pointer;
	}
	.noPrintIcon > span:hover {
	  background: #eee;
	}
	#post_number{
		margin-right: 90px;
	}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
	<?php if(isset($_GET['mgId']) && !empty($_GET['mgId'])): ?>

		<div class="noPrintIcon">
			<span class="fa-stack fa-4x">
			  <i class="fa fa-square-o fa-stack-2x"></i>
			  <i class="fa fa-print fa-stack-1x"></i>
			</span>
		</div>

		<p class="text-right">
			<?= h($date[0]); ?>年 <?= h($date[1]); ?>月 <?= h($date[2]); ?>日
		</p>
		<p class="text-right">
			管理番号: <?= h($_GET['mgId']); ?>
		</p>

		<div class="page-header">
		  <h3 class="text-center">領収書</h3>
		</div>

		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<table class="table table-condensed">
					<thead>
						<tr>
							<th>商品名</th>
							<th>規格</th>
							<th>販売個数</th>
							<th class="text-right">値段（税込み）</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($receipt as $rece): ?>
						<tr>
							<td>
								<?= h($app->checkSelfMed($rece->self_med)); ?>
								<?= h($rece->name); ?>
							</td>
							<td><?= h($rece->size); ?></td>
							<td><?= h($rece->sale_nums); ?>個</td>
							<td class="text-right"><?= h($rece->actual_price); ?>円</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3" class="text-right">合計</th>
							<th class="text-right"><?= h(number_format($sum)); ?>円</th>
						</tr>
						<tr>
							<td colspan="3" class="text-right">（内、消費税等</td>
							<td class="text-right"><?= h($tax); ?>円）</td>
						</tr>
					</tfoot>
				</table>
			<?php if($existSelfMed): ?>
				<p>★印はセルフメディケーション税制対象商品です。<br><?= h($date[0]); ?>年1月1日より申告対象です。</p>
			<?php endif; ?>
			</div>
		</div>
		<h4 class="text-right">小田薬局 東伏見店</h4>
		<p class="text-right">
			<span id="post_number">〒202-0021</span><br>
			東京都西東京市東伏見5-9-17</p>
		<p class="text-right">
			TEL: 042-461-8558<br>
			FAX: 042-461-8578
		</p>
	<?php else: ?>
		<div class="page-header">
			<h1>領収書一覧画面</h1>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<div id="dayList" class="list-group">
				<?php foreach($dayList as $day): ?>
					<button type="button" class="list-group-item date"><?= h($day->date) ; ?></button>
				<?php endforeach; ?>
				</div>
			</div>
			<div class="col-sm-9" id="main">

			</div>

		</div>
	<?php endif; ?>


	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script>
$(function(){

	var existGET = $(location).attr('search');
	if(existGET){
		print_setting();
	}

	$('#dayList').on('click', '.date', function(){
		var date = $(this).text();
		$('#main').load('_receList_day.php?date='+date);
	});

	$('.noPrintIcon').click(function(){
		print_setting();
	});

	function print_setting(){
		$('p').css('font-size', '11px');
		$('p').css('margin-bottom', '3px');
		$('th').css('font-size', '11px');
		$('th').css('padding', '2px');
		$('td').css('font-size', '11px');
		$('td').css('padding', '2px');
		window.print();
	}


});
</script>

</body>
</html>
