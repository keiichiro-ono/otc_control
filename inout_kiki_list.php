<?php

require_once('config/config.php');

$app = new \MyApp\Inout_kiki_list();

$warehousing = $app->getWarehousingData();
	for($i=0; $i<count($warehousing); $i++){
		array_push($warehousing[$i], 'warehousing');
	}
$saledata = $app->getSaleData();
	for($i=0; $i<count($saledata); $i++){
		array_push($saledata[$i], 'saledata');
	}

if($warehousing || $saledata){
	$total = array_merge($warehousing , $saledata);
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
	<title>【出入庫】高度、特定保守医療機器一覧</title>
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
		  <h1>【出入庫】高度、特定保守医療機器一覧</h1>
			<div class="text-right">
				<a href="warehousing_kiki_list.php" class="btn btn-default">入庫</a>
				<a href="sale_kiki_list.php" class="btn btn-default">出庫</a>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<table class="table">
					<thead>
						<tr>
							<th>年月日</th>
							<th>医薬品名</th>
							<th>入庫数</th>
							<th>出庫数</th>
							<th>単価</th>
							<th>小計</th>
						</tr>
					</thead>
					<tbody id="tb">
					<?php foreach($total as $data): ?>
						<tr>
							<td><?= h($data['date']); ?></td>
							<td><?= h($data['name']); ?></td>
							<td>
								<?= $data[0]=='warehousing' ? h($data['nums']).'個' : ''; ?>
							</td>
							<td>
								<?= $data[0]=='saledata' ? h($data['nums']).'個' : ''; ?>
							</td>
							<td><?= h(number_format($data['actual_price'], 0)); ?>円</td>
							<td>
								<?= h(number_format($data['nums']*$data['actual_price'], 0)); ?>円
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
