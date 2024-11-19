<?php

require_once('config/config.php');

$app = new \MyApp\Pre_order();

$wholesale = $app->getWholesale();
$date = date("Y-m-d" , strtotime('-1 week') );
$w = date("w" , strtotime('-1 week') );
$week = ['日','月','火','水','木','金','土'];

$title = 'プレ発注';


?>
<style media="screen">
	td {
		vertical-align: middle!important;
	}
	td.edit, .check_modal{
		color: blue!important;
		cursor: pointer;
	}
	@media print {
 		.no-print{display:none!important;}
	}
</style>

<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="page-header">
			<h1>
				プレ発注 <i class="bi bi-basket"></i>
			</h1>
		</div>

		<div id="btn-ext-group" class="no-print">
		<?php foreach($wholesale as $row): ?>
			<button class="btn btn-outline-primary btn-sm ext_btn"><?= h($row->name); ?></button>
		<?php endforeach; ?>
			<button class="btn btn-primary btn-sm" id="all_item">すべて表示</button>
		</div>
			<hr class="no-print">

		<div class="row">
			<!-- <div class="d-flex justify-content-center">
				<div class="col-md-6 col-xl-5">
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="ひらがな、またはJANコードを入力してください" aria-describedby="button-addon2" id="med_search">
						<button class="btn btn-outline-secondary" type="button" id="search_btn">検索</button>
					</div>
				</div>
			</div>

			<hr> -->
			<p><?= h(ymd_wareki($date). '('.$week[$w].')'); ?>以降の出庫状況</p>

			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>名前</th>
						<th>取引卸</th>
						<th>規格</th>
						<th class="text-center">販売数</th>
						<th class="text-center">在庫数</th>
						<th>barcode</th>
					</tr>
				</thead>
				<tbody id="tb_order">


					<tr data-id="" class="format_tr_init d-none">
						<td></td>
						<td class="check_modal"></td>
						<td></td>
						<td></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td></td>
					</tr>

				</tbody>
			</table>

		</div>
		<!-- row -->

		<!-- Modal -->
		<div class="modal fade" id="checkDateModal" tabindex="-1" aria-labelledby="checkDateModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="checkDateModalLabel">Modal title</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<table class="table">
							<thead class="table-dark">
								<tr>
									<th>販売日</th>
									<th class="text-center">販売個数</th>
								</tr>
							</thead>
							<tbody id="modal_tb">
								<tr class="format_modal_tr_init">
									<td></td>
									<td class="text-center"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>

<script>
$(function(){
	$.post('_ajax.php', {
		url: 'pre_order',
		mode: 'sales_data',
	}, function(res){
		for(let i=0; i<res.length; i++){
			let type = String(res[i]['jan']).length==8 ? 'ean8': 'ean13';
			let $tr;
			$tr = $('tr.format_tr_init').clone();
			$tr.removeClass('d-none');
			$tr.data('otc_id', res[i]['mainId']);
			$tr.children('td:eq(0)').text(res[i]['mainId']);
			// $('tbody#tb_order').append($tr);
			$tr.children('td:eq(1)').text(res[i]['otcName']);
			$tr.children('td:eq(2)').text(res[i]['wholesaleName']);
			$tr.children('td:eq(3)').text(res[i]['size']);
			$tr.children('td:eq(4)').text(res[i]['total_sales']+'個');
			$tr.children('td:eq(5)').text(res[i]['stock_nums']+'個');
			$tr.children('td:eq(6)').barcode(String(res[i]['jan']), type, {barWidth:2, barHeight:30,output:"css"});
			$tr.removeClass('format_tr_init');

			$('tbody#tb_order').append($tr);
		}
	});

	$('.ext_btn').click(function(){
		$('tbody#tb_order').children().show();
		let w_name = $(this).text();
		$('tbody#tb_order').children('tr').each(function(){
			let wholesale = $(this).children('td:eq(2)').text();
			if(wholesale!=w_name){
				$(this).hide();
			}
		});

		$(this).removeClass('btn-outline-primary').addClass('btn-primary');
		$(this).siblings().removeClass('btn-primary').addClass('btn-outline-primary');
	});

	$('#all_item').click(function(){
		$('tbody#tb_order').children().show();

		$(this).removeClass('btn-outline-primary').addClass('btn-primary');
		$(this).siblings().removeClass('btn-primary').addClass('btn-outline-primary');
	});

	$('#tb_order').on('click', '.check_modal', function(){
		let otc_id = $(this).parent('tr').data('otc_id');
		let otc_name = $(this).text();
		$.post('_ajax.php', {
			url: 'pre_order',
			mode: 'getProceedsData',
			otc_id: otc_id
		}, function(res){
			$('tbody#modal_tb').children('tr').each(function(){
				if(!$(this).hasClass('format_modal_tr_init')){
					$(this).remove();
				}
			});
			for(let i=0; i<res.length; i++){
				let $tr;
				let md_youbi = new Date(res[i]['date']).getDay();
				let yb = ['日','月','火','水','木','金','土'];
				$tr = $('tr.format_modal_tr_init').clone();
				$tr.children('td:eq(0)').text(ymd_to_wa_md(res[i]['date'])+ '（'+yb[md_youbi]+'）');
				$tr.children('td:eq(1)').text(res[i]['nums']+'個');
				$tr.removeClass('format_modal_tr_init');
				$('tbody#modal_tb').append($tr);
			}
			$('#checkDateModalLabel').text(otc_name);
		});


		$('#checkDateModal').modal('show');
	});

	function ymd_to_wa_md(ymd){
		let m = ymd.substr(5, 2);
		let d = ymd.substr(8, 2);
		return m+'月'+d+'日';
	}








	const regex_1 = /^\d{13}$/
	const regex_2 = /^\d{8}$/	

	$('#med_search').focus();

	$("#search_btn").click(function(){
		$('tbody#tb > tr.after_search').empty();
		let str = $("#med_search").val();

		let half_str = toHalfWidth(str);
		if( half_str.match(regex_1) || half_str.match(regex_2)){
			str = half_str;
		}

		if( str == "" ){
			alert("入力されていません");
			$("#med_search").focus();
			return false;
		}

		if( str.match(regex_1) || str.match(regex_2)){
			// Janコードの時
			$.post("_ajax.php",{
				url: 'otc_search',
				mode: 'search_item_barcode',
				code: $.trim( str )
			}, function(res){
				if(res){
					let $tr;
					$tr = $('tr.format_tr').clone();
					$tr.removeClass('d-none');
					$tr.addClass('after_search');
					if(res['stock_nums']==0){
						$tr.addClass('table-secondary');
					}
					$tr.children('td:eq(0)').text(res['mainId']);
					$tr.children('td:eq(1)').children('a').text(res['otcName']);
					$tr.children('td:eq(1)').children('a').attr('href', 'inout.php?id='+res['mainId']);
					$tr.children('td:eq(2)').text(res['jan']);
					$tr.children('td:eq(3)').text(res['wholesaleName']);
					$tr.children('td:eq(4)').text(res['class_name']);
					$tr.children('td:eq(5)').text(res['size']);
					$tr.children('td:eq(6)').text(res['purchase_price'].toLocaleString()+'円');
					$tr.children('td:eq(7)').text(res['selling_price'].toLocaleString()+'円');
					$tr.children('td:eq(8)').text(res['tax_include_price'].toLocaleString()+'円');
					$tr.children('td:eq(9)').text(res['tax']+'％');
					$tr.children('td:eq(10)').text(res['stock_nums']+'個');
					$tr.children('td:eq(11)').children('a').attr('href', 'correct_otc.php?id='+res['mainId']);
					$tr.removeClass('format_tr');
					$('tbody#tb').append($tr);
				} else {
					alert('『'+str+'』は見つかりませんでした');
				}
				$("#med_search").val('');
				$("#med_search").focus();
			});
		} else {
			// ふりがなの時
			$.post("_ajax.php",{
				url: 'otc_search',
				mode: 'search_items',
				word: $.trim( str )
			}, function(res){
				if(res.length>0){
					let $tr;
					for(let i=0; i<res.length; i++){
						$tr = $('tr.format_tr').clone();
						$tr.removeClass('d-none');
						$tr.addClass('after_search');
						if(res[i]['stock_nums']==0){
							$tr.addClass('table-secondary');
						}
						$tr.children('td:eq(0)').text(res[i]['mainId']);
						$tr.children('td:eq(1)').children('a').text(res[i]['otcName']);
						$tr.children('td:eq(1)').children('a').attr('href', 'inout.php?id='+res[i]['mainId']);
						$tr.children('td:eq(2)').text(res[i]['jan']);
						$tr.children('td:eq(3)').text(res[i]['wholesaleName']);
						$tr.children('td:eq(4)').text(res[i]['class_name']);
						$tr.children('td:eq(5)').text(res[i]['size']);
						$tr.children('td:eq(6)').text(res[i]['purchase_price'].toLocaleString()+'円');
						$tr.children('td:eq(7)').text(res[i]['selling_price'].toLocaleString()+'円');
						$tr.children('td:eq(8)').text(res[i]['tax_include_price'].toLocaleString()+'円');
						$tr.children('td:eq(9)').text(res[i]['tax']+'％');
						$tr.children('td:eq(10)').text(res[i]['stock_nums']+'個');
						$tr.children('td:eq(11)').children('a').attr('href', 'correct_otc.php?id='+res[i]['mainId']);
						$tr.removeClass('format_tr');
						$('tbody#tb').append($tr);
					}
				} else {
					alert('『'+str+'』は見つかりませんでした');
				}
				$("#med_search").val('');
				$("#med_search").focus();
			});
		}
	});

	$('#med_search').keypress(function(e){
		if(e.which==13){
			$("#search_btn").click();
			return false;
		}
	});

	function toHalfWidth(str) {
		// 全角英数字を半角に変換
		str = str.replace(/[０-９]/g, function(s) {
			return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
		});
		return str;
	}


});
</script>

</body>
</html>
