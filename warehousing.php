<?php

require_once('config/config.php');

$app = new \MyApp\Warehousing();

$thisYear = date("Y");

$title = '入庫登録画面';
$today = date("Y-m-d");
$data = $app->threeDay();



?>
<?php include('template/header.php'); ?>


<body>
	<?php include('template/navber.php'); ?>
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
	<div class="container mt-3">
		<div class="row">
			<div class="col-sm-7">
				<div class="page-header">
					<div class="btn-group" role="group">
						<a href="warehousing.php" class="btn btn-sm btn-primary" disabled>入庫</a>
						<a href="proceeds.php" class="btn btn-sm btn-outline-primary">出庫</a>
						<a href="returned.php" class="btn btn-sm btn-outline-primary">返品</a>
					</div>
				  <h1>入庫入力画面 <i class="bi bi-arrow-right" style="font-size: 3rem; color: cornflowerblue;"></i><i class="bi bi-shop-window" style="font-size: 3rem; color: cornflowerblue;"></i></h1>
				</div>
				<div class="p-5 mb-4 bg-light">
					<div class="row justify-content-center">
						<div class="col-auto">
							売上日:
						</div>
						<div class="col-auto">
							<input type="date" class="form-control" id="inputDate" name="date" placeholder="日付を入力" value="<?= h($today); ?>">
						</div>
						<div class="col-auto">
							<button class="btn btn-sm btn-primary" id="today">本日</button>
						</div>
					</div>
				</div>

				<div class="form-group row justify-content-center mb-5">
					<label for="inputJan" class="col-sm-3 text-right">JANコード入力</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="inputJan" name="jan" placeholder="JANコード(半角英数字)">
					</div>
				</div>

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
				<h3>3日分のデ－タ(入庫)</h3>
				<table class="table table-sm">
					<thead>
						<tr>
							<th>日付</th>
							<th>商品名(現在庫数)</th>
							<th>入庫数</th>
							<th clas="text-right">入値</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="subClumnTable">
					<?php foreach($data as $d): ?>
						<tr data-id="<?= h($d->mainId); ?>" id="warehousingId_<?= h($d->mainId); ?>" data-otc-id="<?= h($d->otc_id); ?>">
							<td><?= h(date('m/d', strtotime($d->date))); ?></td>
							<td>
								<a href="inout.php?id=<?= h($d->otc_id); ?>">
									<?= h($d->name); ?>
								</a>(<?= h($d->stock_nums); ?>)
							</td>
							<td><?= h($d->enter_nums); ?></td>
							<td><?= h($d->actual_price); ?></td>
							<td>
								<span class="editSubRow">[編集]</span>
								<span class="deleteSubRow">[削除]</span>
							</td>
						</tr>
					<?php endforeach; ?>

					</tbody>
				</table>
			</div>

		</div>

		<!-- Modal -->
		<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">検索結果</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<table class="table table-hover">
							<thead>
								<th>ID</th>
								<th>名前</th>
								<th>入値</th>
								<th>入庫数</th>
								<th></th>
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
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">

						<div id="yearInput">
							<?php for($i=0; $i<6; $i++): ?>
								<input type="radio" class="btn-check" name="limit_year" id="year_<?= h($i); ?>" autocomplete="off" value="<?= h($thisYear+$i); ?>">
								<label class="btn btn-success btn-sm" for="year_<?= h($i); ?>"><?= h($thisYear+$i); ?>年</label>
							<?php endfor; ?>
							<br><br>
							<input type="radio" class="btn-check" name="limit_year" id="year_none" autocomplete="off" value="null">
							<label class="btn btn-outline-success btn-sm" for="year_none">期限なし</label>

						</div>
						<hr>
						<div id="monthInput">
							<?php for($i=1; $i<=12; $i++): ?>
								<input type="radio" class="btn-check" name="limit_month" id="month_<?= h($i); ?>" autocomplete="off" value="<?= h($i); ?>">
								<label class="btn btn-primary mb-2 btn-sm" for="month_<?= h($i); ?>"><?= h($i); ?>月</label>
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

<script>
$(function(){
	let isEdit = false;
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
			url: 'warehousing',
			jan: jan,
			mode: "search"
		}, function(res){
			if(res){
				$('#subTable').empty();
				$('#searchModal').modal('show');
				let s = '<tr id="otc_id_'+res['id']+'" data-id="'+res['id']+'">'+
								'<td>' + res['id'] + '</td>' +
								'<td>' + res['name'] + '</td>' +
								'<td><input type="text" class="text-right" name="price" style="width:80px;" value="' + res['purchase_price'] + '"></td>'+
								'<td><input type="number" value="1" class="inputNums text-right" name="nums" style="width:60px;">個</td>'+
								'<td class="inputLimit">[期限入力]</td>'
								'</tr>';
				$("#subTable").append(s);
			} else {
				let s = '<tr>'+
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
		$('#limitModal').modal('show');
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
		let otc_id = $('#searchModal #subTable tr').data('id');
		let name = $('#searchModal #subTable tr').children('td:eq(1)').text();
		let price = $('#searchModal #subTable tr').children('td:eq(2)').children('input').val();
		let nums = $('#searchModal #subTable tr').children('td:eq(3)').children('input').val();

		let s = '<tr>'+
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
		let year = $('#yearInput input[name=limit_year]:checked').val();
		let month = $('#monthInput input[name=limit_month]:checked').val();
		$.post('_serch_last_day.php',{
			year: year,
			month: month
		},function(res){
			$('#dayInput').empty();
			for(let i=1; i<=res; i++){
				let s = '<input type="radio" class="btn-check" name="limit_day" id="day_'+i+'" autocomplete="off" value="'+i+'"><label class="btn btn-danger btn-sm mb-2 me-1" for="day_'+i+'">'+i+'日</label>';
				$('#dayInput').append(s);
			}
			let s = '<br><br><input type="radio" class="btn-check" name="limit_day" id="day_none" autocomplete="off" value="'+res+'"><label class="btn btn-outline-danger btn-sm" for="day_'+res+'">指定なし</label>';
			$('#dayInput').append(s);
			$('#dayInput').show(300);
		});
	});

	$('#dayInput').on('click', 'input[name=limit_day]', function(){
		let otc_id = $('#searchModal #subTable tr').data('id');
		let name = $('#searchModal #subTable tr').children('td:eq(1)').text();
		let price = $('#searchModal #subTable tr').children('td:eq(2)').children('input').val();
		let nums = $('#searchModal #subTable tr').children('td:eq(3)').children('input').val();

		let year = $('#yearInput input[name=limit_year]:checked').val();
		let month = $('#monthInput input[name=limit_month]:checked').val();
		let day = $('#dayInput input[name=limit_day]:checked').val();

		$('#searchModal').modal('toggle');
		$('#limitModal').modal('toggle');

		let s = '<tr>'+
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
			let cnt = $('tbody#tb').children().length;
			if(cnt===0) $('tfoot').hide();
		});
	});

	$('#tb').on('click', '.registRow', function(){
		let jan = $('#noJan').text();
		let url = "new_otc.php?jan="+jan;
		window.open(url, '_blank');
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
			let price = $tr.children('td:eq(2)').text();
			let nums = $tr.children('td:eq(3)').text();
			let limit;
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
		for(let i=0; data.length>i; i++){
			let limit = data[i][4];
			let ymd = data[i][3];
			let nums = data[i][2];
			let id = data[i][0];

			$.post('_ajax.php', {
				url: 'warehousing',
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
				let e = $(
					'<tr>'+
					'<td>'+ ymd.substr(5,9)+ '</td>'+
					'<td><a href="inout.php?id='+ id +'">'+ res.name+ '</a>('+ res.stock_nums+')</td>'+
					'<td>'+ nums+ '</td>'+
					'<td>'+ res.purchase_price+ '</td>'+
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
		let day = $.trim($(this).parent('td').parent('tr').children('td:eq(0)').text());
		let name = $.trim($(this).parent('td').parent('tr').children('td:eq(1)').text());
		let nums = $.trim($(this).parent('td').parent('tr').children('td:eq(2)').text());
		let id = $(this).parent('td').parent('tr').data('id');
		let otc_id = $(this).parent('td').parent('tr').data('otc-id');
		if(confirm(day+'「'+name+'」 '+nums+'個\n削除してもよろしいですか')){
			$.post('_ajax.php', {
				url: 'warehousing',
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
		let btn = $('<button class="btn-primary btn btn-sm editedSubRow"></button>').text('変更');
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
			let $td = $this.parent('td');
			$td.empty();
			$td.append(new_price);
			$td.next('td').children('span:eq(0)').addClass('editSubRow');
			isEdit = false;

			return false;
		}

		console.log(id);
		console.log(otc_id);
		console.log(old_price);
		console.log(new_price);
		return false;

		$.post('_ajax.php', {
			url: 'warehousing',
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
