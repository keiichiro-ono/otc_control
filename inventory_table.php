<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_table();

$items = $app->getAll();
// var_dump($items);exit;

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>棚卸し表</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style media="screen">
		img{
			width: 150px;
			height: auto;
		}
		tbody{
			font-size: 10px;
		}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>棚卸し表</h1>
		</div>

		<div class="row">
			<p class="bg-primary text-center">棚卸しリスト</p>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th class="text-center">名前</th>
						<th class="text-center">問屋</th>
						<th class="text-center">規格</th>
						<th class="text-center">分類</th>
						<th class="text-center">入値</th>
						<th class="text-center">販売価格</th>
						<th class="text-center">税込価格</th>
						<th class="text-center">在庫数</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($items as $item): ?>
					<tr>
						<td><?= h($item->otcName); ?></td>
						<td class="text-center"><?= h($item->wholesaleName); ?></td>
						<td class="text-center"><?= h($item->size); ?></td>
						<td class="text-center"><?= h($item->class_name); ?></td>
						<td class="text-right"><?= h(number_format($item->purchase_price,1)); ?>円</td>
						<td class="text-right"><?= h(number_format($item->selling_price, 0)); ?>円</td>
						<td class="text-right"><?= h(number_format($item->tax_include_price, 0)); ?>円</td>
						<td></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script>
$(function(){



});
</script>

</body>
</html>
