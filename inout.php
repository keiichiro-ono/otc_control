<?php

require_once('config/config.php');

$app = new \MyApp\Inout();

if(isset($_GET['id']) && !empty($_GET['id'])){
	$item = $app->getItem($_GET['id']);
	$wholesale = $app->getWholesale($item->wholesale);
	$out_data = $app->getOutData($_GET['id']);
		for($i=0; $i<count($out_data); $i++){
			array_push($out_data[$i], 'out');
		}
	$in_data = $app->getInData($_GET['id']);
		for($i=0; $i<count($in_data); $i++){
			array_push($in_data[$i], 'in');
		}
	$returned_data = $app->getReturnedData($_GET['id']);
		for($i=0; $i<count($returned_data); $i++){
			array_push($returned_data[$i], 'returned');
		}
	$out_price = $app->getOutPrice();
	$in_price = $app->getInPrice();
	$returned_price = $app->getRetrurnedPrice();
} else {
	echo '不正なアクセスです';
	exit;
}

if($out_price || $in_price){
	$total = array_merge($out_data , $in_data, $returned_data);
	foreach ((array) $total as $key => $value) {
	    $total_sort[$key] = $value['date'];
	}
	array_multisort($total_sort, SORT_DESC, $total);
}

$title = '入庫出庫一覧';

?>
<?php include('template/header.php'); ?>


<body>
	<?php include('template/navber.php'); ?>
	<style media="screen">
		tfoot{
			border-top: 4px double #ccc;
		}
	</style>
</head>

	<div class="container mt-3">
		<div class="page-header">
			<h1>入庫出庫一覧</h1>
		</div>

		<div class="row">
			<div class="col-sm-5">
				<div class="p-5 mb-4 bg-light row justify-content-center">
					<div class="col-auto">
						<h2 class="text-center"><?= h($item->name); ?></h2>
						<p class="text-end">
							<a href="correct_otc.php?id=<?= h($_GET['id']); ?>" class="btn btn-sm btn-success rounded-pill px-3">編集</a>
						</p>
						<table class="table table-hover">
							<tr>
								<th class="text-end">かな名</th>
								<td><?= h($item->kana); ?></td>
							</tr>
							<tr>
								<th class="text-end">JAN</th>
								<td><?= h($item->jan); ?></td>
							</tr>
							<tr>
								<th class="text-end">規格サイズ</th>
								<td><?= h($item->size); ?></td>
							</tr>

							<tr>
								<th class="text-end">個数</th>
								<td class="text-end">
									<?= h($item->stock_nums); ?>コ
								</td>
							</tr>

							<tr>
								<th class="text-end">入値</th>
								<td class="text-end">
									<?= h(number_format($item->purchase_price, 0)); ?>円
								</td>
							</tr>
							<tr>
								<th class="text-end">売値</th>
								<td class="text-end">
									<?= h(number_format($item->selling_price, 0)); ?>円
								</td>
							</tr>
							<tr>
								<th class="text-end">消費税</th>
								<td class="text-end">
									<?= h(number_format($item->tax_include_price-$item->selling_price, 0)); ?>円
								</td>
							</tr>
							<tr>
								<th class="text-end">税込価格</th>
								<td class="text-end">
									<?= h(number_format($item->tax_include_price, 0)); ?>円
								</td>
							</tr>
							<tr>
								<th class="text-end">種類</th>
								<td><?= h($item->class_name); ?></td>
							</tr>
							<tr>
								<th class="text-end">取引卸</th>
								<td><?= h($wholesale); ?></td>
							</tr>
						</table>

						<table class="table table-dark table-bordered">
							<tr>
								<th class="text-end">セルフメディケーション対象医薬品</th>
								<td>
									<?php if($item->self_med==1): ?>
										<i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th class="text-end">衛生用品</th>
								<td>
									<?php if($item->hygiene==1): ?>
										<i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th class="text-end">軽減税率対象（8％）</th>
								<td>
									<?php if($item->tax==8): ?>
										<i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th class="text-end">特定管理医療機器</th>
								<td>
									<?php if($item->tokutei_kiki==1): ?>
										<i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
									<?php endif; ?>
								</td>
							</tr>
						</table>
						<p>作成日：<?= wareki($item->created); ?></p>
						<p>修正日：<?= wareki($item->modified); ?></p>
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<table class="table table-bordered table-sm">
					<thead class="table-dark">
						<th>日時</th>
						<th class="text-center">入庫数</th>
						<th class="text-center">出庫数</th>
						<th class="text-center">返品数</th>
						<th class="text-center">単価</th>
						<th class="text-center">小計</th>
					</thead>
					<tbody id="tb">
					<?php if(isset($total)): ?>
						<?php
						 	$stock_nums = $item->stock_nums;
							foreach($total as $row): ?>
							<tr>
								<td>
									<a href="calendar.php?ym=<?= h(substr($row['date'],0,4).substr($row['date'],5,2)); ?>">
										<?= h($row['date']); ?>
									</a>
								</td>
								<td class="text-center">
									<?php if($stock_nums>0): ?>
										<?php
											if($row[0]=='in'){
												echo h($row['nums']. "個");
												echo '<span class="badge rounded-pill bg-danger">在庫</span>';
												$stock_nums-=$row['nums'];
											} else {
												echo h("");
											}

										?>
									<?php else: ?>
										<?php
											if($row[0]=='in'){
												echo h($row['nums']. "個");
												// $stock_nums-=$row['nums'];
											} else {
												echo h("");
											}
										?>
									<?php 
									
										endif; ?>

								</td>
								<td class="text-center">
									<?= ($row[0]=='out') ? h($row['nums']."個") : ""; ?>
									<?= ($row[0]=='in' and $row['limit_date']!=null) ? "期限" : ""; ?>
								</td>
								<td class="text-center">
									<?= ($row[0]=='returned') ? h($row['nums']."個") : ""; ?>
									<?= ($row[0]=='in' and $row['limit_date']!=null) ? h($row['limit_date']) : ""; ?>
								</td>
								<td class="text-end">
									<?= h(number_format($row['actual_price'], 0)); ?>円
								</td>
								<td class="text-end">
								<?php if($row[0]=='in'): ?>
									<?= h(number_format($row['actual_price']*$row['nums'], 0)); ?>円
								<?php elseif($row[0]=='out'): ?>
									<strong><?= h(number_format($row['actual_price']*$row['nums'], 0)); ?>円</strong>
								<?php else: ?>
									<?= h(number_format($row['actual_price']*$row['nums'], 0)); ?>円
								<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<th class="text-end" colspan="5">入庫合計</th>
								<td class="text-end"><?= h(number_format($in_price, 0)); ?>円</td>
							</tr>
							<tr>
								<th class="text-end" colspan="5">出庫合計</th>
								<td class="text-end">
									<strong><?= h(number_format($out_price, 0)); ?>円</strong>
								</td>
							</tr>
							<tr>
								<th class="text-end" colspan="5">返品合計</th>
								<td class="text-end">
									<strong><?= h(number_format($returned_price, 0)); ?>円</strong>
								</td>
							</tr>
							<tr>
								<th class="text-end" colspan="5">出庫－入庫＋返品</th>
								<td class="text-end">
									<strong><code><?= h(number_format($out_price-$in_price+$returned_price, 0)); ?>円</code></strong>
								</td>
							</tr>
						</tfoot>
					<?php else: ?>
						<tr>
							<th colspan="6">まだ出入庫のデータはありません</th>
						</tr>
					<?php endif; ?>
				</table>
			</div>
		</div>
		<!-- row -->
	</div>
  <!-- container -->
<script>
$(function(){
	// $('table>thead>tr>th').click(function(){
	// 	var data = $(this).data('name');
	// 	alert(data);
	// });

	// $('tbody#tb').on('click', '.edit', function(){
	// 	var id = $(this).parent().data('id');
	// 	window.location.href = "correct_otc.php?id=" + id;
	// });

});
</script>

</body>
</html>
