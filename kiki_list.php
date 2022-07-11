<?php

require_once('config/config.php');

$app = new \MyApp\Kiki_list();
$items = $app->allItem();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>医療機器一覧表示</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<style media="screen">
		img{
			width: 50px;
			height: auto;
		}
		td {
		  vertical-align: middle!important;
		}
		.edit{
			color: blue;
			cursor: pointer;
		}
		.gray{
			background: #eee;
		}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>医療機器一覧画面</h1>

			<div class="btn-group" role="group" id="exist_btn">
				<button type="button" class="btn btn-default" id="all_item">全表示</button>
				<button type="button" class="btn btn-default" id="exist_item">在庫あり</button>
			</div>

		</div>

		<div class="row">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center" data-name="mainId">ID</th>
						<th class="text-center" data-name="kana">名前</th>
						<th class="text-center" data-name="jan">JAN</th>
						<th class="text-center" data-name="wholesale">取引卸</th>
						<th class="text-center" data-name="class">分類</th>
						<th class="text-center">規格</th>
						<th class="text-center" data-name="purchase_price">入値</th>
						<th class="text-center" data-name="selling_price">販売価格</th>
						<th class="text-center" data-name="tax_include_price">税込み価格</th>
						<th class="text-center">消費税</th>
						<th class="text-center" data-name="stock_nums">在庫数</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="tb">
				<?php foreach($items as $item): ?>
					<tr data-id="<?= h($item->mainId); ?>" class="<?= h($item->stock_nums<=0 ? "gray": ""); ?>">
						<td class="text-right"><?= h($item->mainId); ?></td>
						<td>
							<?= h($app->check_self_med($item->self_med)); ?>
							<a href="inout.php?id=<?= h($item->mainId); ?>"><?= h($item->otcName); ?></a>
						</td>
						<td><?= h($item->jan); ?></td>
						<td><?= h($item->wholesaleName); ?></td>
						<td><?= h($item->class_name); ?></td>
						<td><?= h($item->size); ?></td>
						<td class="text-right">
							<?= h(number_format($item->purchase_price, 2)); ?>円
						</td>
						<td class="text-right">
							<?= h(number_format($item->selling_price, 0)); ?>円
						</td>
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
							<?= h($item->tax); ?>％
						</td>
						<td class="text-right">
							<?= h($item->stock_nums); ?>個
						</td>
						<td class="text-center edit">[編集]</td>
					</tr>
				<?php endforeach; ?>
				</tbody>

			</table>
		</div>
		<!-- row -->
	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script>
$(function(){
	$('#exist_item').addClass('active');
	$('tbody#tb>tr').each(function(){
		if( $(this).hasClass('gray') ){
			$(this).hide();
		}
	});

	$('tbody#tb').on('click', '.edit', function(){
		var id = $(this).parent().data('id');
		window.location.href = "correct_otc.php?id=" + id;
	});

	$('#all_item').click(function(){
		$(this).addClass('active');
		$('#exist_item').removeClass('active');
		$('tbody#tb>tr').each(function(){
			if( $(this).hasClass('gray') ){
				$(this).show(400);
			}
		});
	});

	$('#exist_item').click(function(){
		$(this).addClass('active');
		$('#all_item').removeClass('active');
		$('tbody#tb>tr').each(function(){
			if( $(this).hasClass('gray') ){
				$(this).hide(400);
			}
		});
	});

});
</script>

</body>
</html>
