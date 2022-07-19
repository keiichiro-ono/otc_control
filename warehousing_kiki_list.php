<?php

require_once('config/config.php');

$app = new \MyApp\Warehousing_kiki_list();

$data = $app->getAllData();
// var_dump($data);exit;

$title = '【入庫】高度、特定保守医療機器一覧';


?>
<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>
	<div class="container mt-3">
		<div class="page-header">
		  <h1>【入庫】高度、特定保守医療機器一覧</h1>
			<div class="text-end">
				<div class="btn-group" role="group">
					<a href="inout_kiki_list.php" class="btn btn-outline-secondary">出入庫</a>
					<a href="warehousing_kiki_list.php" class="btn btn-secondary">入庫</a>
					<a href="sale_kiki_list.php" class="btn btn-outline-secondary">出庫</a>
				</div>

			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover table-sm">
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
									<button type="button" class="btn btn-warning">ロット番号登録</button>
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
  <!-- <?php include('template/footer.php'); ?> -->

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
			$.post('_ajax.php', {
				url: 'warehousing_kiki_list',
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
