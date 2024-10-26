<?php

require_once('config/config.php');

$app = new \MyApp\New_otc();
$class_name = $app->class_name();
$wholesale_name = $app->getWholesaleName();

if($_SERVER['REQUEST_METHOD']==="POST"){
	$app->postprocess();
	header( "Location: ". HOME_URL . "otc_list_new.php");
	exit;
}

$title = 'OTC新規登録画面';

?>
<?php include('template/header.php'); ?>


<body>
	<?php include('template/navber.php'); ?>
<div class="container mt-3">

	<form method="post" action="" enctype="multipart/form-data" id="myform" class="g-3 needs-validation" novalidate>

  	<div class="row justify-content-center">
		<h1>OTC新規作成画面 <i class="bi bi-file-earmark-plus" style="font-size: 3rem; color: cornflowerblue;"></i></h1>


			<div class="col-md-6 col-sm-12 my-4">
				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputName" class="col-form-label">OTC名</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputName" class="form-control"  name="name" placeholder="名前" required>
						<div class="invalid-feedback">OTCの名前を入力してください!</div>
					</div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputKana" class="col-form-label">かな名</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputKana" class="form-control"  name="kana" placeholder="かな名" required>
						<div class="invalid-feedback">かな名を入力してください!</div>
					</div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputJan" class="col-form-label">JAN</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputJan" class="form-control"  name="jan" placeholder="JANコード(半角英数字)" required>
						<div class="invalid-feedback">JANコードを入力してください!</div>
					</div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputNums" class="col-form-label">個数</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputNums" class="form-control" name="stock_nums" placeholder="個数(半角英数字)" required>
						<div class="invalid-feedback">個数を入力してください!</div>
					</div>
					<div class="col-auto">個 <small>（単位なしで入力）</small></div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputSize" class="col-form-label">規格サイズ</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputSize" class="form-control" name="size" placeholder="規格サイズ(錠数など)" required>
						<div class="invalid-feedback">規格を入力してください!</div>
					</div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputPurchase_price" class="col-form-label">入値</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputPurchase_price" class="form-control" name="purchase_price" placeholder="入値(税抜き価格)" required>
						<div class="invalid-feedback">入値を入力してください!</div>
					</div>
					<div class="col-auto">円 <small>（単位なしで入力）</small></div>
				</div>

				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputSelling_price" class="col-form-label">売価</label>
					</div>
					<div class="col-auto">
						<input type="text" id="inputSelling_price" class="form-control" name="selling_price" placeholder="売価(税抜き価格)" required>
						<div class="invalid-feedback">売値を入力してください!</div>
					</div>
					<div class="col-auto">円 <small>（単位なしで入力）</small></div>
				</div>

			</div>

			<div class="col-md-4 col-sm-12 my-4">

				<div class="bg-light p-3">
					<div class="row g-3 mb-3 align-items-center">
						<div class="col-auto">
							<label for="inputClass" class="col-form-label">種類</label>
						</div>
						<div class="col-auto">
							<select class="form-control" name="class" id="inputClass">
								<option disabled selected>ここからお選びください</option>
							<?php foreach($class_name as $c_n): ?>
								<option value="<?= h($c_n->id); ?>"><?= h($c_n->class_name); ?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="mb-3">
						<label for="cat_1" class="form-label">医薬品の場合は下記も選択してください</label>
						<select class="form-select" aria-label="category_1" id="cat_1" disabled>
							<option selected value="">なし</option>
							<?php foreach($app->category_1() as $cat_m): ?>
							<option value="<?= h($cat_m->cat_name); ?>"><?= h($cat_m->cat_name); ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="mb-3">
						<select class="form-select" name="category" aria-label="category_2" id="cat_2" disabled>
							<option selected value="">なし</option>
						</select>
					</div>

				</div>


				<div class="row g-3 mb-3 align-items-center">
					<div class="col-auto">
						<label for="inputWholesale" class="col-form-label">取引卸</label>
					</div>
					<div class="col-auto">
						<select class="form-control" name="wholesale" id="inputWholesale">
							<option disabled selected>ここからお選びください</option>
						<?php foreach($wholesale_name as $w_name): ?>
							<option value="<?= h($w_name->id); ?>"><?= h($w_name->name); ?></option>
						<?php endforeach; ?>
						</select>
					</div>
				</div>
			
				<div class="form-check form-switch mb-2">
					<input class="form-check-input" type="checkbox" id="flexSelfMed" name="self_med">
					<label class="form-check-label" for="flexSelfMed">セルフメディケーション対象医薬品</label>
				</div>

				<div class="form-check form-switch mb-2">
					<input class="form-check-input" type="checkbox" id="flexHygine" name="hygiene">
					<label class="form-check-label" for="flexHygine">衛生用品</label>
				</div>

				<div class="form-check form-switch mb-2">
					<input class="form-check-input" type="checkbox" id="flexTax" name="tax">
					<label class="form-check-label" for="flexTax">軽減税率対象（8％）</label>
				</div>

				<div class="form-check form-switch mb-2">
					<input class="form-check-input" type="checkbox" id="flexKiki" name="tokutei_kiki">
					<label class="form-check-label" for="flexKiki">特定管理医療機器</label>
				</div>



				
				<p class="text-end">
					<button type="button" id="otc_create" class="btn btn-danger rounded-pill px-4">登録</button>
				</p>

			</div>

		</form>
	</div>
    <!-- row -->
</div>
  <!-- container -->
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

	$('#inputName').focus();

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
		let ary = ['1', '2', '3', '4', '10'];
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

	$('#otc_create').click(function(){
		let name = $('#inputName').val();
		let kana = $('#inputKana').val();
		let jan = $('#inputJan').val();
		let nums = $('#inputNums').val();
		let size = $('#inputSize').val();
		let in_price = $('#inputPurchase_price').val();
		let sell_price = $('#inputSelling_price').val();

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
