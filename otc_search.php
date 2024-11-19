<?php

require_once('config/config.php');

$app = new \MyApp\Otc_Search();

$title = 'OTC検索';


?>
<style media="screen">
	td {
		vertical-align: middle!important;
	}
	td.edit{
		color: blue!important;
		cursor: pointer;
	}
</style>

<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="page-header">
			<h1>
				OTC検索 <i class="bi bi-search"></i>
			</h1>
		</div>

		<div class="row">
			<div class="d-flex justify-content-center">
				<div class="col-md-6 col-xl-5">
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="ひらがな、またはJANコードを入力してください" aria-describedby="button-addon2" id="med_search">
						<button class="btn btn-outline-secondary" type="button" id="search_btn">検索</button>
					</div>
				</div>
			</div>

			<hr>

			<table class="table table-hover">
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
					<tr data-id="" class="format_tr d-none">
						<td class="text-end"></td>
						<td><a href="" target="_blank" rel="noopener noreferrer"></a></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="text-end"></td>
						<td class="text-end"></td>
						<td class="text-end"></td>
						<td class="text-end"></td>
						<td class="text-end"></td>
						<td class="text-center edit">
							<a href="" target="_blank" rel="noopener noreferrer">[編集]</a>						
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- row -->
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>

<script>
$(function(){

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
