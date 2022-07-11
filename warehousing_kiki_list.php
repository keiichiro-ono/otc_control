<?php

require_once('config/config.php');

$app = new \MyApp\Warehousing_kiki_list();

$data = $app->getAllData();
// var_dump($data);exit;

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>【入庫】高度、特定保守医療機器一覧</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style>
	img{
		width: 40px;
		height: auto;
	}
	.date{
		color: blue;
		cursor: pointer;
	}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">

		<div class="page-header">
		  <h1>【入庫】高度、特定保守医療機器一覧</h1>
			<div class="text-right">
				<a href="sale_kiki_list.php" class="btn btn-default">出庫</a>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>入庫日</th>
							<th>名前</th>
							<th>仕入値</th>
							<th>個数</th>
							<th>期限</th>
							<th>ロット番号</th>
						</tr>
					</thead>
					<tbody id="tb">
					<?php foreach($data as $d): ?>
						<tr>
							<td><?= h($d->mainId); ?></td>
							<td><?= h($d->date); ?></td>
							<td><?= h($d->name); ?></td>
							<td><?= h($d->purchase_price); ?></td>
							<td><?= h($d->enter_nums); ?></td>
							<td><?= h($d->limit_date); ?></td>
							<td id="wh_<?= h($d->mainId); ?>" data-id="<?= h($d->mainId); ?>">
								<?php if($d->lot_no==""): ?>
									<button type="button" class="btn btn-default">ロット番号登録</button>
								<?php else: ?>
									<?= h($d->lot_no); ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					<tbody>


			</div>

		</div>



	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script>
$(function(){
	$('td>button').click(function(){
		var id = $(this).parent('td').data('id');
		var e = '<input type="text"><input type="button" class="regist" value="登録">';
		$(this).parent().empty().append(e);
	});

	$('#tb').on('click', 'input.regist', function(){
		var id = $(this).parent('td').data('id');
		var text = $(this).parent('td').children('input:eq(0)').val();
		if(text==""){
			alert('入力されていません！');
			return false;
		} else {
			$.post('_ajax_warehousing_kiki_list.php', {
				id: id,
				lot: text
			}, function(res){
				$("#wh_"+res.id).empty().text(res.lot);
			});
		}
	});

});
</script>

</body>
</html>
