<?php

require_once('config/config.php');

$app = new \MyApp\Sales_calendar();

//timeStamp取得
$ym = isset($_GET['ym']) ? $_GET['ym'] : date("Ym");

$timeStamp = strtotime($ym. "01");
if($timeStamp === false){
	$timeStamp = time();
	$ym = date("Y",$timeStamp).date("m",$timeStamp);
}
$prev = date("Ym", mktime(0,0,0,date('m',$timeStamp)-1,1,date('Y',$timeStamp)));
$next = date("Ym", mktime(0,0,0,date('m',$timeStamp)+1,1,date('Y',$timeStamp)));


//DBから取得

$yearMonth = substr($ym, 0, 4).'-'. substr($ym, 4, 2);
$ymWa = substr($yearMonth, 0, 4).'年'.substr($yearMonth, 5, 2).'月';

//カレンダー作成
$lastDay = date("t", $timeStamp);
$youbi = date("w", mktime(0,0,0,date('m',$timeStamp),1,date('Y',$timeStamp)));

$title = '月間売上';

?>

<?php include('template/header.php'); ?>
<body>
	<?php include('template/navber.php'); ?>
	<style>
    .youbi_0{
      color: red;
    }
    .youbi_6{
      color: blue;
    }
		.youbi_tr_0{
			background-color: #FCC
		}
		th, td{
			text-align: center;
		}
		table#calen>tbody#mainTable>tr td:nth-child(2):hover,td:nth-child(3):hover,td:nth-child(4):hover {
			background-color: orange;
			cursor: pointer;
		}
	</style>
	<div class="container mt-3">
		<h1>売上一覧 <i class="bi bi-currency-yen" style="font-size: 3rem; color: cornflowerblue;"></i></h1>
		<div class="row">
			<div class="col-sm-6">
				<table class="table table-sm table-hover" id="calen">
					<thead>
						<tr>
							<th>
								<a href="?ym=<?= h($prev); ?>" class="btn btn-success btn-sm">&lt;</a>
							</th>
							<th colspan="3" class="text-center">
								<?= h(substr($ym,0,4)."年".substr($ym,4,2)."月"); ?>
							</th>
							<th>
								<a href="?ym=<?= h($next); ?>" class="btn btn-success btn-sm">&gt;</a>
							</th>
						</tr>
						<tr>
							<th>日付</th>
							<th>入金（販売）</th>
							<th>入金（返品）</th>
							<th>支出（仕入れ）</th>
							<th>小計</th>
						</tr>
					</thead>
					<tbody id="mainTable">
						<?php
							$totalSale=0;
							$totalReturned=0;
							$totalWare=0;
							$totalWare=0;
							$totalSum=0;
							for($i=0; $i<$lastDay; $i++,$youbi++):
							$k = $i+1;
							$j = $k<10 ? "0".$k : $k;
						?>
							<tr class="youbi_tr_<?= h($youbi%7); ?>" data-ymd="<?= h($yearMonth."-".$j); ?>">
								<td class="youbi_<?= h($youbi%7); ?>"><?= h($i+1); ?>日</td>
								<td class="text-right" data-status="sale">
									<?php
										$sale = $app->getSale($yearMonth."-".$j);
										$totalSale += $sale;
										echo h(number_format($sale, 0));
									?>円
								</td>
								<td class="text-right" data-status="returned">
									<?php
										$return = $app->getReturn($yearMonth."-".$j);
										$totalReturned += $return;
										echo h(number_format($return, 0));
									?>円
								</td>
								<td class="text-right" data-status="warehousing">
									<?php
										$ware = $app->getWarehousing($yearMonth."-".$j);
										$totalWare += $ware;
										echo h(number_format($ware, 0));
									?>円
								</td>
								<td class="text-right">
									<?php
										$total = $sale+$return-$ware;
										$totalSum += $total;
										echo h(number_format($total, 0))
									?>円
								</td>
							</tr>

						<?php endfor; ?>

					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th class="text-end"><?= h(number_format($totalSale, 0)); ?>円</th>
							<th class="text-end"><?= h(number_format($totalReturned, 0)); ?>円</th>
							<th class="text-end"><?= h(number_format($totalWare, 0)); ?>円</th>
							<th class="text-end"><?= h(number_format($totalSum, 0)); ?>円</th>
						</tr>
					</tfoot>
				</table>

			</div>
			<div class="col-sm-6">
				<div class="p-3 mb-4 bg-light">
					<table class="table table-sm">
					<h3 id="status">販売一覧</h3>
						<h5 class="display-6" id="dayTitle"><?= h(date("Y"."年"."m"."月"."d"."日")); ?></h4>
						<thead>
							<tr>
								<th>商品名</th>
								<th>個数</th>
								<th>単価</th>
								<th id="status_th">売上</th>
							</tr>
						</thead>
						<tbody id="dailySales">

						</tbody>
					</table>
				</div>
			</div>
		</div>

  </div>


  <?php include('template/footer.php'); ?>



<script>
$(function(){
	$('table#calen tbody tr td').click(function(){
		var d = $(this).parent().data('ymd');
		d+="";
		var e = d.substr(0,4)+"年"+d.substr(5,2)+"月"+d.substr(8,2)+"日";
		$('#dayTitle').text(e);
		$('#dailySales').empty();

		switch($(this).data('status')){
			case 'sale':
				$.get('calendarSub.php?date='+d.substr(0,4)+d.substr(5,2)+d.substr(8,2))
					.done(function(data){
						$('#dailySales').append(data);
						$('#status').text("販売一覧");
						$('#status_th').text("売上");
				})
				break;
			case 'returned':
				$.get('calendarSub_returned.php?date='+d.substr(0,4)+d.substr(5,2)+d.substr(8,2))
					.done(function(data){
					$('#dailySales').append(data);
				})
				$('#status').text("返品一覧");
				$('#status_th').text("返品");
				break;
			case 'warehousing':
				$.get('calendarSub_warehousing.php?date='+d.substr(0,4)+d.substr(5,2)+d.substr(8,2))
					.done(function(data){
					$('#dailySales').append(data);
				})
				$('#status').text("仕入れ一覧");
				$('#status_th').text("仕入れ");
				break;
			default:
				break;

		}
	});

	var today = new Date();
	var d = today.getFullYear()+'年'+(today.getMonth()+1)+'月'+today.getDate()+'日';
	$('#dayTitle').text(d);
	$.get('calendarSub.php?date='+today.getFullYear()+(today.getMonth()+1)+today.getDate())
		.done(function(data){
			$('#dailySales').append(data);
		});



});
</script>

</body>
</html>
