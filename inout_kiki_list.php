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

$title = '【出入庫】高度、特定保守医療機器一覧';

?>
<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">

		<div class="page-header">
		  <h1>【出入庫】高度、特定保守医療機器一覧</h1>
			<div class="text-end">
				<div class="btn-group" role="group">
					<a href="inout_kiki_list.php" class="btn btn-secondary">出入庫</a>
					<a href="warehousing_kiki_list.php" class="btn btn-outline-secondary">入庫</a>
					<a href="sale_kiki_list.php" class="btn btn-outline-secondary">出庫</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover table-sm">
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
							<td class="text-end"><?= h(number_format($data['actual_price'], 0)); ?>円</td>
							<td class="text-end">
								<?= h(number_format($data['nums']*$data['actual_price'], 0)); ?>円
							</td>
						</tr>
					<?php endforeach; ?>
					<tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
