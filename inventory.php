<?php

require_once('config/config.php');

$app = new \MyApp\Inventory();

$title = '棚卸システム';


?>
<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="page-header mb-2">
			<h1>棚卸しシステム</h1>
		</div>

		<div class="row justify-content-center">
			<div class="col-auto">
				<h2>棚卸の流れ</h2>
				<div class="d-grid gap-4">
					<a href="inventory_table.php" class="btn btn-outline-success btn-lg px-5 rounded-pill">在庫ありリスト</a>
					<a href="inventory_table_input.php" class="btn btn-outline-success btn-lg px-5 rounded-pill">入力フォーム</a>
					<a href="inventory_table_final.php" class="btn btn-outline-success btn-lg px-5 rounded-pill">棚卸済みリスト</a>
				</div>
			</div>
			<div class="col-auto">
				<h2>棚卸確定</h2>
				<button class="btn btn-success btn-lg px-5 rounded-pill">確定する</button>
			</div>
		</div>

	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>
<script>
$(function(){

});
</script>

</body>
</html>
