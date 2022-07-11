<?php

require_once('config/config.php');

$app = new \MyApp\Otc_list();

$items = $app->allItem();
if(isset($_GET['jan'])){
	$data = $app->item($_GET['jan']);
}

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OTC一覧表示</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">

</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>OTC一覧画面</h1>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<table class="table">
					<thead>
						<tr>
							<th>名前</th>
							<th>在庫</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($items as $item): ?>
						<tr>
							<td><?= h($item->name); ?></td>
							<td class="text-right"><?= h($item->stock_nums); ?>個</td>
							<td><a href="?jan=<?= h($item->jan); ?>">[詳細]</a></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-8">
			<?php if(isset($_GET['jan']) || !empty($_GET['jan'])): ?>
				<div class="well well-lg">
					<div class="row">
						<div class="col-xs-4">
							<?php if(!empty($data->img)): ?>
								<img src="img/<?= h($data->img); ?>" class="img-circle" style="width:150px; height:auto; margin-right:30px;">
							<?php else: ?>
								<span class="fa-stack fa-5x">
								  <i class="fa fa-camera fa-stack-1x"></i>
								  <i class="fa fa-ban fa-stack-2x text-danger"></i>
								</span>
							<?php endif; ?>
						</div>
						<div class="col-xs-6">
							<p><small><?= h($data->class_name); ?></small></p>
							<h2>
								<?= h($data->name); ?>
								<?php if($data->self_med==="1"): ?>
									<i class="fa fa-star fa-spin fa-lg fa-fw text-warning"></i>
								<?php endif; ?>
							</h2>
							<h3>税込価格: <?php
															if(
																$data->tax==10 &&
																(strtotime("1 October 2019") > time())
																)
														:?>
															<?= h(number_format($data->selling_price*1.08,0)); ?>円88</h3>
														<?php else: ?>
															<?= h(number_format($data->tax_include_price)); ?>円10</h3>
														<?php endif; ?>
							<h5>本体価格: <?= h(number_format($data->selling_price)); ?>円</h5>
							<h5>2019年10月から<?= h($data->tax); ?>%</h5>
							<p class="danger">
								<strong><?= h($app->change_self_med($data->self_med));?></strong>
							</p>
						</div>
						<div class="col-xs-2">
							<p class="text-right">
								<a href="correct_otc.php?id=<?= h($data->mainId); ?>">[修正]</a>
							</p>
						</div>
					</div>
				</div>

				<table class="table">
					<tr>
						<th class="text-right">かな</th>
						<td><?= h($data->kana); ?></td>
					</tr>
					<tr>
						<th class="text-right">規格</th>
						<td><?= h($data->size); ?></td>
					</tr>
					<tr>
						<th class="text-right">入値</th>
						<td>
							<?= h(number_format($data->purchase_price, 2)); ?>円
						</td>
					</tr>
					<tr>
						<th class="text-right">在庫数</th>
						<td><?= h($data->stock_nums); ?>個</td>
					</tr>
					<tr>
						<th class="text-right">作成日</th>
						<td><?= h($data->created); ?></td>
					</tr>
					<tr>
						<th class="text-right">更新日</th>
						<td><?= h($data->modified); ?></td>
					</tr>
				</table>
			<?php endif; ?>
			</div>

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
