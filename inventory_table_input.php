<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_table_input();

$items = $app->getAll();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>棚卸し表</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style media="screen">
		img{
			width: 150px;
			height: auto;
		}
		.input{
			cursor: pointer;
			color: blue;
		}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>棚卸し表 入力</h1>
		</div>

		<div class="row">
			<p class="bg-primary text-center">棚卸しリスト</p>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th class="text-center">名前</th>
						<th class="text-center">規格</th>
						<th class="text-center">分類</th>
						<th class="text-center">入値</th>
						<th class="text-center">販売価格</th>
						<th class="text-center">税込価格</th>
						<th class="text-center">在庫数</th>
						<th class="text-center"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($items as $item): ?>
					<tr id="<?= h($item->mainId); ?>">
						<td><?= h($item->name); ?></td>
						<td class="text-center"><?= h($item->size); ?></td>
						<td class="text-center"><?= h($item->class_name); ?></td>
						<td class="text-right"><?= h(number_format($item->purchase_price,1)); ?>円</td>
						<td class="text-right"><?= h(number_format($item->selling_price, 0)); ?>円</td>
						<td class="text-right"><?= h(number_format($item->tax_include_price, 0)); ?>円</td>
						<td class="text-center"><input type="text" size="5" class="nums text-right" value="<?= h($item->stock_nums); ?>">個</td>
						<td class="text-center input">[入力]</td>
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
	$('input:eq(0)').select().focus();

	$('table').on('click', 'td.input', function(){
		var $this = $(this);
		var nums = $this.prev('td').children('input').val();
		var id = $this.parent('tr').attr('id');

		if(nums.search(/^[0-9]+$/) != 0){
			$this.prev('td').children('input').select().focus();
			alert('数字だけだよ！');
			return;
		}

		$.post('_ajax.php', {
			url: 'inventory_table_input',
			id: id,
			nums: nums
		}, function(res){
			$this.parent('tr').next('tr').children('td:eq(6)').children('input.nums').select().focus();
			$this.parent('tr').fadeOut(800);
		});
	});

	$(document).on('keypress', 'td>input.nums',  function(e){
		if(e.which==13){
			$(this).parent('td').next('td.input').click();
		}
	});
});
</script>

</body>
</html>
