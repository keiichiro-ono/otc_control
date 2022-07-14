<?php

require_once('config/config.php');

$app = new \MyApp\Index();

$title = '新トップ';

?>

<?php include('template/header.php'); ?>


<body>
	<?php include('template/navber.php'); ?>

	<div class="container">

		<div class="row justify-content-center">
			<h1>OTC管理画面</h1>

			<div class="col-3">
				<h3>追加登録</h3>
				<div class="d-grid gap-4">
					<a href="new_otc.php" class="btn btn-primary p-3 rounded-pill fs-4" type="button">OTC新規登録</a>
					<a href="warehousing.php" class="btn btn-primary p-3 rounded-pill fs-4" type="button">入庫登録(BarCode)</a>
					<a href="proceeds.php" class="btn btn-primary p-3 rounded-pill fs-4" type="button">売上登録</a>
				</div>
			</div>
			<div class="col-3">
				<h3>一覧表示</h3>
				<div class="d-grid gap-2">
					<a href="otc_list_2.php" class="btn btn-warning p-3 rounded-pill fs-4" type="button">OTC一覧</a>
					<a href="otc_list_new.php" class="btn btn-warning p-3 rounded-pill fs-4" type="button">OTC一覧【入荷順】</a>
					<a href="calendar.php" class="btn btn-warning p-3 rounded-pill fs-4" type="button">販売一覧</a>
					<a href="warehousing_list.php" class="btn btn-warning p-3 rounded-pill fs-4" type="button">OTC新規登録</a>
					<a href="otc_list_new.php" class="btn btn-warning p-3 rounded-pill fs-4" type="button">入庫一覧</a>
					<a href="sales_calendar.php" class="btn btn-warning p-3 rounded-pill fs-4" type="button">月間売上</a>
				</div>
			</div>
			<div class="col-3">
				<h3>修正一覧</h3>
				<div class="d-grid gap-2">
					<a href="otc_list.php" class="btn btn-success p-3 rounded-pill fs-4" type="button">OTC編集</a>
				</div>
				<hr>
				<div class="d-grid gap-2">
					<a href="setting.php" class="btn btn-danger p-3 rounded-pill fs-4" type="button">設定</a>
				</div>

			</div>
		</div>

		<hr>

		<p class="text-end"><a href="../" class="btn btn-danger">トップメニューに戻る</a></p>

	</div>


</body>
</html>
