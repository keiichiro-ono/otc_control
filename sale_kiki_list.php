<?php

require_once('config/config.php');

$app = new \MyApp\Sale_kiki_list();

$data = $app->getAllData();
// var_dump($data);exit;
$title = '【出庫】高度、特定保守医療機器一覧';

?>
<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>
	<div class="container mt-3">

		<div class="page-header">
		  <h1>【出庫】高度、特定保守医療機器一覧</h1>
			<div class="text-end">
				<div class="btn-group" role="group">
					<a href="inout_kiki_list.php" class="btn btn-outline-secondary">出入庫</a>
					<a href="warehousing_kiki_list.php" class="btn btn-outline-secondary">入庫</a>
					<a href="sale_kiki_list.php" class="btn btn-secondary">出庫</a>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover table-sm">
					<thead>
						<tr>
							<th>ID</th>
							<th>分類</th>
							<th>出庫日</th>
							<th>名前</th>
							<th>売値</th>
							<th>個数</th>
							<th colspan="3" class="text-center">購入者情報</th>
						</tr>
					</thead>
					<tbody id="tb">
					<?php foreach($data as $d): ?>
						<tr>
							<td><?= h($d->mainId); ?></td>
							<td>
								<?= h($d->class=='3' ? '高度' :''); ?>
								<?= h($d->tokutei_kiki=='1' ? '㊕' :''); ?>
							</td>
							<td><?= h($d->date); ?></td>
							<td><?= h($d->name); ?></td>
							<td class="text-end"><?= h(number_format($d->actual_price, 0)); ?></td>
							<td class="text-end"><?= h($d->nums); ?></td>
							<td id="sd_name_<?= h($d->mainId); ?>" data-id="<?= h($d->mainId); ?>" data-item="name">
								<?php if($d->user_name==""): ?>
									<button type="button" class="btn btn-primary btn-sm">購入者氏名登録</button>
								<?php else: ?>
									<?= h($d->user_name); ?>
								<?php endif; ?>
							</td>
							<td id="sd_address_<?= h($d->mainId); ?>" data-id="<?= h($d->mainId); ?>" data-item="address">
								<?php if($d->user_address==""): ?>
									<button type="button" class="btn btn-success btn-sm">購入者住所登録</button>
								<?php else: ?>
									<?= h($d->user_address); ?>
								<?php endif; ?>
							</td>
							<td id="sd_notes_<?= h($d->mainId); ?>" data-id="<?= h($d->mainId); ?>" data-item="notes">
								<?php if($d->notes==""): ?>
									<button type="button" class="btn btn-warning btn-sm">備考登録</button>
								<?php else: ?>
									<?= h($d->notes); ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					<tbody>
			</div>
		</div>
	</div>
  <!-- container -->
  <!-- <?php include('template/footer.php'); ?> -->

<script>
$(function(){
	var isActive = false;
	$('td>button').click(function(){
		if(isActive) return false;
		isActive = true;
		var id = $(this).parent('td').data('id');
		var item = $(this).parent('td').data('item');
		var e = '<input type="text"><input type="button" class="regist" value="登録">';
		$(this).parent().empty().append(e);
	});

	$('#tb').on('click', 'input.regist', function(){
		var id = $(this).parent('td').data('id');
		var item = $(this).parent('td').data('item');
		var text = $(this).parent('td').children('input:eq(0)').val();
		if(text==""){
			alert('入力されていません！');
			return false;
		} else {
			$.post('_ajax.php', {
				url: 'sale_kiki_list',
				id: id,
				item: item,
				text: text
			}, function(res){
				$("#sd_"+item+"_"+res.id).empty().text(res.text);
			});
			isActive = false;
		}
	});

});
</script>

</body>
</html>
