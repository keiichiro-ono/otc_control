<?php

require_once('config/config.php');

$app = new \MyApp\Expiration();
if(isset($_GET['sort']) && !empty($_GET['sort'])){

} else {

}

$items = $app->allItem();
// var_dump($items[0]);

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>使用期限一覧表示</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<style media="screen">
		td {
		  vertical-align: middle!important;
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
			<h1>使用期限一覧</h1>

			<div class="btn-group" role="group" id="mokuji">
				<button type="button" class="btn btn-primary" id="all">全表示</button>
				<button type="button" class="btn btn-primary" id="expiration">期限内</button>
			</div>

			<button type="button" class="btn btn-default" id="thisYear">今年</button>
		</div>

		<div class="row">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td>id</td>
						<td>使用期限</td>
						<td>購入先</td>
						<td>名前</td>
						<td>規格</td>
						<td>単価</td>
						<td>入庫数</td>
						<td>登録日</td>
					</tr>
				</thead>
				<tbody id="tb">
				<?php foreach($items as $item): ?>
					<tr class="<?= ($item->limit_date<date('Y-m-d')) ? 'gray': ''; ?>">
						<td class="text-right"><?= h($item->mainId); ?></td>
						<td><?= h($item->limit_date); ?></td>
						<td><?= h($item->wholesaleName); ?></td>
						<td>
							<a href="inout.php?id=<?= h($item->otc_id); ?>">
								<?= h($item->otcName); ?>
							</a>
						</td>
						<td><?= h($item->size); ?></td>
						<td class="text-right"><?= h($item->actual_price); ?>円</td>
						<td class="text-right"><?= h($item->enter_nums); ?>個</td>
						<td><?= h($item->date); ?></td>
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
	$('#expiration').addClass('active');

	function init(){
		$('button').each(function(){
			$(this).removeClass('active');
		});
		$('#tb>tr').each(function(){
			$(this).show();
		});
	}

	$('#tb>tr').each(function(){
		if( $(this).hasClass('gray') ){
			$(this).hide();
		}
	});

	$('#all').click(function(){
		init();
		$(this).addClass('active');
		$('#expiration').removeClass('active')
		$('.gray').show('200');
	});

	$('#expiration').click(function(){
		init();
		$(this).addClass('active');
		$('#all').removeClass('active')
		$('.gray').hide('200');
	});

	$('#thisYear').click(function(){
		init();

		$(this).addClass('active');
		$('#tb>tr').each(function(){
			var text = $(this).children('td:eq(1)').text();
			var year = text.split('-')[0];
			var thisYear = new Date().getFullYear();
			if( year != thisYear ){
				$(this).hide(200);
			}
		});
	});


});
</script>

</body>
</html>
