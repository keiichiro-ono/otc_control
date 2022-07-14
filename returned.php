<?php

require_once('config/config.php');

$app = new \MyApp\Returned();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>返品登録</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<style>
	.deleteRow{
		color: red;
		cursor: pointer
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
						<a href="proceeds.php" class="btn btn-info">出庫</a>
						<a href="returned.php" class="btn btn-info" disabled>返品</a>
					</div>
				  <h1>返品入力画面 <small><i class="fa fa-reply fa-3x"></i></small></h1>
				</div>
				<div class="jumbotron">
					<div class="row">
						<div class="col-xs-2 text-right">
							返品日:
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
							<th>返金額</th>
							<th>個数</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="tb">

					</tbody>
					<tfoot>
						<tr>
							<td colspan="5"></td>
							<td>
								<button id="inputDb" class="btn btn-danger">確定</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-sm-5">
				<?php include('returnedSub.php'); ?>
			</div>

		</div>

	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
$(function(){
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
		$.post("_ajax_returned.php", {
			jan: jan,
			mode: "search"
		}, function(res){
			if(res){
				var s = '<tr id="otc_id_'+res['id']+'">'+
								'<td>' + res['id'] + '</td>' +
								'<td>' + res['name'] + '</td>' +
								'<td><input type="text" class="text-right" name="price" size="4" value="' + res['purchase_price'] + '"></td>'+
								'<td><input type="number" value="1" class="inputNums text-right" name="nums" size="3">個'+
								'<td class="deleteRow">[削除]</td>'
								'</tr>';
				$("#tb").append(s);
				$("#inputJan").val("").focus();
				$('tfoot').show();
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

	$('#tb').on('keypress', '.inputNums', function(e){
		if(e.which==13){
			$('#inputJan').focus();
			return false;
		}
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
		window.location.href="new_otc.php?jan="+jan;
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
			var price = $tr.children('td:eq(2)').children('input').val();
			var nums = $tr.children('td:eq(3)').children('input').val();
			if(nums=="" || price==""){
				alert("空欄があります！");
				return false;
			}
			if(!validate(nums)){
				alert("半角英数文字で入力してください！");
				return false;
			}
			data.push([id, price, nums, ymd]);
			$tr.remove();
			cnt--;
		}
		inputDb(data);
	});

	function inputDb(data){
		for(var i=0; data.length>i; i++){
			var ymd = data[i][3];
			var nums = data[i][2];

			$.post('_ajax_returned.php', {
				mode: 'inputDb',
				id: data[i][0],
				price: data[i][1],
				nums: data[i][2],
				ymd: data[i][3]
			}, function(res){
				$('tbody#tb tr[i]').fadeOut(800, function(){
					$(this).remove();
				});
				var e = $(
					'<tr>'+
					'<td>'+ ymd.substr(5,9)+ '</td>'+
					'<td>'+ res+ '</td>'+
					'<td>'+ nums+ '</td>'+
					'</tr>'
				);
				$("#subClumnTable").prepend(e.fadeIn(800));
			});

		}
		$('tfoot').hide();
	}
});
</script>

</body>
</html>