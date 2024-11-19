<?php

require_once('config/config.php');

$app = new \MyApp\Correct_otc();

if(isset($_GET['id']) || !empty($_GET['id'])){
	$item = $app->item($_GET['id']);
	$class_name = $app->class_name();
	$wholesale_name = $app->getWholesaleName();
}

if($_SERVER['REQUEST_METHOD']==="POST"){
	// echo '<pre>';
	// var_dump($app->category_1());
	// var_dump($_POST); exit;
	$app->postprocess();
	header( "Location: ". HOME_URL . "inout.php?id=". $_GET['id']);
	exit;
}

$title = 'OTC修正画面';


?>
<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">

	<form method="post" action="" enctype="multipart/form-data" id="myform" class="g-3 needs-validation" novalidate>
		<input type="hidden" value="<?= h($_GET['id']); ?>" name="id">

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

				<div class="bg-light p-3">
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

					<div class="mb-3">
						<label for="cat_1" class="form-label">医薬品の場合は下記も選択してください</label>
						<select class="form-select" aria-label="category_1" id="cat_1" <?= isset($item->category_id) ? "": "disabled";?>>
							<?php if(isset($item->category_id)): ?>
								<?php foreach($app->category_1() as $cat_m): ?>
									<?php if( $cat_m->cat_name == $app->cat_id_to_catname($item->category_id)->cat_name) :?>
										<option value="<?= h($cat_m->cat_name); ?>" selected><?= h($cat_m->cat_name); ?></option>
									<?php else: ?>
										<option value="<?= h($cat_m->cat_name); ?>"><?= h($cat_m->cat_name); ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php else: ?>
								<?php foreach($app->category_1() as $cat_m): ?>
									<option value="<?= h($cat_m->cat_name); ?>" selected><?= h($cat_m->cat_name); ?></option>
								<?php endforeach; ?>
								<option selected value="">なし</option>

							<?php endif; ?>
						</select>
					</div>

					<div class="mb-3">
						<select class="form-select" name="category" data-id=<?= h(isset($item->category_id)); ?> aria-label="category_2" id="cat_2" <?= isset($item->category_id) ? "": "disabled";?>>
							<?php if($item->category_id): ?>
								<!-- <option selected value="<?= h($app->cat_id_to_catname($item->category_id)->subcat_name); ?>"><?= h($app->cat_id_to_catname($item->category_id)->subcat_name); ?></option> -->
								<option selected value="<?= h($item->category_id); ?>"><?= h($app->cat_id_to_catname($item->category_id)->subcat_name); ?></option>
							<?php else: ?>
								<option selected value="">なし</option>
							<?php endif; ?>
							
						</select>
					</div>
					<?php if($item->category_id) : ?>
						修正前: <mark><?= h($app->cat_id_to_catname($item->category_id)->subcat_name); ?></mark>
					<?php else: ?>
						修正前：データなし
					<?php endif; ?>
				</div>

				<div class="g-3 mb-3">
					<div class="row align-items-center mb-1">
						<div class="col-auto">
							<label for="inputWholesale" class="col-form-label">取引卸</label>
						</div>
						<div class="col-auto">
							<select class="form-control" name="wholesale" id="inputWholesale" data-wholesale="<?= h($item->wholesale); ?>">
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
						<input class="form-check-input" type="checkbox" id="flexSelfMed" data-self_med="<?= h($item->self_med); ?>" name="self_med" <?= ($item->self_med==="1") ? "checked" : ""; ?>>
						<label class="form-check-label" for="flexSelfMed">セルフメディケーション対象医薬品</label>
					</div>
					(修正前: <?= $app->check_self_med($item->self_med); ?>)
				</div>

				<div class="mb-2">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexHygine" name="hygiene" data-hygine="<?= h($item->hygiene); ?>" <?= ($item->hygiene==="1") ? "checked" : ""; ?>>
						<label class="form-check-label" for="flexHygine">衛生用品</label>
					</div>
					(修正前: <?= $app->check_hygiene($item->hygiene); ?>)
				</div>

				<div class="mb-2">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexTax" name="tax" data-tax="<?= h($item->tax); ?>" <?= ($item->tax==="8") ? "checked" : ""; ?>>
						<label class="form-check-label" for="flexTax">軽減税率対象（8％）</label>
					</div>
					(修正前: <?= $app->check_tax($item->tax); ?>)
				</div>

				<div class="mb-2">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexKiki" name="tokutei_kiki" data-kiki="<?= h($item->tokutei_kiki); ?>" <?= ($item->tokutei_kiki==="1") ? "checked" : ""; ?>>
						<label class="form-check-label" for="flexKiki">特定管理医療機器</label>
					</div>
					(修正前: <?= $app->check_tokutei_kiki($item->tokutei_kiki); ?>)
				</div>

				<p class="text-end">
					<button type="button" id="otc_edit" class="btn btn-outline-warning rounded-pill px-4">修正</button>
				</p>
			</div>
			<input type="hidden" id="inputMemo" name="memo">
		</form>
	</div>
    <!-- row -->
</div>
  <!-- container -->

  <div class="modal fade" id="textModal" tabindex="-1" role="dialog" aria-labelledby="textModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="textModalLabel">個数の変更理由</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<label for="changeNumsMemo">理由</label>
					<textarea class="form-control" id="changeNumsMemo" required></textarea>
					<div class="invalid-feedback">
					在庫の数を変更した理由を記載してください。
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" id="modalRegist" class="btn btn-primary">登録</button>
			</div>
		</div>
	</div>
</div>
<?php include('template/footer.php'); ?>

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

	$('#inputClass').on('change', function(){
		let opt_val = $(this).val();
		let ary = ['1', '2', '3', '4'];
		if( $.inArray(opt_val, ary) == -1){
			$('#cat_1 option[value=""]').prop('selected', true);
			$('#cat_2').empty();
			$('#cat_1').attr('disabled', 'disabled');
			$('#cat_2').attr('disabled', 'disabled');
		} else {
			$('#cat_1').removeAttr('disabled');
			$('#cat_2').removeAttr('disabled');
		}
	});

	$('#cat_1').on('change', function(){
		let text_val = $(this).val();
		$('#cat_2').empty();
		$.post('_ajax.php', {
			"url": "new_otc",
			"mode": "category_change",
			"text_val": text_val
		}, function(res){
			for(let i=0; i<res.length; i++){
				let e = $("<option>").val(res[i]['id']).text(res[i]['subcat_name']);
				$('#cat_2').append(e);
			}
		});
	});


	let ary = ['1', '2', '3', '4', '10'];
	if( $.inArray($('#inputClass').val(), ary) != -1 ){
		$('#cat_1').removeAttr('disabled');
		$('#cat_2').removeAttr('disabled');
	}
	



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
		let wholesale = $('#inputWholesale option:selected').val();
		let old_wholesale = $('#inputWholesale').data('wholesale');
		let flexSelfMed = $('#flexSelfMed').prop("checked") ? 1 : 0;
		let old_flexSelfMed = $('#flexSelfMed').data('self_med');
		let flexHygine = $('#flexHygine').prop("checked") ? 1 : 0;
		let old_flexHygine = $('#flexHygine').data('hygine');
		let flexTax = $('#flexTax').prop("checked") ? 8 : 10;
		let old_flexTax = $('#flexTax').data('tax');
		let flexKiki = $('#flexKiki').prop("checked") ? 1 : 0;
		let old_flexKiki = $('#flexKiki').data('kiki');

		let old_cat_id = $('#cat_2').data('id');
		let cat_id = $('#cat_2').val();

		if(
			name==old_name &&
			kana==old_kana &&
			jan==old_jan &&
			nums==old_nums &&
			size==old_size &&
			in_price==old_in_price &&
			sell_price==old_sell_price &&
			input_class==old_input_class &&
			wholesale==old_wholesale &&
			flexSelfMed==old_flexSelfMed &&
			flexHygine==old_flexHygine &&
			flexTax==old_flexTax &&
			flexKiki==old_flexKiki &&
			cat_id==old_cat_id
		){
			alert('どこも変更されていません！');
			return false;
		}

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
		wholesale = $('#inputWholesale').val();
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
		
		if(nums != old_nums){
			$('#textModal').modal('show');
			return false;
		}

		$('#myform').submit();
	});

	$('#modalRegist').click(function(){
		let memo = $('#changeNumsMemo').val();

		if(memo==""){
			$('#textModal #changeNumsMemo').addClass('is-invalid');
			return false;
		}
		$('#inputMemo').val(memo);
		$('#myform').submit();

	});



});
</script>

</body>
</html>
