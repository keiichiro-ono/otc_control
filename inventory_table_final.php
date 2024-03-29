<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_table_final();

$items = $app->getAll();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$app->save_csv();
} 

$title = '棚卸し表(最終データ)';


?>
<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>

	<?php include('template/tab_inventory.php'); ?>

	<div class="container mt-3">
		<div class="page-header mb-2">
			<h1><i class="bi bi-list-columns-reverse"></i> 棚卸し表（最終データ）</h1>
			<div class="text-end">
				<form action="" method="POST">
					<button class="btn btn-danger btn-sm download"><i class="bi bi-cloud-download"></i> データダウンロード</button>
				</form>
			</div>
		</div>

		<div class="row">
			<p class="bg-primary text-center text-white">棚卸しリスト</p>
			<table class="table table-sm table-hover">
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
						<td class="text-end"><?= h(number_format($item->purchase_price,1)); ?>円</td>
						<td class="text-end"><?= h(number_format($item->selling_price, 0)); ?>円</td>
						<td class="text-end"><?= h($item->tax); ?>%</td>
						<td class="text-end"><?= h(number_format($item->tax_include_price, 0)); ?>円</td>
						<td class="text-center"><?= h($item->stock_nums); ?>個</td>
						<td class="text-end">
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
						<th colspan="8" class="text-end">合計</th>
						<th colspan="2" class="text-end"><?= h(number_format($sum, 0)); ?>円</th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div id="save"></div>
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>
<script>
$(function(){
	$('.download').click(function(){
		if(confirm('データをダウンロードしてもよろしいですか？')){
			$('form').submit();
		}
	});

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
