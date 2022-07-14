<?php

require_once('config/config.php');

$app = new \MyApp\New_otc();
$class_name = $app->class_name();
$wholesale_name = $app->getWholesaleName();

if($_SERVER['REQUEST_METHOD']==="POST"){
	$id = $app->postprocess();
	if($_FILES["imgFile"]["size"] !== 0) {
		try{
			$app->save_file($id);
		}catch(Exception $e){
			echo $e->getMessage();
			exit;
		}
	}
	header( "Location: ". HOME_URL . "otc_list.php?jan=". $_POST['jan']);
	exit;
}

$title = 'OTC新規登録画面';

?>
<?php include('template/header.php'); ?>


<body>
	<?php include('template/navber.php'); ?>
	<div class="container">

  	<div class="row">
		<h1>OTC新規作成画面</h1>

		<form method="post" action="" enctype="multipart/form-data" id="myform" class="g-3 needs-validation" novalidate>
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
					<label for="inputJan" class="col-form-label">JANコード</label>
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
					<div class="invalid-feedback">JANコードを入力してください!</div>
				</div>
				<div class="col-auto">個 <small>（単位なしで入力）</small></div>
			</div>

		











			<div class="col-sm-7">
				<div class="form-group row">
					<label for="inputName" class="col-sm-3 text-end">OTC名</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inputName" name="name" placeholder="名前">
					</div>
				</div>

				<div class="form-group row">
					<label for="inputName" class="col-sm-3 text-end">かな名</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inputName" name="kana" placeholder="かな入力(ひらがな)">
					</div>
				</div>

				<div class="form-group row">
					<label for="inputJan" class="col-sm-3 text-end">JANコード</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inputJan" name="jan" placeholder="JANコード(半角英数字)">
					</div>
				</div>

				<div class="form-group row">
					<label for="inputNums" class="col-xs-3 text-end">個数</label>
					<div class="col-xs-3">
						<input type="text" class="form-control text-end" id="inputNums" name="stock_nums" placeholder="個数(半角英数字)">
					</div>
					<div class="col-xs-6">
						個 <small>（単位なしで入力）</small>
					</div>
				</div>

				<div class="form-group row">
					<label for="inputSize" class="col-sm-3 text-end">規格サイズ</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inputSize" name="size" placeholder="規格サイズ(錠数など)">
					</div>
				</div>

				<div class="form-group row">
					<label for="inputPurchase_price" class="col-xs-3 text-end">入値</label>
					<div class="col-xs-5">
						<input type="text" class="form-control text-end" id="inputPurchase_price" name="purchase_price" placeholder="入値(半角英数字)">
					</div>
					<div class="col-xs-4">
						円
					</div>
			</div>

			<div class="form-group row">
				<label for="inputSelling_price" class="col-xs-3 text-end">売価</label>
				<div class="col-xs-5">
					<input type="text" class="form-control text-end" id="inputSelling_price" name="selling_price" placeholder="売価(半角英数字)">
				</div>
				<div class="col-xs-4">
					円
				</div>
			</div>


			<div class="form-group row">
				<label class="col-sm-3 text-right">種類</label>
				<div class="col-sm-7">
					<select class="form-control" name="class">
						<?php foreach($class_name as $c_n): ?>
							<option value="<?= h($c_n->id); ?>"><?= h($c_n->class_name); ?></option>
						<?php endforeach; ?>
					</select>

				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 text-right">取引卸</label>
				<div class="col-sm-7">
					<select class="form-control" name="wholesale">
						<?php foreach($wholesale_name as $w_name): ?>
							<option value="<?= h($w_name->id); ?>"><?= h($w_name->name); ?></option>
						<?php endforeach; ?>
					</select>

				</div>
			</div>



			</div>
			<div class="col-sm-5">
				<div class="form-group row">
					<label for="inputFile" class="col-sm-12">イメージファイル</label>
					<div class="col-sm-12">
						<input type="file" name="imgFile" id="inputFile" accept="image/jpeg">
					</div>
				</div>

				<div class="checkbox">
					<label>
						<input type="checkbox" name="self_med"> セルフメディケーション対象医薬品
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="hygiene"> 衛生用品
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="tax"> 軽減税率対象（8％）
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="tokutei_kiki"> 特定管理医療機器
					</label>
				</div>
				<hr>
				<p class="text-right">
					<button type="submit" class="btn btn-danger">登録</button>
				</p>

			</div>
		</form>
    </row>
    <!-- row -->
	</div>
  <!-- container -->

<script>
$(function(){
	// $('form input:file').uploadThumbs({
	// 	position : 1,      // 0:before, 1:after, 2:parent.prepend, 3:parent.append,
	// 	                 // any: arbitrarily jquery selector
	// 	imgbreak : true    // append <br> after thumbnail images
	// });

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

});
</script>

</body>
</html>
