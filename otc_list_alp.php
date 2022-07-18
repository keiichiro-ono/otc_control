<?php

require_once('config/config.php');

$app = new \MyApp\Otc_list_alp();
if(isset($_GET['sort']) && !empty($_GET['sort'])){
	$items = $app->sortItem();
} else {
	if(isset($_GET['extract']) && !empty($_GET['extract'])){
		$items = $app->extractItem();
	} else {
		$items = $app->allItem();
		//var_dump($items);exit;
	}
}

$title = 'OTC一覧画面(50音)';


?>
<style media="screen">
	img{
		width: 50px;
		height: auto;
	}
	td {
		vertical-align: middle!important;
	}
	.edit, .link{
		color: blue;
		cursor: pointer;
	}
	.gray{
		background: #eee;
	}
</style>

<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="page-header">
			<h1>OTC一覧画面 【50音】 <i class="bi bi-list-columns-reverse" style="font-size: 3rem; color: cornflowerblue;"></i></h1>
			<button type="button" class="btn btn-secondary active" id="all_dis">全表示</button>
			<div class="btn-group" role="group" id="mokuji">
				<button type="button" class="btn btn-secondary" id="a_dis" data-chara="a">あ行</button>
				<button type="button" class="btn btn-secondary" id="ka_dis" data-chara="ka">か行</button>
				<button type="button" class="btn btn-secondary" id="sa_dis" data-chara="sa">さ行</button>
				<button type="button" class="btn btn-secondary" id="ta_dis" data-chara="ta">た行</button>
				<button type="button" class="btn btn-secondary" id="na_dis" data-chara="na">な行</button>
				<button type="button" class="btn btn-secondary" id="ha_dis" data-chara="ha">は行</button>
				<button type="button" class="btn btn-secondary" id="ma_dis" data-chara="ma">ま行</button>
				<button type="button" class="btn btn-secondary" id="ya_dis" data-chara="ya">や行</button>
				<button type="button" class="btn btn-secondary" id="ra_dis" data-chara="ra">ら行</button>
				<button type="button" class="btn btn-secondary" id="wa_dis" data-chara="wa">わ行</button>
			</div>
			<div class="btn-group" role="group" id="tax_btn">
				<button type="button" class="btn btn-secondary" id="tax_8" data-num="8">8%</button>
				<button type="button" class="btn btn-secondary" id="tax_10" data-num="10">10%</button>
			</div>
			<div class="btn-group" role="group" id="exist_btn">
				<button type="button" class="btn btn-secondary" id="all_item">全表示</button>
				<button type="button" class="btn btn-secondary" id="exist_item">在庫あり</button>
			</div>

		</div>

		<p class="text-end">消費税は2019年10月以降の割合</p>

		<div class="row">
			<table class="table table-bordered table-sm table-hover">
				<thead>
					<tr>
						<th class="text-center link" data-name="mainId">ID</th>
						<th class="text-center link" data-name="kana">名前</th>
						<th class="text-center link" data-name="jan">JAN</th>
						<th class="text-center link" data-name="wholesale">取引卸</th>
						<th class="text-center link" data-name="class">分類</th>
						<th class="text-center">規格</th>
						<th class="text-center link" data-name="purchase_price">入値</th>
						<th class="text-center link" data-name="selling_price">販売価格</th>
						<th class="text-center link" data-name="tax_include_price">税込み価格</th>
						<th class="text-center">消費税</th>
						<th class="text-center link" data-name="stock_nums">在庫数</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="tb">
				<?php foreach($items as $item): ?>
					<tr data-id="<?= h($item->mainId); ?>" class="<?= h($item->stock_nums<=0 ? "gray": ""); ?>">
						<td class="text-right"><?= h($item->mainId); ?></td>
						<td>
							<?= h($app->check_self_med($item->self_med)); ?>
							<a href="inout.php?id=<?= h($item->mainId); ?>"><?= h($item->otcName); ?></a>
						</td>
						<td><?= h($item->jan); ?></td>
						<td><?= h($item->wholesaleName); ?></td>
						<td><?= h($item->class_name); ?></td>
						<td><?= h($item->size); ?></td>
						<td class="text-right">
							<?= h(number_format($item->purchase_price, 2)); ?>円
						</td>
						<td class="text-right">
							<?= h(number_format($item->selling_price, 0)); ?>円
						</td>
						<td class="text-right">
							<?php
								if(
									$item->tax==10 &&
									(strtotime("1 October 2019") > time())
									)
							:?>
								<?= h(number_format($item->selling_price*1.08, 0)); ?>円
							<?php else: ?>
								<?= h(number_format($item->tax_include_price, 0)); ?>円
							<?php endif; ?>
						</td>
						<td class="text-right">
							<?= h($item->tax); ?>％
						</td>
						<td class="text-right">
							<?= h($item->stock_nums); ?>個
						</td>
						<td class="text-center edit">[編集]</td>
					</tr>
				<?php endforeach; ?>
				</tbody>

			</table>
		</div>
		<!-- row -->
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>

<script>
$(function(){
	$('#exist_item').addClass('active');
	$('tbody#tb>tr').each(function(){
		if( $(this).hasClass('gray') ){
			$(this).hide();
		}
	});

	$('table>thead>tr>th').click(function(){
		var data = $(this).data('name');
		if(data != undefined){
			window.location = "?sort=" + data;;
		}
	});

	$('tbody#tb').on('click', '.edit', function(){
		var id = $(this).parent().data('id');
		window.location.href = "correct_otc.php?id=" + id;
	});

	$('#mokuji button').each(function(){
		if(getParam()==$(this).data('chara')){
			$('#all_dis').removeClass('active');
			$(this).addClass('active');
			return;
		}
	});

	$('#tax_btn button').each(function(){
		if(getParam()==$(this).data('num')){
			$('#all_dis').removeClass('active');
			$(this).addClass('active');
			return;
		}
	});



	function getParam() {
		var url = location.href;
		parameters = url.split("extract=");
		if(parameters[1]){
			return parameters[1];
		} else {
			return false;
		}
	}

	$('#mokuji button').click(function(){
		var chara = $(this).data('chara');
		location.href = "?extract=" + chara;
	});

	$('#tax_btn button').click(function(){
		var num = $(this).data('num');
		location.href = "?extract=" + num;
	});

	$('#all_dis').click(function(){
		location.href = "otc_list_alp.php";
	});

	$('#all_item').click(function(){
		$(this).addClass('active');
		$('#exist_item').removeClass('active');
		$('tbody#tb>tr').each(function(){
			if( $(this).hasClass('gray') ){
				$(this).show(400);
			}
		});
	});

	$('#exist_item').click(function(){
		$(this).addClass('active');
		$('#all_item').removeClass('active');
		$('tbody#tb>tr').each(function(){
			if( $(this).hasClass('gray') ){
				$(this).hide(400);
			}
		});
	});

});
</script>

</body>
</html>
