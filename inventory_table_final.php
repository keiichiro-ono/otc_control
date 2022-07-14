<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_table_final();

$items = $app->getAll();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>棚卸し表(最終データ)</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style media="screen">
		img{
			width: 150px;
			height: auto;
		}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>棚卸し表（最終データ）</h1>
			<button class="btn btn-danger download">データダウンロード</button>
		</div>

		<div class="row">
			<p class="bg-primary text-center">棚卸しリスト</p>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th class="text-center">No.</th>
						<th class="text-center">名前</th>
						<th class="text-center">規格</th>
						<th class="text-center">分類</th>
						<th class="text-center">入値</th>
						<th class="text-center">販売価格</th>
						<th class="text-center">消費税</th>
						<th class="text-center">税込価格</th>
						<th class="text-center">在庫数</th>
						<th class="text-center">小計（入値×在庫数）</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$i=1;
					$sum=0;
					foreach($items as $item):
				?>
					<tr>
						<td class="text-center"><?= h($i); ?></td>
						<td><?= h($item->name); ?></td>
						<td class="text-center"><?= h($item->size); ?></td>
						<td class="text-center"><?= h($item->class_name); ?></td>
						<td class="text-right"><?= h(number_format($item->purchase_price,1)); ?>円</td>
						<td class="text-right"><?= h(number_format($item->selling_price, 0)); ?>円</td>
						<td class="text-right"><?= h($item->tax); ?>%</td>
						<td class="text-right"><?= h(number_format($item->tax_include_price, 0)); ?>円</td>
						<td class="text-center"><?= h($item->stock_nums); ?>個</td>
						<td class="text-right">
							<?php
								$subTotal = $item->purchase_price*$item->stock_nums;
								$sum+=$subTotal;
								echo h(number_format($subTotal), 0);
							?>円
						</td>
					</tr>
				<?php
					$i++;
					endforeach;
				?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="8" class="text-right">合計</th>
						<th class="text-right"><?= h(number_format($sum, 0)); ?>円</th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div id="save"></div>
	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script>
$(function(){
	$('.download').click(function(){
		if(confirm('データをダウンロードしてもよろしいですか？')){
			window.location.href = "_save_inventory.php";
		}
	});


});
</script>

</body>
</html>