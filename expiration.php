<?php

require_once('config/config.php');

$app = new \MyApp\Expiration();

if(isset($_GET['class']) && !empty($_GET['class'])){
	$class = $_GET['class'];
	$med = [1, 2, 3, 4];

	$currentTimestamp = time();
	$start_day = date("Y-m-d", strtotime("-1 month", $currentTimestamp));
	if(in_array($class, $med)){
		$end_day = date("Y-m-d", strtotime("+1 year", $currentTimestamp));
	} else {
		$end_day = date("Y-m-d", strtotime("+6 month", $currentTimestamp));
	}

	$items = $app->monthItems($start_day, $end_day, $class);
}

$classList = $app->getClass();

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
		</div>

		<div class="row justify-content-center">
			<div class="col-sm-6 col-md-4">
				<select name="class_name" id="class_name" class="form-select">
					<option value="" selected></option>
					<?php foreach($classList as $row): ?>
					<option value="<?= $row->id; ?>"><?= h($row->class_name); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<hr>

		<?php if(isset($_GET['class']) && !empty($_GET['class'])): ?>

		<h4><?= h($classList[$_GET['class']-1]->class_name); ?></h4>

		<p><?= h(ymd_wareki($start_day)); ?> ~ <?= h(ymd_wareki($end_day)); ?></p>

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
						<td class="text-end"><?= h($item->mainId); ?></td>
						<td><?= h(ymd_wareki($item->limit_date)); ?></td>
						<td><?= h($item->wholesaleName); ?></td>
						<td>
							<a href="inout.php?id=<?= h($item->otc_id); ?>">
								<?= h($item->otcName); ?>
							</a>
						</td>
						<td><?= h($item->size); ?></td>
						<td class="text-end"><?= h(number_format($item->actual_price, 0)); ?>円</td>
						<td class="text-end"><?= h($item->enter_nums); ?>個</td>
						<td><?= h(ymd_wareki($item->date)); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>

			</table>
		</div>
		<!-- row -->

		<?php endif; ?>
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>

<script>
$(function(){
	$('select#class_name').change(function(){
		let cls = $('[name=class_name]').val();
		window.location.href = '?class='+cls;
	});
});
</script>

</body>
</html>
