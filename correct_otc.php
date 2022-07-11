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


?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OTC修正画面</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">

</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">

  	<div class="row">
			<div class="page-header">
			  <h1>OTC修正画面</h1>
			</div>

			<form method="post" action="" enctype="multipart/form-data" id="myform">
			<input type="hidden" name="id" value="<?= h($item->mainId); ?>">
			<div class="col-sm-7">
				<div class="form-group row">
					<label for="inputName" class="col-sm-3">OTC名</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inputName" name="name" placeholder="名前" value="<?= h($item->otcName); ?>">
						修正前: <mark><?= h($item->otcName); ?></mark>
					</div>
				</div>

				<div class="form-group row">
					<label for="inputName" class="col-sm-3">かな名</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inputName" name="kana" placeholder="かな入力" value="<?= h($item->kana); ?>">
						修正前: <mark><?= h($item->kana); ?></mark>
					</div>
				</div>

				<div class="form-group row">
					<label for="inputJan" class="col-sm-3">JANコード</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inputJan" name="jan" placeholder="JANコード" value="<?= h($item->jan); ?>">
						修正前: <mark><?= h($item->jan); ?></mark>
					</div>
				</div>

				<div class="form-group row">
					<label for="inputNums" class="col-sm-3">個数</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="inputNums" name="stock_nums" placeholder="個数" value="<?= h($item->stock_nums); ?>">
						修正前: <mark><?= h($item->stock_nums); ?></mark>
					</div>
				</div>

				<div class="form-group row">
					<label for="inputSize" class="col-sm-3">規格サイズ</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inputSize" name="size" placeholder="規格サイズ" value="<?= h($item->size); ?>">
						修正前: <mark><?= h($item->size); ?></mark>
					</div>
				</div>

				<div class="form-group row">
					<label for="inputPurchase_price" class="col-sm-3">入値</label>
					<div class="col-sm-5">
						<input type="text" class="form-control text-right" id="inputPurchase_price" name="purchase_price" placeholder="入値" value="<?= h($item->purchase_price); ?>">
						修正前: <mark><?= h($item->purchase_price); ?></mark>円
					</div>
					<div class="col-sm-4">
						円
					</div>
				</div>

				<div class="form-group row">
					<label for="inputSelling_price" class="col-sm-3">売価</label>
					<div class="col-sm-5">
						<input type="text" class="form-control text-right" id="inputSelling_price" name="selling_price" placeholder="売価" value="<?= h($item->selling_price); ?>">
						修正前: <mark><?= h($item->selling_price); ?></mark>円
					</div>
					<div class="col-sm-4">
						円
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3">種類</label>
					<div class="col-sm-7">
						<select class="form-control" name="class">
							<?php foreach($class_name as $c_n): ?>
								<option value="<?= h($c_n->id); ?>" <?= $item->class_name === $c_n->class_name ? "selected" : ""; ?>><?= h($c_n->class_name); ?></option>
							<?php endforeach; ?>
						</select>
						修正前: <mark><?= h($item->class_name); ?></mark>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3">取引卸</label>
					<div class="col-sm-7">
						<select class="form-control" name="wholesale">
							<?php foreach($wholesale_name as $w_name): ?>
								<option value="<?= h($w_name->id); ?>" <?= $item->wholesale === $w_name->id ? "selected" : ""; ?>><?= h($w_name->name); ?></option>
							<?php endforeach; ?>
						</select>
						修正前: <mark><?= h($item->wholesaleName); ?></mark>
					</div>
				</div>


			</div>
			<div class="col-sm-5">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="self_med" <?= ($item->self_med==="1") ? "checked" : ""; ?>> セルフメディケーション対象医薬品 (修正前: <?= $app->check_self_med($item->self_med); ?>)
					</label>
				</div>

				<div class="checkbox">
					<label>
						<input type="checkbox" name="hygiene" <?= ($item->hygiene==="1") ? "checked" : ""; ?>> 衛生用品 (修正前: <?= $app->check_hygiene($item->hygiene); ?>)
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="tax" <?= ($item->tax==="8") ? "checked" : ""; ?>> 軽減税率対象（8％）
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="tokutei_kiki" <?= ($item->tokutei_kiki==="1") ? "checked" : ""; ?>> 特定保守管理医療機器
					</label>
				</div>


				<hr>

				<?php if(!empty($item->img)): ?>
					<div id="newImgArea">
						<div id="imgArea">
							<img src="img/<?= h($item->img); ?>" class="img-circle" style="width:150px; height:auto; margin-right:30px;">
							<button id="img_delete" class="btn btn-danger" data-id="<?= h($item->mainId); ?>">画像消去</button>
						</div>
					</div>
				<?php else: ?>
					<div class="form-group row">
						<label for="inputFile" class="col-sm-12">イメージファイル</label>
						<div class="col-sm-12">
							<input type="file" name="imgFile" id="inputFile" accept="image/jpeg">
						</div>
					</div>

					<span class="fa-stack fa-5x">
						<i class="fa fa-camera fa-stack-1x"></i>
						<i class="fa fa-ban fa-stack-2x text-danger"></i>
					</span>
				<?php endif; ?>

				<hr>
				<p class="text-right">
					<button type="submit" class="btn btn-warning">修正</button>
				</p>
			</form>


			</div>


    </row>
    <!-- row -->

	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script>
$(function(){
	$('#img_delete').on('click', function(){
		if(confirm('本当に削除してもよろしいですか')){
			$.post("_ajax.php",{
				id: $(this).data('id'),
				url: "correct_otc"
			},function(res){
				$('#imgArea').fadeOut(800, function(){
					$(this).remove();
					var img = '<div class="form-group row"><label for="inputFile" class="col-sm-12">イメージファイル</label><div class="col-sm-12"><input type="file" name="imgFile" id="inputFile" accept="image/jpeg"></div></div><span class="fa-stack fa-5x"><i class="fa fa-camera fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
					$('#newImgArea').append(img).hide().fadeIn(1200);
				});
			});
		}
		return false;
	});

	$('#inputFile').uploadThumbs({
		position : 1,      // 0:before, 1:after, 2:parent.prepend, 3:parent.append,
		                 // any: arbitrarily jquery selector
		imgbreak : true    // append <br> after thumbnail images
	});

	$('.form-control').keypress(function(e){
		var tar = $('.form-control').index(this)+1;
		if(tar===8) tar=0;
		if(e.which==13){
			$('.form-control:eq('+tar+')').focus();
			return false;
		}
	});

	$('#inputName').focus().select();


});
</script>

</body>
</html>
