<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_table();

$items = $app->getAll();
// var_dump($items);exit;

$title = '棚卸し表';


?>
<?php include('template/header.php'); ?>
	<style media="screen">
		tbody{
			/* font-size: 10px; */
		}
	</style>
<body>
	<?php include('template/navber.php'); ?>

	<?php include('template/tab_inventory.php'); ?>

	<div class="container mt-3">
		<div class="page-header">
			<h1><i class="bi bi-list-check"></i> 棚卸し表</h1>
		</div>

		<div class="row">
			<p class="bg-primary text-center text-white">棚卸しリスト</p>
			<table class="table table-sm">
				<thead>
					<tr>
						<th class="text-center">名前</th>
						<th class="text-center">問屋</th>
						<th class="text-center">規格</th>
						<th class="text-center">分類</th>
						<th class="text-center">入値</th>
						<th class="text-center">販売価格</th>
						<th class="text-center">税込価格</th>
						<th class="text-center">理論在庫数</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($items as $item): ?>
					<tr>
						<td><?= h($item->otcName); ?></td>
						<td class="text-center"><?= h($item->wholesaleName); ?></td>
						<td class="text-center"><?= h($item->size); ?></td>
						<td class="text-center"><?= h($item->class_name); ?></td>
						<td class="text-end"><?= h(number_format($item->purchase_price,1)); ?>円</td>
						<td class="text-end"><?= h(number_format($item->selling_price, 0)); ?>円</td>
						<td class="text-end"><?= h(number_format($item->tax_include_price, 0)); ?>円</td>
						<td class="text-end"><?= h($item->stock_nums); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>

<script>
$(function(){
	let url = location.pathname.split('/').slice(-1)[0];

	$("#tab_nav").children('li').children('a').each(function(){
		let href = $(this).attr('href');
		if(url==href){
			$(this).addClass('active');
		}
	});


});
</script>

</body>
</html>
