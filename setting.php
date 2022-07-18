<?php

require_once('config/config.php');

$app = new \MyApp\Setting();

$title = '設定';

?>
<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="page-header">
			<h1>設定 </h1>
		</div>

		<div class="row">
			<div class="col-sm-5">
				棚卸しをリセットする
				<button type="button" id="resetBtn" class="btn btn-danger">リセット</button>
			</div>
		</div>
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>
<script>
$(function(){

	$('#resetBtn').click(function(){
		if(confirm('本当にリセットしてもよろしいですか？')){
			$.post('_ajax.php', {
				url: 'setting',
				type: 'inventory_reset'
			}, function(){
				window.location.href="inventory_table.php";
			});
		}
	});

});
</script>

</body>
</html>
