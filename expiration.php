<?php

require_once('config/config.php');

$app = new \MyApp\Expiration();

$items = $app->allItem();
// var_dump($items[0]);
$title = '使用期限一覧表示';


?>
<?php include('template/header.php'); ?>


<body>
	<?php include('template/navber.php'); ?>
	<style media="screen">
		td {
		  vertical-align: middle!important;
		}
		.gray{
			background: #eee;
		}
	</style>
	<div class="container mt-3">
		<div class="page-header mb-3">
			<h1>使用期限一覧 <i class="bi bi-hourglass" style="font-size: 3rem; color: cornflowerblue;"></i></h1>

			<div class="btn-group" role="group" id="mokuji">
				<button type="button" class="btn btn-primary" id="all">全表示</button>
				<button type="button" class="btn btn-primary" id="expiration">期限内</button>
			</div>

			<button type="button" class="btn btn-secondary" id="thisYear">今年</button>
		</div>

		<div class="row">
			<table class="table table-bordered table-sm">
				<thead>
					<tr>
						<th>id</th>
						<th>使用期限</th>
						<th>購入先</th>
						<th>名前</th>
						<th>規格</th>
						<th>単価</th>
						<th>入庫数</th>
						<th>登録日</th>
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
  <?php include('template/footer.php'); ?>

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
