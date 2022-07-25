<?php

require_once('config/config.php');

$app = new \MyApp\Index();

$title = 'OTC管理画面TOP';

?>

<?php include('template/header.php'); ?>


<body>
	<?php include('template/navber.php'); ?>

	<div class="container">

		<div class="row justify-content-center my-4">
			<h1><i class="bi bi-shop"></i> OTC管理画面</h1>

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
				<div class="d-grid gap-2">
					<a href="setting.php" class="btn btn-outline-danger p-3 rounded-pill fs-5" type="button"><i class="bi bi-gear"></i> 設定</a>
				</div>
				<hr>
				<h4>高度、特定保守機器一覧</h4>
				<div class="d-grid gap-2">
					<a href="warehousing_kiki_list.php" class="btn btn-outline-success p-2 rounded-pill fs-5" type="button"><i class="bi bi-list-columns-reverse"></i> 出庫</a>
					<a href="sale_kiki_list.php" class="btn btn-outline-success p-2 rounded-pill fs-5" type="button"><i class="bi bi-list-columns-reverse"></i> 入庫</a>
					<a href="inout_kiki_list.php" class="btn btn-outline-success p-2 rounded-pill fs-5" type="button"><i class="bi bi-list-columns-reverse"></i> 出入庫</a>
				</div>
				<hr>
				<div class="d-grid gap-2">
					<a href="inventory.php" class="btn btn-outline-info p-3 rounded-pill fs-5" type="button"><i class="bi bi-box-seam"></i> 棚卸システム</a>
				</div>
			</div>
		</div>
	</div>

	<?php include('template/footer.php'); ?>



</body>
</html>
