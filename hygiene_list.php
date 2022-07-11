<?php

require_once('config/config.php');

$app = new \MyApp\Hygiene_list();

$items = $app->allItem();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>衛生用品一覧</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<style>
	img{
		width: 50px;
		height: auto;
	}

	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>衛生用品一覧画面</h1>
		</div>

			<table class="table">
				<thead>
					<tr>
						<th>写真</th>
						<th>名前</th>
						<th>サイズ</th>
						<th class="text-right">入値</th>
						<th class="text-right">売値</th>
						<th class="text-right">税込み価格</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($items as $item): ?>
					<tr>
						<td>
							<?php if(!empty($item->img)): ?>
								<img src="img/<?= h($item->img); ?>" alt="">
							<?php else: ?>
								<span class="fa-stack fa-2x">
									<i class="fa fa-camera fa-stack-1x"></i>
									<i class="fa fa-ban fa-stack-2x text-danger"></i>
								</span>
							<?php endif; ?>
						</td>
						<td><?= h($item->name); ?></td>
						<td><?= h($item->size); ?></td>
						<td class="text-right"><?= h(number_format($item->purchase_price,0)); ?>円</td>
						<td class="text-right"><?= h(number_format($item->selling_price, 0)); ?>円</td>
						<td class="text-right"><?= h(number_format($item->tax_include_price, 0)); ?>円</td>
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
