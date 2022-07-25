<?php

require_once('config/config.php');

$app = new \MyApp\Proceeds();

$title = '出庫登録画面';
$today = date("Y-m-d");
$data = $app->threeDay();

?>
<?php include('template/header.php'); ?>
<style>
	table#mainTable>tbody#tb>tr>td.delete, td.deleteSubRow{
		color: red;
		cursor: pointer!important;
	}
</style>


<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="row my-4">
			<div class="col-sm-7">
				<div class="page-header">
					<div class="btn-group" role="group">
						<a href="warehousing.php" class="btn btn-sm btn-outline-primary">入庫</a>
						<a href="proceeds.php" class="btn btn-sm btn-primary" disabled>出庫</a>
						<a href="returned.php" class="btn btn-sm btn-outline-primary">返品</a>
					</div>
				  <h1>売上登録画面 <i class="bi bi-arrow-right" style="font-size: 3rem; color: cornflowerblue;"></i><i class="bi bi-person-fill" style="font-size: 3rem; color: cornflowerblue;"></i></h1>
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
							<button class="btn btn-primary btn-sm" id="today">本日</button>
						</div>
					</div>
				</div>

				<div class="form-group row justify-content-center mb-5">
					<label for="search" class="col-sm-3 text-end">商品検索</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="search" name="search" placeholder="かなを入力してください">
					</div>
					<div class="col-sm-4">
						<button class="btn btn-warning rounded-pill px-4" id="searchBtn">Search!</button>
					</div>
				</div>

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
							<td colspan="4"></td>
							<td colspan="2" class="text-end">
								<button id="inputDb" class="btn btn-success">DBへ登録</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-sm-5">
				<h3>3日分のデ－タ(販売記録)</h3>
				<table class="table table-sm">
					<thead>
						<tr>
							<th>日付</th>
							<th>商品名</th>
							<th>数量</th>
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
							<td><?= h($d->nums); ?></td>
							<td class="deleteSubRow">[削除]</td>
						</tr>
					<?php endforeach; ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">検索結果</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
<?php include('template/footer.php'); ?>





<script>
$(function(){

	$('#mainTable tfoot').hide();

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

	$("#searchBtn").click(function(){
		if( $("#inputDate").val() == "" ){
			alert("日付が入力されていません");
			$("#inputDate").focus();
			return false;
		}

		$.post("_ajax.php",{
			url: 'proceeds',
			mode: 'search',
			word: $.trim( $("#search").val() )
		}, function(res){
			if(res){
				$('#subTable').empty();
				$('#searchModal').modal('show');
				for(let i=0; i<res.length; i++){
					let stock = (res[i].stock_nums<=0) ? 'danger' : 'default';
					let e = $(
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
		let id = $(this).data('id');
		$.post('_ajax.php', {
			url: 'proceeds',
			mode: 'choice',
			id: id
		}, function(res){
			$('#searchModal').modal('toggle');
			let e = $(
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
			$("#mainTable tfoot").show();
		});
	});

	$("#search").keypress(function(e){
		if(e.which == 13){
			$("#searchBtn").click();
		}
	});

	$("#mainTable").on('click', '.delete>button', function(){
		if($("#mainTable").children('tbody').children('tr').length==1){
			$("#mainTable tfoot").hide(800);
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
					let $tr = $(this);
					let id = $tr.children('td:eq(0)').text();
					let actual_price = $tr.children('td').children('input:eq(0)').val();
					let nums = $tr.children('td').children('input:eq(1)').val();
					let ymd = $("#inputDate").val();
					$.post('_ajax.php', {
						url: 'proceeds',
						mode: 'dbInsert',
						id: id,
						actual_price: actual_price,
						nums: nums,
						ymd: ymd
					}, function(res){
						$tr.fadeOut(800, function(){
							$(this).remove();
						});
						let e = $(
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
				$("#mainTable tfoot").hide(800);
			} else {
				alert('数量に0以下の数値が入力されています。');
			}
		} else {
			alert('データなし');
		}
	});

	function checkNum(){
		let a = 0;
		$("#tb").children('tr').each(function(){
			let num = $(this).children('td').children('input').val();
			if(num<=0) a++;
		});
		return a==0 ? true : false;
	}

	$("#subClumnTable").on('click', '.deleteSubRow', function(){
		let day = $.trim($(this).parent('tr').children('td:eq(0)').text());
		let name = $.trim($(this).parent('tr').children('td:eq(1)').text());
		let nums = $.trim($(this).parent('tr').children('td:eq(2)').text());
		let id = $(this).parent('tr').data('id');
		let otc_id = $(this).parent('tr').data('otc-id');
		if(confirm(day+'「'+name+'」 '+nums+'個\n削除してもよろしいですか')){
			$.post('_ajax.php', {
				url: 'proceeds',
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
