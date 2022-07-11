<?php

require_once('config/config.php');

$app = new \MyApp\Sale_list();
$dayList = $app->daylist();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>販売一覧画面</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style>
	img{
		width: 40px;
		height: auto;
	}
	.date{
		color: blue;
		cursor: pointer;
	}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">

		<div class="page-header">
		  <h1>販売一覧画面</h1>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<div id="dayList" class="list-group">
				<?php foreach($dayList as $day): ?>
					<button type="button" class="list-group-item date"><?= h($day->date) ; ?></button>
				<?php endforeach; ?>
				</div>
			</div>
			<div class="col-sm-9" id="main">

			</div>

		</div>



	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script>
$(function(){
	$('#dayList').on('click', '.date', function(){
		var date = $(this).text();
		$('#main').load('_saleList_day.php?date='+date);
	});
});
</script>

</body>
</html>
