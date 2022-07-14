<?php

require_once('config/config.php');

$app = new \MyApp\Index();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>top</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
  <script src="lib/js/jquery-3.2.1.min.js"></script>
  <script src="lib/js/tether.js"></script>
	<script src="lib/js/bootstrap.min.js"></script>

</head>
<body>
<?php include('nav.php'); ?>
	<div class="container">

  	<div class="row">
			<div class="page-header">
			  <h1>OTC管理画面</h1>
			</div>
			<div class="col-sm-3 col-sm-offset-1">
				<h3>追加登録</h3>
				<a href="new_otc.php" class="btn btn-primary btn-lg btn-block">OTC新規登録</a>
				<!-- <a href="sale.php" class="btn btn-primary btn-lg btn-block">販売新規登録</a> -->
				<a href="warehousing.php" class="btn btn-primary btn-lg btn-block">入庫登録(BarCode)</a>
				<a href="proceeds.php" class="btn btn-primary btn-lg btn-block">売上登録</a>
			</div>
			<div class="col-sm-3">
				<h3>一覧表示</h3>
				<a href="otc_list_2.php" class="btn btn-warning btn-lg btn-block">OTC一覧</a>
				<a href="otc_list_new.php" class="btn btn-warning btn-lg btn-block">OTC一覧【入荷順】</a>
				<a href="calendar.php" class="btn btn-warning btn-lg btn-block">販売一覧</a>
				<!-- <a href="receipt.php" class="btn btn-warning btn-lg btn-block">領収書一覧</a> -->
				<a href="warehousing_list.php" class="btn btn-warning btn-lg btn-block">入庫一覧</a>
				<a href="sales_calendar.php" class="btn btn-warning btn-lg btn-block">月間売上</a>
			</div>
			<div class="col-sm-3">
				<h3>修正一覧</h3>
				<a href="otc_list.php" class="btn btn-success btn-lg btn-block">OTC編集</a>
				<hr>
				<a href="setting.php" class="btn btn-danger btn-lg btn-block">設定</a>
			</div>

    </div>
    <!-- row -->
		<hr>

		<p class="text-right"><a href="../" class="btn btn-danger">トップメニューに戻る</a></p>

	</div>
  <!-- container -->



	</div>

<script>
$(function(){

});
</script>

</body>
</html>
