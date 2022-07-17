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

			<div class="col-sm-4 col-md-3">
				<h3>追加登録</h3>
				<div class="d-grid gap-4">
					<a href="new_otc.php" class="btn btn-outline-primary p-3 rounded-pill fs-5" type="button"><i class="bi bi-file-earmark-plus"></i> OTC新規登録</a>
					<a href="warehousing.php" class="btn btn-outline-primary p-3 rounded-pill fs-5" type="button"><i class="bi bi-arrow-right"></i><i class="bi bi-shop-window"></i> 入庫登録</a>
					<a href="proceeds.php" class="btn btn-outline-primary p-3 rounded-pill fs-5" type="button"><i class="bi bi-arrow-right"></i><i class="bi bi-person-fill"></i> 売上登録</a>
					<a href="returned.php" class="btn btn-outline-primary p-3 rounded-pill fs-5" type="button"><i class="bi bi-reply-fill"></i> 返品登録</a>
				</div>
			</div>
			<div class="col-sm-4 col-md-3">
				<h3>一覧表示</h3>
				<div class="d-grid gap-2">
					<a href="otc_list_alp.php" class="btn btn-outline-warning p-3 rounded-pill fs-5" type="button"><i class="bi bi-list-columns-reverse"></i> OTC一覧</a>
					<a href="kiki_list.php" class="btn btn-outline-warning p-3 rounded-pill fs-5" type="button"><i class="bi bi-list-columns-reverse"></i> 医療機器一覧</a>
					<a href="hygiene_list.php" class="btn btn-outline-warning p-3 rounded-pill fs-5" type="button"><i class="bi bi-list-columns-reverse"></i> 衛生用品一覧</a>
					<a href="otc_list_new.php" class="btn btn-outline-warning p-3 rounded-pill fs-5" type="button"><i class="bi bi-stars"></i> 新入荷一覧</a>
					<a href="calendar.php" class="btn btn-outline-warning p-3 rounded-pill fs-5" type="button"><i class="bi bi-calendar-week"></i> 販売一覧</a>
					<a href="sales_calendar.php" class="btn btn-outline-warning p-3 rounded-pill fs-5" type="button"><i class="bi bi-currency-yen"></i> 月間売上</a>
				</div>
			</div>
			<div class="col-sm-4 col-md-3">
				<h3>設定</h3>
				<!-- <div class="d-grid gap-2">
					<a href="otc_list.php" class="btn btn-outline-success p-3 rounded-pill fs-5" type="button"><i class="bi bi-pencil-square"></i> OTC編集</a>
				</div>
				<hr> -->
				<div class="d-grid gap-2">
					<a href="setting.php" class="btn btn-outline-danger p-3 rounded-pill fs-5" type="button"><i class="bi bi-gear"></i> 設定</a>
				</div>

			</div>
		</div>

		<hr>

		<p class="text-end"><a href="../" class="btn btn-danger">トップメニューに戻る</a></p>

	</div>


</body>
</html>
