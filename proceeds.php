<?php

require_once('config/config.php');

$app = new \MyApp\Proceeds();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>売上登録</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style>
	table#mainTable>tbody#tb>tr>td.delete, td.deleteSubRow{
		color: red;
		cursor: pointer!important;
	}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="row">
			<div class="col-sm-7">
				<div class="page-header">
					<div class="btn-group" role="group">
						<a href="warehousing.php" class="btn btn-info">入庫</a>
						<a href="proceeds.php" class="btn btn-info" disabled>出庫</a>
						<a href="returned.php" class="btn btn-info">返品</a>
					</div>
				  <h1>売上登録画面 <small><i class="fa fa-sign-out fa-3x" aria-hidden="true"></i><i class="fa fa-user fa-3x" aria-hidden="true"></i></small></h1>
				</div>

				<div class="jumbotron">
					<div class="row">
						<div class="col-xs-2 text-right">
							売上日:
						</div>
						<div class="col-xs-5">
							<input type="text" class="form-control" id="inputDate" name="date" placeholder="日付を入力">
						</div>
						<div class="col-xs-2">
							<button class="btn btn-primary" id="today">本日</button>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="search" class="col-xs-3 text-right">商品検索</label>
					<div class="col-xs-5">
						<input type="text" class="form-control" id="search" name="search" placeholder="かなを入力してください">
					</div>
					<div class="col-xs-4">
						<button class="btn btn-warning" id="searchBtn">Search!</button>
					</div>
				</div>

				<hr>

				<table class="table" id="mainTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>名前</th>
							<th>税込価格(単価)</th>
							<th>現在庫数</th>
							<th>販売個数</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="tb">

					</tbody>
					<tfoot>
						<tr>
							<td colspan="5"></td>
							<td>
								<button id="inputDb" class="btn btn-success">DBへ登録</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-sm-5">
				<?php include('proceedsSub.php'); ?>
			</div>
		</div>
		<!-- row -->

	</div>
  <!-- container -->

	<!-- Modal -->
	<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">検索結果</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table table-hover">
						<thead>
							<th>名前</th>
							<th>在庫数</th>
							<th>税込み価格</th>
						</thead>
						<tbody id="subTable">
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					ダブルクリックで選択してね！
				</div>
			</div>
		</div>
	</div><!-- モーダル -->









<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
$(function(){

	$('#inputDb').hide();

	$('#inputDate').datepicker({dateFormat: 'yy/mm/dd'});
	$('#today').click(function(){
		var today = new Date;
		var y = today.getFullYear();
		var m = today.getMonth()+1;
		var d = today.getDate();
		var ymd = y+"/"+m+"/"+d;
		$('#inputDate').val(ymd);
	});

	$("#searchBtn").click(function(){
		if( $("#inputDate").val() == "" ){
			alert("日付が入力されていません");
			$("#inputDate").focus();
			return false;
		}

		$.post("_ajax_search.php",{
			mode: 'search',
			word: $.trim( $("#search").val() )
		}, function(res){
			if(res){
				$('#subTable').empty();
				$('#searchModal').modal();
				for(var i=0; i<res.length; i++){
					var stock = (res[i].stock_nums<=0) ? 'danger' : 'default';
					var e = $(
						'<tr data-id="'+res[i].id+'" class="preSearch text-'+stock+'">'+
						'<td>'+ res[i].name + '</td>' +
						'<td class="text-right">'+ res[i].stock_nums + '</td>' +
						'<td class="text-right">'+ res[i].tax_include_price + '</td>' +
						'</tr>'
					);
					$('#subTable').append(e);
				}
			} else {
				alert("見つかりませんでした！");
				$("#inputWord").select().focus();
			}

		});
	});

	$("#subTable").on('dblclick', 'tr', function(){
		var id = $(this).data('id');
		$.post('_ajax_search.php', {
			'mode': 'choice',
			id: id
		}, function(res){
			$('#searchModal').modal('toggle');
			var e = $(
				'<tr>'+
				'<td>'+ res.id+ '</td>'+
				'<td>'+ res.name+ '</td>'+
				'<td class="text-right"><input type="number" min="1" class="text-right form-control" value='+ res.tax_include_price+ '></td>'+
				'<td class="text-right">'+ res.stock_nums+ '</td>'+
				'<td class="sellNums"><input type="number" min="1" class="text-right form-control" value="1"></td>'+
				'<td class="delete"><button class="btn btn-danger btn-sm">削除</button></td>'+
				'</tr>'
			);
			$("#mainTable").append(e.fadeIn(800));
			$("#search").val("").focus();
			$("#inputDb").show();
		});
	});

	$("#search").keypress(function(e){
		if(e.which == 13){
			$("#searchBtn").click();
		}
	});

	$("#mainTable").on('click', '.delete>button', function(){
		if($("#mainTable").children('tbody').children('tr').length==1){
			$("#inputDb").hide(800);
		}
		$(this).parent().parent().hide(800,function(){
			$(this).remove();
		});
		$("#search").val("").focus();
	});

	$("#inputDb").on('click', function(){
		if($("#tb").children('tr')){
			if(checkNum()){
				$("#tb").children('tr').each(function(){
					var $tr = $(this);
					var id = $tr.children('td:eq(0)').text();
					var actual_price = $tr.children('td').children('input:eq(0)').val();
					var nums = $tr.children('td').children('input:eq(1)').val();
					var ymd = $("#inputDate").val();
					$.post('_ajax_search.php', {
						'mode': 'dbInsert',
						'id': id,
						'actual_price': actual_price,
						'nums': nums,
						'ymd': ymd
					}, function(res){
						$tr.fadeOut(800, function(){
							$(this).remove();
						});
						var e = $(
							'<tr>'+
							'<td>'+ ymd.substr(5,9)+ '</td>'+
							'<td><a href="inout.php?id='+ id +'">'+ res.name+ '</a>('+res.stock_nums+')</td>'+
							'<td>'+ nums+ '</td>'+
							'<td></td>'+
							'</tr>'
						);
						$("#subClumnTable").prepend(e.fadeIn(800));
					});
				});
				$("#inputDb").hide(800);
			} else {
				alert('数量に0以下の数値が入力されています。');
			}
		} else {
			alert('データなし');
		}
	});

	function checkNum(){
		var a = 0;
		$("#tb").children('tr').each(function(){
			var num = $(this).children('td').children('input').val();
			if(num<=0) a++;
		});
		return a==0 ? true : false;
	}

	$("#subClumnTable").on('click', '.deleteSubRow', function(){
		var day = $.trim($(this).parent('tr').children('td:eq(0)').text());
		var name = $.trim($(this).parent('tr').children('td:eq(1)').text());
		var nums = $.trim($(this).parent('tr').children('td:eq(2)').text());
		var id = $(this).parent('tr').data('id');
		var otc_id = $(this).parent('tr').data('otc-id');
		if(confirm(day+'「'+name+'」 '+nums+'個\n削除してもよろしいですか')){
			$.post('_ajax_search.php', {
				id: id,
				nums: nums,
				otc_id: otc_id,
				mode: "deleteSubRow"
			}, function(res){
				if(res){
					$("#warehousingId_"+id).fadeOut(800);
				} else {
					alert('削除できませんでした');
				}
			});

		}
	});

});
</script>

</body>
</html>
