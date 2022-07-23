<?php

require_once('config/config.php');

$app = new \MyApp\Inventory();

$title = '棚卸システム';

// $items = $app->getAll();

// echo '<pre>';
// var_dump($items);
// echo '</pre>';

?>
<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>

	<?php include('template/tab_inventory.php'); ?>

	<div class="container mt-3">
		<div class="page-header mb-2">
			<h1>棚卸しシステム</h1>
		</div>

		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
				<h2>棚卸の流れ</h2>
				<div class="d-grid gap-2 mb-3">
					<a href="inventory_table.php" class="btn btn-outline-success btn-lg px-5 rounded-pill">在庫ありリスト</a>
					<span class="text-center">
						<i class="bi bi-arrow-down" style="font-size: 2em;"></i>
					</span>
					<a href="inventory_table_input.php" class="btn btn-outline-success btn-lg px-5 rounded-pill">入力フォーム</a>
					<span class="text-center">
						<i class="bi bi-arrow-down" style="font-size: 2em;"></i>
					</span>
					<a href="inventory_table_final.php" class="btn btn-outline-success btn-lg px-5 rounded-pill">棚卸済みリスト</a>
					<span class="text-center">
						<i class="bi bi-arrow-down" style="font-size: 2em;"></i>
					</span>
					<button class="btn btn-success btn-lg px-5 rounded-pill" id="inventory_submit">確定する</button>
				</div>
			</div>
			<div class="col-xs-12 col-sm-10 col-md-4 col-lg-6 col-xl-4">
				<h2 class="mt-3">棚卸の説明</h2>
				<ol>
					<li>
						「在庫ありリスト」で現在の在庫の状況の一覧が表示されます。<br>
						在庫が1以上の者が表となります。
					</li>
					<li>
						「入力フォーム」でそれぞれのアイテムの数を確定します。<br>
						確定すると背景がグレーとなり、次の「棚卸済みリスト」に表示されます。<br>
					</li>
					<li>
						「棚卸済みリスト」は先の入力フォームで確定したリストが表示されます。
					</li>
					<li>
						「確定する」を押すとその年月でデータベースに登録されます。
					</li>
				</ol>
			</div>
		</div>

	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>
<script>
$(function(){
	$('#inventory_submit').click(function(){
		if( confirm('棚卸を確定してデータベースに登録してもよろしいですか？')){
			$.post('_ajax.php', {
				url: 'inventory',
				mode: 'inventory_save'
			}, function(res){
				alert(res);
			});
		}
	});

	let url = location.pathname.split('/').slice(-1)[0];

	$("#tab_nav").children('li').children('a').each(function(){
		let href = $(this).attr('href');
		if(url==href){
			$(this).addClass('active');
		}
	});

});
</script>

</body>
</html>
