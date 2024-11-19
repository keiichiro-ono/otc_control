<?php

require_once('config/config.php');

$app = new \MyApp\Check_nums();

$check_nums = $app->check_nums_all();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$data = [];
	
	for($i=0; $i<count($check_nums); $i++){
	
		// $check_nums[$i]['otc_id']=10;
		$inventory_date = $app->check_log_inventory($check_nums[$i]['otc_id']);
	
		$inventory_nums_date = $app->get_inventory_nums_date($check_nums[$i]['otc_id']);
		$log_nums_date = $app->get_log_nums_date($check_nums[$i]['otc_id']);
	
		if(!$inventory_nums_date && !$log_nums_date){
			$inv_log_nums_date = (object)['nums'=>0, 'date'=>'2020-01-01'];
		} else if(empty($inventory_nums_date) || empty($log_nums_date)){
			$inv_log_nums_date = empty($inventory_nums_date) ? $log_nums_date : $inventory_nums_date;
		} else if($inventory_nums_date->date > $log_nums_date->date){
			$inv_log_nums_date = $inventory_nums_date;	
		} else {
			$inv_log_nums_date = $log_nums_date;	
		}
	
		$in_nums = $app->check_id_to_in_nums($check_nums[$i]['otc_id'], $inv_log_nums_date->date);
		$out_nums = $app->check_id_to_out_nums($check_nums[$i]['otc_id'], $inv_log_nums_date->date);
		$return_nums = $app->check_id_to_return_nums($check_nums[$i]['otc_id'], $inv_log_nums_date->date);
		// $change_nums = $app->check_id_to_change_nums($check_nums[$i]['otc_id'], $inv_log_nums_date->date);
		$res = $inv_log_nums_date->nums + $in_nums - $out_nums - $return_nums; 
		$stock_nums = $app->getNums($check_nums[$i]['otc_id']);
	
		// echo '<pre>';
		// var_dump($inv_log_nums_date);
		// var_dump('入庫：'.$in_nums);
		// var_dump('出庫：'.$out_nums);
		// var_dump('返品：'.$return_nums);
		// var_dump('計算：'.$res);
		// var_dump('在庫：'.$stock_nums);
		// echo '</pre>';



		if($res != (int)$stock_nums){
			$otc = $app->getOtcData($check_nums[$i]['otc_id']);
			$otc['calc_nums'] = $res;
			$otc['preparation_date'] = $inv_log_nums_date->date;
			array_push($data, $otc);
		}
	
		if($i==100){
			break;
		}
	
	}
} 


$title = '在庫差異チェック';

?>
<?php include('template/header.php'); ?>
<style>
	.edit_wholesale, .edit_otc_class{
		color: blue;
		cursor: pointer;
	}
	.delete_wholesale, .delete_otc_class{
		color: red;
		cursor: pointer;
	}
</style>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="page-header">
			<h1><i class="bi bi-gear"></i> 在庫差異チェック</h1>
		</div>

		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
				<div class="d-grid gap-3 mt-3">

					<button type="button" class="btn btn-outline-danger btn-lg px-4 rounded-pill" id="check_submit">
						在庫の差異をチェック
					</button>

					<form action="" method="POST" id="check_form"></form>

				</div>
			</div>

			<?php if($_SERVER['REQUEST_METHOD'] == "POST"): ?>
			<table class="table table-hoverd">
				<thead>
					<tr>
						<th>ID</th>
						<th>名前</th>
						<th>規格</th>
						<th class="text-center">値段</th>
						<th class="text-center">現在個数</th>
						<th class="text-center">計算個数</th>
						<th class="text-center">最終調整日</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($data as $row): ?>
					<tr>
						<td><?= h($row['id']); ?></td>
						<td>
							<a href="inout.php?id=<?= h($row['id']); ?>" target="_blank">
								<?= h($row['name']); ?>
							</a>
						</td>
						<td><?= h($row['size']); ?></td>
						<td class="text-end"><?= h(number_format($row['selling_price'], 0)); ?>円</td>
						<td class="text-end <?= $row['stock_nums']<0 ? 'text-danger': ''; ?>">
							<?= h($row['stock_nums']); ?>個
						</td>
						<td class="text-end <?= $row['calc_nums']<0 ? 'text-danger': ''; ?>">
							<?= h($row['calc_nums']); ?>個
						</td>
						<td class="text-center">
							<?php if($row['preparation_date']=="2020-01-01"): ?>
								---
							<?php else: ?>
								<?= h($row['preparation_date']); ?>
							<?php endif; ?>
						</td>
						<td>
							<a href="correct_otc.php?id=<?= h($row['id']); ?> " target="_blank" rel="noopener noreferrer">[編集]</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>




		</div>
	</div>

	<!-- Modal_1 -->
	<div class="modal fade" id="modal_loading" tabindex="-1" aria-labelledby="modal_wholesale_label" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content">
				<div class="text-center">	
					<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</div>
    		</div>
  		</div>
	</div>




  <!-- container -->
  <?php include('template/footer.php'); ?>
<script>
$(function(){

	$('#check_submit').click(function(){
		if(confirm('これには処理に時間がかかりますがよろしいですか？')){
			$("#modal_loading").modal('show');
			$('#check_form').submit();
		}
	});


});
</script>

</body>
</html>
