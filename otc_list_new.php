<?php

require_once('config/config.php');

$app = new \MyApp\Otc_list_new();
$items = $app->allItem();

$title = '新入荷OTC一覧表示';

?>
	<style media="screen">
		td {
		  vertical-align: middle!important;
		}
		.red{
			background-color: #ffe0ff;
			font-size: 1.8em;
		}
		.yellow{
			background-color: #ffffe0;
			font-size: 1.3em;
		}
	</style>
<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>


	<div class="container mt-3">
		<div class="page-header">
			<h1>新入荷OTC一覧表示 <i class="bi bi-stars" style="font-size: 3rem; color: cornflowerblue;"></i></h1>
			<p>赤：１５日以内に登録<br>黄：３０日以内に登録</p>
		</div>

		<div class="row">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center">登録日</th>
						<th class="text-center">名前</th>
						<th class="text-center">取引卸</th>
						<th class="text-center">分類</th>
						<th class="text-center">規格</th>
						<th class="text-center">税込み価格</th>
						<th class="text-center">在庫数</th>
					</tr>
				</thead>
				<tbody id="tb">
				<?php foreach($items as $item):
					$created = new DateTime($item->otc_created);
					$today = new DateTime();
					$diff = $created->diff($today)->days;
					if($diff <= 15){
						$diff_class = 'red';
					} elseif($diff <= 30){
						$diff_class = 'yellow';
					} else {
						$diff_class = '';
					}
				?>
					<tr data-id="<?= h($item->mainId); ?>" class="<?= h($diff_class)?>">
						<td class="text-center">
							<?= h(date('m月d日', strtotime($item->otc_created))); ?>
						</td>
						<td>
							<?= h($app->check_self_med($item->self_med)); ?>
							<a href="inout.php?id=<?= h($item->mainId); ?>"><?= h($item->otcName); ?></a>
						</td>
						<td><?= h($item->wholesaleName); ?></td>
						<td><?= h($item->class_name); ?></td>
						<td><?= h($item->size); ?></td>
						<td class="text-right">
							<?php
								if(
									$item->tax==10 &&
									(strtotime("1 October 2019") > time())
									)
							:?>
								<?= h(number_format($item->selling_price*1.08, 0)); ?>円
							<?php else: ?>
								<?= h(number_format($item->tax_include_price, 0)); ?>円
							<?php endif; ?>
						</td>
						<td class="text-right">
							<?= h($item->stock_nums); ?>個
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>

			</table>
		</div>
		<!-- row -->
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>

<script>
$(function(){

});
</script>

</body>
</html>
