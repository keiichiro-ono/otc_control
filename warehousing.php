<?php

require_once('config/config.php');

$app = new \MyApp\Warehousing();

$thisYear = date("Y");

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>入庫画面</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<style>
	.deleteSubRow, .deleteRow{
		color: red;
		cursor: pointer
	}
	.inputLimit{
		color: blue;
		cursor: pointer;
	}
	.editSubRow{
		color: blue;
		cursor: pointer
	}
	.edit_input{
		width: 50px;
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
						<a href="warehousing.php" class="btn btn-info" disabled>入庫</a>
						<a href="proceeds.php" class="btn btn-info">出庫</a>
						<a href="returned.php" class="btn btn-info">返品</a>
					</div>
				  <h1>入庫入力画面 <small><i class="fa fa-sign-out fa-3x" aria-hidden="true"></i><i class="fa fa-home fa-3x" aria-hidden="true"></i></small></h1>
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
					<label for="inputJan" class="col-sm-3 text-right">JANコード入力</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="inputJan" name="jan" placeholder="JANコード(半角英数字)">
					</div>
				</div>

				<hr>

				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>名前</th>
							<th>仕入値</th>
							<th>個数</th>
							<th>期限</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="tb">

					</tbody>
					<tfoot>
						<tr>
							<td colspan="5"></td>
							<td>
								<button id="inputDb" class="btn btn-success">確定</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-sm-5">
				<?php include('warehousingSub.php'); ?>
			</div>

		</div>

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
								<th>ID</th>
								<th>名前</th>
								<th>入値</th>
								<th>入庫数</th>
							</thead>
							<tbody id="subTable">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div><!-- モーダル -->

		<!-- Modal2 -->
		<div class="modal fade" id="limitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">有効期限</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div id="yearInput">
							<?php for($i=0; $i<6; $i++): ?>
								<input type="radio" class="btn-check" name="limit_year" id="year_<?= h($i); ?>" autocomplete="off" value="<?= h($thisYear+$i); ?>">
								<label class="btn btn-success btn-sm" for="year_<?= h($i); ?>"><?= h($thisYear+$i); ?>年</label>
							<?php endfor; ?>
							<br><br>
							<input type="radio" class="btn-check" name="limit_year" id="year_none" autocomplete="off" value="null">
							<label class="btn btn-info btn-sm" for="year_none">期限なし</label>

						</div>
						<hr>
						<div id="monthInput">
							<?php for($i=1; $i<=12; $i++): ?>
								<input type="radio" class="btn-check" name="limit_month" id="month_<?= h($i); ?>" autocomplete="off" value="<?= h($i); ?>">
								<label class="btn btn-primary" for="month_<?= h($i); ?>"><?= h($i); ?>月</label>
							<?php endfor; ?>
						</div>
						<hr>
						<div id="dayInput">

						</div>


							</tbody>
						</table>
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div><!-- モーダル2 -->





	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
$(function(){
	let isEdit = false;
	$('#inputJan').focus();

	$('tfoot').hide();

	$('#inputDate').datepicker({dateFormat: 'yy/mm/dd'});
	$('#today').click(function(){
		var today = new Date;
		var y = today.getFullYear();
		var m = today.getMonth()+1;
		var d = today.getDate();
		var ymd = y+"/"+m+"/"+d;
		$('#inputDate').val(ymd);
	});

	$('#inputJan').keypress(function(e){
		if(e.which==13){
			var jan = $('#inputJan').val();
			var res = validate(jan);
			if(!validate(jan)){
				$(this).focus().select();
				return false;
			}
			ajax_search(jan);
			return false;
		}
	});

	function validate(jan){
		var res = jan.search(/^[0-9]+$/);
		return res==0 ? true : false;
	}

	function ajax_search(jan){
		$.post("_ajax_warehousing.php", {
			jan: jan,
			mode: "search"
		}, function(res){
			if(res){
				$('#subTable').empty();
				$('#searchModal').modal();
				var s = '<tr id="otc_id_'+res['id']+'" data-id="'+res['id']+'">'+
								'<td>' + res['id'] + '</td>' +
								'<td>' + res['name'] + '</td>' +
								'<td><input type="text" class="text-right" name="price" style="width:80px;" value="' + res['purchase_price'] + '"></td>'+
								'<td><input type="number" value="1" class="inputNums text-right" name="nums" style="width:60px;">個</td>'+
								'<td class="inputLimit">[期限入力]</td>'
								'</tr>';
				$("#subTable").append(s);
				// $("#inputJan").val("").focus();
				// $('tfoot').show();
			} else {
				var s = '<tr>'+
								'<td colspan="5">Janコード 【' + '<span id="noJan">'+jan + '</span>】 は存在しません</td>' +
								'<td><button class="btn btn-primary registRow">新規登録</button></td>'
								'</tr>';
				$("#tb").append(s);
				$("#inputJan").val("");
				$('tfoot').hide();
				$('#inputJan').hide();
			}
		});
	}

	$('#searchModal').on('click', '.inputLimit', function(){
		$('#limitModal').modal();

	});

	$('#monthInput').hide();
	$('#dayInput').hide();
	$('#yearInput input[name=limit_year]').click(function(){
		if($(this).val() == 'null'){
			nolimit();
			$('#searchModal').modal('toggle');
			$('#limitModal').modal('toggle');
		} else {
			$('#monthInput').show(300);
			$('#dayInput').hide(300);
		}
	});

	function nolimit(){
		var otc_id = $('#searchModal #subTable tr').data('id');
		var name = $('#searchModal #subTable tr').children('td:eq(1)').text();
		var price = $('#searchModal #subTable tr').children('td:eq(2)').children('input').val();
		var nums = $('#searchModal #subTable tr').children('td:eq(3)').children('input').val();

		var s = 	'<tr>'+
							'<td>'+otc_id+'</td>'+
							'<td>'+name+'</td>'+
							'<td>'+price+'</td>'+
							'<td>'+nums+'</td>'+
							'<td>期限なし</td>'+
							'<td class="deleteRow">[削除]</td>'+
							'</tr>';
		$('#tb').append(s);
		$("#inputJan").val("").focus();
		$("tfoot").show();
		$('#monthInput').hide();
		$('#dayInput').hide();
	}

	$('#monthInput input[name=limit_month]').click(function(){
		var year = $('#yearInput input[name=limit_year]:checked').val();
		var month = $('#monthInput input[name=limit_month]:checked').val();
		$.post('_serch_last_day.php',{
			year: year,
			month: month
		},function(res){
			$('#dayInput').empty();
			for(var i=1; i<=res; i++){
				var s = '<input type="radio" class="btn-check" name="limit_day" id="day_'+i+'" autocomplete="off" value="'+i+'"><label class="btn btn-default" for="day_'+i+'">'+i+'日</label>';
				$('#dayInput').append(s);
			}
			var s = '<input type="radio" class="btn-check" name="limit_day" id="day_none" autocomplete="off" value="'+res+'"><label class="btn btn-danger" for="day_'+res+'">指定なし</label>';
			$('#dayInput').append(s);
			$('#dayInput').show(300);
		});
	});

	$('#dayInput').on('click', 'input[name=limit_day]', function(){
		var otc_id = $('#searchModal #subTable tr').data('id');
		var name = $('#searchModal #subTable tr').children('td:eq(1)').text();
		var price = $('#searchModal #subTable tr').children('td:eq(2)').children('input').val();
		var nums = $('#searchModal #subTable tr').children('td:eq(3)').children('input').val();

		var year = $('#yearInput input[name=limit_year]:checked').val();
		var month = $('#monthInput input[name=limit_month]:checked').val();
		var day = $('#dayInput input[name=limit_day]:checked').val();

		$('#searchModal').modal('toggle');
		$('#limitModal').modal('toggle');

		var s = 	'<tr>'+
							'<td>'+otc_id+'</td>'+
							'<td>'+name+'</td>'+
							'<td>'+price+'</td>'+
							'<td>'+nums+'</td>'+
							'<td>'+year+'-'+month+'-'+day+'</td>'+
							'<td class="deleteRow">[削除]</td>'+
							'</tr>';
		$('#tb').append(s);
		$("#inputJan").val("").focus();
		$("tfoot").show();
		$('#monthInput').hide();
		$('#dayInput').hide();

	});

	$('#tb').on('click', '.deleteRow', function(){
		$(this).parent('tr').fadeOut(800, function(){
			$(this).remove();
			var cnt = $('tbody#tb').children().length;
			if(cnt===0) $('tfoot').hide();
		});
	});

	$('#tb').on('click', '.registRow', function(){
		var jan = $('#noJan').text();
		var url = "new_otc.php?jan="+jan;
		window.open(url, '_blank');
		// window.location.href="new_otc.php?jan="+jan;
	});

	$('#inputDb').click(function(){
		if( $("#inputDate").val() == "" ){
			alert("日付が入力されていません");
			$("#inputDate").focus();
			return false;
		}

		var cnt = $('tbody#tb').children().length;
		var data = [];
		while(cnt > 0){
			var $tr = $('tbody#tb').children('tr:eq(0)');
			var ymd = $("#inputDate").val();
			var id = $tr.children('td:eq(0)').text();
			var price = $tr.children('td:eq(2)').text();
			var nums = $tr.children('td:eq(3)').text();
			var limit;
			if( $tr.children('td:eq(4)').text()=="期限なし"){
				limit = null;
			} else {
				limit = $tr.children('td:eq(4)').text();
			}

			data.push([id, price, nums, ymd, limit]);
			$tr.remove();
			cnt--;
		}
		inputDb(data);
	});

	function inputDb(data){
		for(var i=0; data.length>i; i++){
			var limit = data[i][4];
			var ymd = data[i][3];
			var nums = data[i][2];
			var id = data[i][0];

			$.post('_ajax_warehousing.php', {
				mode: 'inputDb',
				id: data[i][0],
				price: data[i][1],
				nums: data[i][2],
				ymd: data[i][3],
				limit: data[i][4]
			}, function(res){
				$('tbody#tb tr[i]').fadeOut(800, function(){
					$(this).remove();
				});
				var e = $(
					'<tr>'+
					'<td>'+ ymd.substr(5,9)+ '</td>'+
					'<td><a href="inout.php?id='+ id +'">'+ res.name+ '</a>('+ res.stock_nums+')</td>'+
					'<td>'+ nums+ '</td>'+
					'<td></td>'+
					'</tr>'
				);
				$("#subClumnTable").prepend(e.fadeIn(800));
			});

		}
		$('tfoot').hide();
	}

	$("#subClumnTable").on('click', '.deleteSubRow', function(){
		if(isEdit) return false;
		// var day = $.trim($(this).parent('tr').children('td:eq(0)').text());
		let day = $.trim($(this).parent('td').parent('tr').children('td:eq(0)').text());
		// var name = $.trim($(this).parent('tr').children('td:eq(1)').text());
		let name = $.trim($(this).parent('td').parent('tr').children('td:eq(1)').text());
		// var nums = $.trim($(this).parent('tr').children('td:eq(2)').text());
		let nums = $.trim($(this).parent('td').parent('tr').children('td:eq(2)').text());
		// var id = $(this).parent('tr').data('id');
		let id = $(this).parent('td').parent('tr').data('id');
		// var otc_id = $(this).parent('tr').data('otc-id');
		let otc_id = $(this).parent('td').parent('tr').data('otc-id');
		if(confirm(day+'「'+name+'」 '+nums+'個\n削除してもよろしいですか')){
			$.post('_ajax_warehousing.php', {
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
		
	$("#subClumnTable").on('click', '.editSubRow', function(){
		if(isEdit==true) return false;
		isEdit=true;
		let nums = $.trim($(this).parent('td').parent('tr').children('td:eq(2)').text());
		let ac_price = $.trim($(this).parent('td').parent('tr').children('td:eq(3)').text());
		let id = $(this).parent('td').parent('tr').data('id');
		let otc_id = $(this).parent('td').parent('tr').data('otc-id');
		
		$(this).removeClass('editSubRow');
		$(this).parent('td').prev('td').empty();
		let e = $('<input type="text" class="edit_input">').val(ac_price).data('old_price',ac_price);
		let btn = $('<button class="btn-primary btn btn-xs editedSubRow"></button>').text('変更');
		$(this).parent('td').prev('td').append(e).append(btn);
	});
	
	
	$("#subClumnTable").on('click', '.editedSubRow', function(){
		let id = $(this).parent('td').parent('tr').data('id');
		let otc_id = $(this).parent('td').parent('tr').data('otc-id');
		let old_price = $(this).prev('input').data('old_price');
		let new_price = $.trim($(this).prev('input').val());
		let $this = $(this);
		
		if(new_price=='' || new_price <= 0){
			alert('入力に間違いがあります。');
			$(this).prev('input').focus();
			return false;
		} else if(new_price==old_price) {
			alert('変更がありません');
			// $(this).prev('input').focus();
			let $td = $this.parent('td');
			$td.empty();
			$td.append(new_price);
			$td.next('td').children('span:eq(0)').addClass('editSubRow');
			isEdit = false;

			return false;
		}
		
		$.post('_ajax_warehousing.php', {
			id: id,
			otc_id: otc_id,
			new_price: new_price,
			mode: "editSubPrice"
		}, function(res){
			if(res){
				let $td = $this.parent('td');
				$td.empty();
				$td.append(new_price);
				$td.next('td').children('span:eq(0)').addClass('editSubRow');
			}
			
		});

		isEdit=false;
	});
});
</script>

</body>
</html>
