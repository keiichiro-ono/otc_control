<?php

require_once('config/config.php');

$app = new \MyApp\Inout();

if(isset($_GET['id']) && !empty($_GET['id'])){
	$item = $app->getItem($_GET['id']);
	$wholesale = $app->getWholesale($item->wholesale);
	$out_data = $app->getOutData($_GET['id']);
		for($i=0; $i<count($out_data); $i++){
			array_push($out_data[$i], 'out');
		}
	$in_data = $app->getInData($_GET['id']);
		for($i=0; $i<count($in_data); $i++){
			array_push($in_data[$i], 'in');
		}
	$returned_data = $app->getReturnedData($_GET['id']);
		for($i=0; $i<count($returned_data); $i++){
			array_push($returned_data[$i], 'returned');
		}
	$out_price = $app->getOutPrice();
	$in_price = $app->getInPrice();
	$returned_price = $app->getRetrurnedPrice();
}

if($out_price || $in_price){
	$total = array_merge($out_data , $in_data, $returned_data);
	foreach ((array) $total as $key => $value) {
	    $total_sort[$key] = $value['date'];
	}
	array_multisort($total_sort, SORT_DESC, $total);
}

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>入庫出庫一覧</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<style media="screen">
		img{
			width: 50px;
			height: auto;
		}
		tfoot{
			border-top: 4px double #ccc;
		}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>入庫出庫一覧</h1>
		</div>

		<div class="row">
			<div class="col-sm-5">
				<div class="well row">
					<div class="col-xs-3">
					<?php if(!empty($item->img)): ?>
						<img src="img/<?= h($item->img); ?>" class="img-circle" style="width:100px; height:auto;">
					<?php else: ?>
						<span class="fa-stack fa-5x">
							<i class="fa fa-camera fa-stack-1x"></i>
							<i class="fa fa-ban fa-stack-2x text-danger"></i>
						</span>
					<?php endif; ?>
					</div>

					<div class="col-xs-9 row">
						<h2 class="text-center"><?= h($item->name); ?></h2>
						<div class="col-xs-6">
							<p class="text-right">入値 <?= h(number_format($item->purchase_price, 0)); ?>円</p>
							<p class="text-right">売価 <?= h(number_format($item->selling_price, 0)); ?>円</p>
							<p class="text-right">消費税 <?= h(number_format($item->tax_include_price-$item->selling_price, 0)); ?>円</p>
						</div>
						<div class="col-xs-6">
							<h4 class="text-right">税込み <strong><?= h(number_format($item->tax_include_price, 0)); ?>円</strong></h4>
						</div>
					</div>

					<div class="col-xs-12">
						<p>在庫数：<?= h($item->stock_nums); ?>個</p>
						<p>取引問屋：<?= h($wholesale); ?></p>
						<p class="text-right"><a href="correct_otc.php?id=<?= h($_GET['id']); ?>">[編集]</a></p>
					</div>


				</div>
			</div>
			<div class="col-sm-7">
				<table class="table table-bordered table-condensed">
					<thead>
						<th>日時</th>
						<th class="text-center">入庫数</th>
						<th class="text-center">出庫数</th>
						<th class="text-center">返品数</th>
						<th class="text-center">単価</th>
						<th class="text-center">小計</th>
					</thead>
					<tbody id="tb">
					<?php if(isset($total)): ?>
						<?php
						 	$stock_nums = $item->stock_nums;
							foreach($total as $row): ?>
							<tr>
								<td>
									<a href="calendar.php?ym=<?= h(substr($row['date'],0,4).substr($row['date'],5,2)); ?>">
										<?= h($row['date']); ?>
									</a>
								</td>
								<td class="text-center">
									<?php if($stock_nums>0): ?>
										<?php
											if($row[0]=='in'){
												echo h($row['nums']. "個");
												echo '<span class="badge">在庫</span>';
												$stock_nums-=$row['nums'];
											} else {
												echo h("");
											}

										?>
									<?php else: ?>
										<?php
											if($row[0]=='in'){
												echo h($row['nums']. "個");
												// $stock_nums-=$row['nums'];
											} else {
												echo h("");
											}
										?>
									<?php 
									
										endif; ?>

								</td>
								<td class="text-center">
									<?= ($row[0]=='out') ? h($row['nums']."個") : ""; ?>
									<?= ($row[0]=='in' and $row['limit_date']!=null) ? "期限" : ""; ?>
								</td>
								<td class="text-center">
									<?= ($row[0]=='returned') ? h($row['nums']."個") : ""; ?>
									<?= ($row[0]=='in' and $row['limit_date']!=null) ? h($row['limit_date']) : ""; ?>
								</td>
								<td class="text-right">
									<?= h(number_format($row['actual_price'], 0)); ?>円
								</td>
								<td class="text-right">
								<?php if($row[0]=='in'): ?>
									<?= h(number_format($row['actual_price']*$row['nums'], 0)); ?>円
								<?php elseif($row[0]=='out'): ?>
									<strong><?= h(number_format($row['actual_price']*$row['nums'], 0)); ?>円</strong>
								<?php else: ?>
									<?= h(number_format($row['actual_price']*$row['nums'], 0)); ?>円
								<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<th class="text-right" colspan="5">入庫合計</th>
								<td class="text-right"><?= h(number_format($in_price, 0)); ?>円</td>
							</tr>
							<tr>
								<th class="text-right" colspan="5">出庫合計</th>
								<td class="text-right">
									<strong><?= h(number_format($out_price, 0)); ?>円</strong>
								</td>
							</tr>
							<tr>
								<th class="text-right" colspan="5">返品合計</th>
								<td class="text-right">
									<strong><?= h(number_format($returned_price, 0)); ?>円</strong>
								</td>
							</tr>
							<tr>
								<th class="text-right" colspan="5">出庫－入庫＋返品</th>
								<td class="text-right">
									<strong><code><?= h(number_format($out_price-$in_price+$returned_price, 0)); ?>円</code></strong>
								</td>
							</tr>
						</tfoot>
					<?php else: ?>
						<tr>
							<th colspan="6">まだ出入庫のデータはありません</th>
						</tr>
					<?php endif; ?>
				</table>
			</div>
		</div>
		<!-- row -->
	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script>
$(function(){
	$('table>thead>tr>th').click(function(){
		var data = $(this).data('name');
		alert(data);
	});

	$('tbody#tb').on('click', '.edit', function(){
		var id = $(this).parent().data('id');
		window.location.href = "correct_otc.php?id=" + id;
	});

});
</script>

</body>
</html>
