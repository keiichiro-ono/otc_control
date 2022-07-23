<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_old();

$days = $app->get_days();

if(isset($_GET['day']) && !empty($_GET['day'])){
	$items = $app->get_day_items($_GET['day']);
}

$title = '棚卸し表(過去データ)';


?>
<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>

	<?php include('template/tab_inventory.php'); ?>

	<div class="container mt-3">
		<div class="page-header mb-2">
			<h1>棚卸し過去データ</h1>
		</div>

		<?php if(!isset($_GET['day']) || empty($_GET['day'])): ?>
		<div class="mb-3">
			<?php if(count($days)==0): ?>
				<h2>まだ棚卸データがありません。</h2>
			<?php else: ?>
				<?php foreach($days as $day): ?>
					<a href="?day=<?= h($day->date); ?>" class="btn btn-primary btn-sm"><?= h($day->date); ?></a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php else: ?>
			<h2><?= h($_GET['day']); ?>付データ</h2>
			<p class="text-end mb-3">
				<a href="<?= HOME_URL. 'inventory_old.php'; ?>" class="btn btn-outline-info btn-sm">日付を選択する</a>
			</p>

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
						<td><?= h($item->otc_name); ?></td>
						<td class="text-center"><?= h($item->otc_size); ?></td>
						<td class="text-center"><?= h($item->otc_class_name); ?></td>
						<td class="text-end"><?= h(number_format($item->otc_purchase_price,1)); ?>円</td>
						<td class="text-end"><?= h(number_format($item->otc_selling_price, 0)); ?>円</td>
						<td class="text-end"><?= h($item->tax); ?>%</td>
						<td class="text-end"><?= h(number_format($item->otc_tax_include_price, 0)); ?>円</td>
						<td class="text-center"><?= h($item->nums); ?>個</td>
						<td class="text-end">
							<?php
								$subTotal = $item->otc_purchase_price*$item->nums;
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

		<?php endif; ?>

		<div id="save"></div>
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
