<?php

require_once('config/config.php');

$app = new \MyApp\Setting();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>設定</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>設定 </h1>
		</div>

		<div class="row">
			<div class="col-sm-5">
				棚卸しをリセットする
				<button type="button" id="resetBtn" class="btn btn-danger">リセット</button>
			</div>
			<div class="col-sm-5">
				医薬品の税をすべて10％にする
				<button type="button" id="taxBtn" class="btn btn-danger">実行</button>
			</div>
		</div>
	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script>
$(function(){

	$('#resetBtn').click(function(){
		if(confirm('本当にリセットしてもよろしいですか？')){
			$.post('_ajax.php', {
				url: 'setting',
				type: 'inventory_reset'
			}, function(){
				window.location.href="inventory.php";
			});
		}
	});

	$('#taxBtn').click(function(){
		if(confirm('医薬品の税をすべて10％に変更しますか？')){
			$.post('_ajax.php', {
				url: 'setting',
				type: 'med_set_10'
			}, function(res){
				alert('医薬品はすべてで'+res+'件あり税をすべて10％に変更しました');

			});
		}
	});


});
</script>

</body>
</html>
