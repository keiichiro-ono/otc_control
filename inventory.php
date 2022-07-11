<?php

require_once('config/config.php');

$app = new \MyApp\Inventory();

$items = $app->allItem();

?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>棚卸し（バーコード）</title>
	<link rel="stylesheet" href="lib/js/bootstrap.min.css">
	<link rel="stylesheet" href="lib/js/font-awesome.min.css">
	<link rel="stylesheet" href="lib/js/styles.css">
	<style media="screen">
		img{
			width: 150px;
			height: auto;
		}
		#check_table{
			background: #eee;
		}
	</style>
</head>
<body>
	<?php include('nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1>棚卸し(バーコード) </h1>
		</div>

		<div class="row">
			<div class="form-group row">
				<label for="inputJan" class="col-xs-3 text-right">JAN入力</label>
				<div class="col-xs-5">
					<input type="text" class="form-control" id="inputJan" name="jan" placeholder="JANコード(半角英数字)">
				</div>
			</div>

			<div class="col-sm-5">

				<p class="bg-primary text-center">棚卸し終了リスト</p>
				<table class="table">
					<thead>
						<tr>
							<th>Jan</th>
							<th>名前</th>
							<th>在庫</th>
							<th>規格</th>
						</tr>
					</thead>
					<tbody id="finish_list">
					<?php foreach($items as $item): ?>
						<tr data-id="<?= h($item->mainId); ?>">
							<td><?= h($item->jan); ?></td>
							<td><?= h($item->name); ?></td>
							<td class="text-right"><?= h($item->stock_nums); ?>個</td>
							<td class="text-right"><?= h($item->size); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-7">
				<table class="table" id="check_table">
					<tr>
						<th class="text-right">名前</th>
						<td id="resName"></td>
						<td id="resImg" rowspan="4"></td>
					</tr>
					<tr>
						<th class="text-right">JAN</th>
						<td id="resJan"></td>
					</tr>
					<tr>
						<th class="text-right">規格</th>
						<td id="resSize"></td>
					</tr>
					<tr>
						<th class="text-right">在庫数</th>
						<td id="resNums"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script>
$(function(){
	$('#inputJan').focus();

	$('#check_table').hide();

	$('#inputJan').keypress(function(e){
		if(e.which==13){
			var jan = $('#inputJan').val();
			if(!validate(jan)) return false;
			ajax_process(jan);
			resetItem();
			return false;
		}
	});

	function validate(jan){
		var check = true;
		$('tbody#finish_list tr').each(function(){
			if(jan == $(this).children('td:eq(0)').text()){
				if(confirm("すでに登録済みですが続けますか？")){
					return false;
				} else {
					check = false;
				}
			}
		});
		var res = jan.search(/^[0-9]+$/);
		return (res==0 && check) ? true : false;
	}

	function ajax_process(jan){
		$.post('_ajax.php', {
			url: 'inventory',
			type: 'serchItemInv',
			jan: jan
		}, function(res){
			if(res){
				$('#resName').text(res['name']);
				$('#resJan').text(res['jan']);
				$('#resSize').text(res['size']);
				var s = '<input type="text" name="nums" size="3" id="resNumsInput" value="'+ res['stock_nums'] +'">' +
									'<input type="button" id="regist" value="登録">';
				$('#resNums').append(s);
				var img = '<img src="img/'+ res['img'] +'" class="img-thumbnail">';
				$('#resImg').append(img);
				$('#inputJan').val('');
				$('#check_table').show();
				$('#resNums').children('input:eq(0)').focus().select();
			} else {
				alert("そのJANコードは登録されていません！");
				$('#inputJan').focus().select();
			}
		});
	}

	$(document).on('keypress', '#resNumsInput',  function(e){
		if(e.which==13){
			$('#regist').click();
		}
	});

	$('#resNums').on('click', '#regist', function(){
		var nums = $(this).prev('input').val();
		var jan = $('#resJan').text();
		var size = $('#resSize').text();
		var name = $('#resName').text();
		$.post('_ajax.php', {
			url: 'inventory',
			type: 'registNums',
			jan: jan,
			nums: nums
		}, function(res){
			$('tbody#finish_list tr').each(function(){
				if(jan == $(this).children('td:eq(0)').text()){
					$(this).children('td:eq(2)').text(nums+'個').hide().fadeIn(800);
					res = false;
					resetItem();
					return true;
				}
			});
			if(res){
				var d = '<tr>' +
					'<td>' + jan +'</td>' +
					'<td>' + name +'</td>' +
					'<td class="text-right">' + nums +'個</td>' +
					'<td class="text-right">' + size +'</td>' +
					'</td>';
				$('#finish_list').append(d);
				resetItem();
				$('#inputJan').val("").focus();
			}
		});
	});

	function resetItem(){
		$('#resName').text("");
		$('#resJan').text("");
		$('#resSize').text("");
		$('#resNums').text("");
		$('#resImg').text("");
		$('#check_table').hide();
	}

});
</script>

</body>
</html>
