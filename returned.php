<?php

require_once('config/config.php');

$app = new \MyApp\Returned();
$title = '返品登録画面';
$today = date("Y-m-d");
$data = $app->threeDay();


?>
<?php include('template/header.php'); ?>
	<style>
	.deleteRow{
		color: red;
		cursor: pointer
	}
	</style>
<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="row">
			<div class="col-sm-7">
				<div class="page-header">
					<div class="btn-group" role="group">
						<a href="warehousing.php" class="btn btn-sm btn-outline-primary">入庫</a>
						<a href="proceeds.php" class="btn btn-sm btn-outline-primary" >出庫</a>
						<a href="returned.php" class="btn btn-sm btn-primary" disabled>返品</a>
					</div>
				  <h1>返品入力画面 <i class="bi bi-reply-fill" style="font-size: 3rem; color: cornflowerblue;"></i></h1>
				</div>
				<div class="p-5 mb-4 bg-light">
					<div class="row justify-content-center">
						<div class="col-auto">
							返品日:
						</div>
						<div class="col-auto">
							<input type="date" class="form-control" id="inputDate" name="date" placeholder="日付を入力" value="<?= h($today); ?>">
						</div>
						<div class="col-auto">
							<button class="btn btn-primary btn-sm" id="today">本日</button>
						</div>
					</div>
				</div>

				<div class="form-group row justify-content-center mb-5">
					<label for="inputJan" class="col-sm-3 text-end">JANコード入力</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="inputJan" name="jan" placeholder="JANコード(半角英数字)">
					</div>
				</div>

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
							<td colspan="3"></td>
							<td colspan="2" class="text-end">
								<button id="inputDb" class="btn btn-success">DBへ登録</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-sm-5">
				<h3>60日分のデ－タ(返品)</h3>
				<table class="table table-sm">
					<thead>
						<tr>
							<th>日付</th>
							<th>商品名</th>
							<th>数量</th>
						</tr>
					</thead>
					<tbody id="subClumnTable">
					<?php foreach($data as $d): ?>
						<tr>
							<td><?= h(date('m/d', strtotime($d->date))); ?></td>
							<td>
								<a href="inout.php?id=<?= h($d->otc_id); ?>">
									<?= h($d->name); ?>
								</a>
							</td>
							<td><?= h($d->nums); ?></td>
						</tr>
					<?php endforeach; ?>

					</tbody>
				</table>
			</div>

		</div>

	</div>
<?php include('template/footer.php'); ?>

<script>
$(function(){
	$('#inputJan').focus();

	$('tfoot').hide();

	$('#today').click(function(){
		let today = new Date();
		let y = today.getFullYear();
		let m = today.getMonth()+1;
		if(m<10){
			m = '0'+m.toString();
		}
		let d = today.getDate();
		let ymd = y+"-"+m+"-"+d;
		$('#inputDate').val(ymd);
	});

	$('#inputJan').keypress(function(e){
		if(e.which==13){
			let jan = $('#inputJan').val();
			let res = validate(jan);
			if(!validate(jan)){
				$(this).focus().select();
				return false;
			}
			ajax_search(jan);
			return false;
		}
	});

	function validate(jan){
		let res = jan.search(/^[0-9]+$/);
		return res==0 ? true : false;
	}

	function ajax_search(jan){
		$.post("_ajax.php", {
			url: 'returned',
			jan: jan,
			mode: "search"
		}, function(res){
			if(res){
				let s = '<tr id="otc_id_'+res['id']+'">'+
								'<td>' + res['id'] + '</td>' +
								'<td>' + res['name'] + '</td>' +
								'<td><input type="text" class="text-end form-control" name="price" value="' + res['purchase_price'] + '"></td>'+
								'<td><input type="number" value="1" class="inputNums form-control text-end" name="nums"></td>'+
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
			let cnt = $('tbody#tb').children().length;
			if(cnt===0) $('tfoot').hide();
		});
	});

	$('#tb').on('click', '.registRow', function(){
		let jan = $('#noJan').text();
		window.location.href="new_otc.php?jan="+jan;
	});

	$('#inputDb').click(function(){
		if( $("#inputDate").val() == "" ){
			alert("日付が入力されていません");
			$("#inputDate").focus();
			return false;
		}

		let cnt = $('tbody#tb').children().length;
		let data = [];
		while(cnt > 0){
			let $tr = $('tbody#tb').children('tr:eq(0)');
			let ymd = $("#inputDate").val();
			let id = $tr.children('td:eq(0)').text();
			let price = $tr.children('td:eq(2)').children('input').val();
			let nums = $tr.children('td:eq(3)').children('input').val();
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
		for(let i=0; data.length>i; i++){
			let ymd = data[i][3];
			let nums = data[i][2];

			$.post('_ajax_returned.php', {
				url: 'returned',
				mode: 'inputDb',
				id: data[i][0],
				price: data[i][1],
				nums: data[i][2],
				ymd: data[i][3]
			}, function(res){
				$('tbody#tb tr[i]').fadeOut(800, function(){
					$(this).remove();
				});
				let e = $(
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
