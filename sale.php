<?php

require_once('config/config.php');

$app = new \MyApp\Sale();
$mgId = $app->mg_id() + 1;

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>販売登録画面</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style>
	img{
		width: 80px;
		height: auto;
	}
	.deleteRow{
		color: red;
		cursor: pointer;
	}
	body{
		background: #eaf9de;
	}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">

		<div class="page-header">
		  <h1>販売登録画面 <small><i class="fa fa-sign-out fa-3x" aria-hidden="true"></i><i class="fa fa-user fa-3x" aria-hidden="true"></i></small></h1>
		</div>

		<div class="">
			管理ID: <span id="mgId"><?= h($mgId); ?></span>
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
					<th>写真</th>
					<th>名前</th>
					<th>販売価格</th>
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
						<button id="inputDb" class="btn btn-success">確定</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/jquery.uploadThumbs.js"></script>
<script>
$(function(){
	$('#inputJan').focus();

	$('tfoot').hide();

	$('#inputJan').keypress(function(e){
		if(e.which==13){
			var jan = $('#inputJan').val();
			var res = validate(jan);
			if(!validate(jan)) return false;
			ajax_process(jan);
			return false;
		}
	});

	function validate(jan){
		var res = jan.search(/^[0-9]+$/);
		return res==0 ? true : false;
	}

	function ajax_process(jan){
		$.post("_ajax.php", {
			jan: jan,
			url: "sale",
			type: "searchItem"
		}, function(res){
			if(res){
				var s = '<tr id="otc_id_'+res['id']+'">'+
								'<td>' + res['id'] + '</td>' +
								'<td>' + res['img'] + '</td>' +
								'<td>' + res['name'] + '</td>' +
								'<td><input type="text" class="text-right" name="price" size="4" value="' + res['tax_include_price'] + '"></td>'+
								'<td><input type="text" class="inputNums text-right" name="nums" size="3" value="1">個'+
								'<td class="deleteRow">[削除]</td>'
								'</tr>';
				$("#tb").append(s);
				$("#inputJan").val("");
				$("tr#otc_id_"+res['id']+" input[name='nums']").focus().select();
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
		var cnt = $('tbody#tb').children().length;
		var data = [];
		while(cnt > 0){
			var $tr = $('tbody#tb').children('tr:eq(0)');
			var id = $tr.children('td:eq(0)').text();
			var price = $tr.children('td:eq(3)').children('input').val();
			var nums = $tr.children('td:eq(4)').children('input').val();
			if(nums=="" || price==""){
				alert("空欄があります！");
				return false;
			}
			if(!validate(price) || !validate(nums)){
				alert("半角英数文字で入力してください！");
				return false;
			}
			data.push([id, price, nums]);
			$tr.remove();
			cnt--;
		}
		inputDb(data);
	});

	function inputDb(data){
		$.post('_ajax.php', {
			url: 'sale',
			type: 'check_id'
		}, function(res){
			for(var i=0; data.length>i; i++){
				$.post('_ajax.php', {
					url: 'sale',
					type: 'inputDb',
					id: data[i][0],
					price: data[i][1],
					nums: data[i][2],
					mgId: res
				}, function(){

				});
			}
			$('tbody#tb').remove();
			$('tfoot').hide();
			window.location.href = "receipt.php?mgId=" + res;
		});
	}
});
</script>

</body>
</html>
