<?php

require_once('config/config.php');

$app = new \MyApp\Correct_otc();

if(isset($_GET['id']) || !empty($_GET['id'])){
	$item = $app->item($_GET['id']);
	// var_dump($item);exit;
	$class_name = $app->class_name();
	$wholesale_name = $app->getWholesaleName();
//	 var_dump($wholesale_name);exit;
}

if($_SERVER['REQUEST_METHOD']==="POST"){
	// var_dump($_POST);exit;
	$app->postprocess();
	if(isset($_FILES["imgFile"]) && $_FILES["imgFile"]["size"] !== 0) {
		try{
			$app->save_file($item->mainId);
		}catch(Exception $e){
			echo $e->getMessage();
			exit;
		}
	}
	header( "Location: ". HOME_URL . "otc_list_2.php?extract=10");
	exit;
}

$title = 'OTC修正画面';


?>
<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">

	<form method="post" action="" enctype="multipart/form-data" id="myform" class="g-3 needs-validation" novalidate>

  	<div class="row justify-content-center">
		<h1>OTC修正画面 <i class="bi bi-file-earmark-plus" style="font-size: 3rem; color: cornflowerblue;"></i></h1>


			<div class="col-md-6 col-sm-12">
				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputName" class="col-form-label">OTC名</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputName" class="form-control mb-1"  name="name" placeholder="名前" data-name="<?= h($item->otcName); ?>" value="<?= h($item->otcName); ?>" required>
						<div class="invalid-feedback">OTCの名前を入力してください!</div>
						修正前: <mark><?= h($item->otcName); ?></mark>
					</div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputKana" class="col-form-label">かな名</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputKana" class="form-control mb-1"  name="kana" placeholder="かな名" data-kana="<?= h($item->kana); ?>" value="<?= h($item->kana); ?>" required>
						<div class="invalid-feedback">かな名を入力してください!</div>
						修正前: <mark><?= h($item->kana); ?></mark>
					</div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputJan" class="col-form-label">JAN</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputJan" class="form-control mb-1"  name="jan" placeholder="JANコード(半角英数字)" data-jan="<?= h($item->jan); ?>" value="<?= h($item->jan); ?>" required>
						<div class="invalid-feedback">JANコードを入力してください!</div>
						修正前: <mark><?= h($item->jan); ?></mark>
					</div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputNums" class="col-form-label">個数</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputNums" class="form-control mb-1" name="stock_nums" placeholder="個数(半角英数字)" data-nums="<?= h($item->stock_nums); ?>" value="<?= h($item->stock_nums); ?>" required>
						<div class="invalid-feedback">個数を入力してください!</div>
						修正前: <mark><?= h($item->stock_nums); ?></mark>
					</div>
					<div class="col-auto">個 <small>（単位なしで入力）</small></div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputSize" class="col-form-label">規格サイズ</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputSize" class="form-control mb-1" name="size" placeholder="規格サイズ(錠数など)" data-size="<?= h($item->size); ?>" value="<?= h($item->size); ?>" required>
						<div class="invalid-feedback">規格を入力してください!</div>
						修正前: <mark><?= h($item->size); ?></mark>
					</div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputPurchase_price" class="col-form-label">入値</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputPurchase_price" class="form-control mb-1" name="purchase_price" placeholder="入値(税抜き価格)" data-purchase_price="<?= h($item->purchase_price); ?>" value="<?= h($item->purchase_price); ?>" required>
						<div class="invalid-feedback">入値を入力してください!</div>
						修正前: <mark><?= h($item->purchase_price); ?></mark>円
					</div>
					<div class="col-auto">円 <small>（単位なしで入力）</small></div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputSelling_price" class="col-form-label">売価</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputSelling_price" class="form-control mb-1" name="selling_price" placeholder="売価(税抜き価格)" data-selling_price="<?= h($item->selling_price); ?>" value="<?= h($item->selling_price); ?>" required>
						<div class="invalid-feedback">売値を入力してください!</div>
						修正前: <mark><?= h($item->selling_price); ?></mark>円
					</div>
					<div class="col-auto">円 <small>（単位なしで入力）</small></div>
				</div>

			</div>

			<div class="col-md-4 col-sm-12">

				<div class="g-3 mb-3">
					<div class="row align-items-center mb-1">
						<div class="col-auto">
							<label for="inputClass" class="col-form-label">種類</label>
						</div>
						<div class="col-auto">
							<select class="form-control" name="class" id="inputClass" data-class="<?= h($item->class_name); ?>">
								<option disabled selected>ここからお選びください</option>
							<?php foreach($class_name as $c_n): ?>
								<option value="<?= h($c_n->id); ?>" <?= $item->class_name === $c_n->class_name ? "selected" : ""; ?>><?= h($c_n->class_name); ?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>
					修正前: <mark><?= h($item->class_name); ?></mark>
				</div>

				<div class="g-3 mb-3">
					<div class="row align-items-center mb-1">
						<div class="col-auto">
							<label for="inputWholesale" class="col-form-label">取引卸</label>
						</div>
						<div class="col-auto">
							<select class="form-control" name="wholesale" id="inputWholesale">
								<option disabled selected>ここからお選びください</option>
							<?php foreach($wholesale_name as $w_name): ?>
								<option value="<?= h($w_name->id); ?>" <?= $item->wholesale === $w_name->id ? "selected" : ""; ?>><?= h($w_name->name); ?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>
					修正前: <mark><?= h($item->wholesaleName); ?></mark>
				</div>
			
				<div class="mb-2">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexSelfMed" name="self_med" <?= ($item->self_med==="1") ? "checked" : ""; ?>>
						<label class="form-check-label" for="flexSelfMed">セルフメディケーション対象医薬品</label>
					</div>
					(修正前: <?= $app->check_self_med($item->self_med); ?>)
				</div>

				<div class="mb-2">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexHygine" name="hygiene" <?= ($item->hygiene==="1") ? "checked" : ""; ?>>
						<label class="form-check-label" for="flexHygine">衛生用品</label>
					</div>
					(修正前: <?= $app->check_hygiene($item->hygiene); ?>)
				</div>

				<div class="mb-2">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexTax" name="tax" <?= ($item->tax==="8") ? "checked" : ""; ?>>
						<label class="form-check-label" for="flexTax">軽減税率対象（8％）</label>
					</div>
					(修正前: <?= $app->check_tax($item->tax); ?>)
				</div>

				<div class="mb-2">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexKiki" name="tokutei_kiki" <?= ($item->tokutei_kiki==="1") ? "checked" : ""; ?>>
						<label class="form-check-label" for="flexKiki">特定管理医療機器</label>
					</div>
					(修正前: <?= $app->check_tokutei_kiki($item->tokutei_kiki); ?>)
				</div>

				<p class="text-end">
					<button type="button" id="otc_edit" class="btn btn-outline-warning rounded-pill px-4">修正</button>
				</p>


			</div>

		</form>

	</row>
    <!-- row -->

	</div>
  <!-- container -->
<script>
$(function(){
	'use strict'

	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.querySelectorAll('.needs-validation')

	// Loop over them and prevent submission
	Array.prototype.slice.call(forms)
		.forEach(function (form) {
			form.addEventListener('submit', function (event) {
			if (!form.checkValidity()) {
				event.preventDefault()
				event.stopPropagation()
			}

			form.classList.add('was-validated')
			}, false)
		})


	$('.form-control').keypress(function(e){
		var tar = $('.form-control').index(this)+1;
		if(tar===8) tar=0;
		if(e.which==13){
			$('.form-control:eq('+tar+')').focus();
			return false;
		}
	});

	$('#otc_edit').click(function(){
		let name = $('#inputName').val();
		let old_name = $('#inputName').data('name');
		let kana = $('#inputKana').val();
		let old_kana = $('#inputKana').data('kana');
		let jan = $('#inputJan').val();
		let old_jan = $('#inputJan').data('jan');
		let nums = $('#inputNums').val();
		let old_nums = $('#inputNums').data('nums');
		let size = $('#inputSize').val();
		let old_size = $('#inputSize').data('size');
		let in_price = $('#inputPurchase_price').val();
		let old_in_price = $('#inputPurchase_price').data('purchase_price');
		let sell_price = $('#inputSelling_price').val();
		let old_sell_price = $('#inputSelling_price').data('selling_price');

		let input_class = $('#inputClass option:selected').text();
		let old_input_class = $('#inputClass').data('class');

		if(
			name==old_name &&
			kana==old_kana &&
			jan==old_jan &&
			nums==old_nums &&
			size==old_size &&
			in_price==old_in_price &&
			sell_price==old_sell_price 


		){
			alert('name同じ');
			return false;
		}
		return false;

		if(
			name=="" ||
			kana=="" ||
			jan=="" ||
			nums=="" ||
			size=="" ||
			in_price=="" ||
			sell_price=="" 
		){
			alert('空欄があります。');
			return false;
		}

		let otc_class = $('#inputClass').val();
		let wholesale = $('#inputWholesale').val();
		if(!otc_class){
			alert('OTCの種類が選択されていません');
			$('#inputClass').focus();
			return false;
		}
		if(!wholesale){
			alert('卸が選択されていません');
			$('#inputWholesale').focus();
			return false;
		}

		$('#myform').submit();
	});



});
</script>

</body>
</html>
