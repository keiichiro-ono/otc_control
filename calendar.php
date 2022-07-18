<?php

require_once('config/config.php');

$app = new \MyApp\Calendar();

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
$days = $app->getSaleDate($yearMonth);
$saleData = $app->getSaleData($yearMonth);
$salePrice = $app->getSalePrice($yearMonth);

//カレンダー作成
$lastDay = date("t", $timeStamp);
$youbi = date("w", mktime(0,0,0,date('m',$timeStamp),1,date('Y',$timeStamp)));

$weeks = array();
$week = '';

$week .= str_repeat('<td></td>', $youbi);

$includeDay = array();

foreach($days as $day){
	array_push($includeDay, mb_substr($day->date, -2));
}

for($day=1; $day<=$lastDay; $day++, $youbi++){
	$d = $day<10 ? "0".$day : $day;
	if(in_array($day, $includeDay)){
		if($ym.$d==date('Ymd', time())){
			$week .= sprintf('<td class="youbi_%d on today" data-date="'.$ym.$d.'">%d</td>', $youbi%7, $day);
		} else {
			$week .= sprintf('<td class="youbi_%d on" data-date="'.$ym.$d.'">%d</td>', $youbi%7, $day);
		}
	} else {
		if($ym.$d==date('Ymd', time())){
			$week .= sprintf('<td class="youbi_%d today">%d</td>', $youbi%7, $day);
		} else {
			$week .= sprintf('<td class="youbi_%d">%d</td>', $youbi%7, $day);
		}
	}

	if($youbi%7 == 6 OR $day == $lastDay){
		if($day == $lastDay){
			$week .= str_repeat('<td></td>', 6-($youbi%7));
		}

		$weeks[] = '<tr>' .$week. '</tr>';
		$week = '';
	}
}

$title = '売上カレンダー';



?>
<?php include('template/header.php'); ?>

	<style>
    .youbi_0{
      color: red;
    }
    .youbi_7{
      color: blue;
    }
    .on {
      background-color: orange!important;
      font-weight: bold;
			cursor: pointer;
    }
		.today{
			font-weight: bold;
			font-size: 18px;
		}
		th, td{
			text-align: center;
		}
	</style>
<body>
	<?php include('template/navber.php'); ?>
	<div class="container mt-3">
		<h1>販売一覧 <i class="bi bi-calendar-week" style="font-size: 3rem; color: cornflowerblue;"></i></h1>

		<div class="row">
			<div class="col-sm-6">
				<table class="table" id="calen">
					<thead>
						<tr>
							<th>
								<a href="?ym=<?= h($prev); ?>" class="btn btn-success btn-sm">&lt;</a>
							</th>
							<th colspan="5" class="text-center">
								<?= h($ymWa); ?>
							</th>
							<th>
								<a href="?ym=<?= h($next); ?>" class="btn btn-success btn-sm">&gt;</a>
							</th>
							</tr>
							<tr>
							<th class="youbi_0">日</th>
							<th>月</th>
							<th>火</th>
							<th>水</th>
							<th>木</th>
							<th>金</th>
							<th class="youbi_7">土</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($weeks as $week): ?>
						<?= $week; ?>
					<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="7" class="text-center">
								<a href="calendar.php" class="btn btn-warning">Today</a>
							</th>
						</tr>
					</tfoot>
				</table>

				<div class="p-3 mb-4 bg-light">
					<h4 class="display-6 text-center" id="dayTitle"><?= h(date("Y"."年"."m"."月"."d"."日")); ?></h4>
					<table class="table table-sm">
						<thead>
							<tr>
								<th>商品名</th>
								<th>個数</th>
								<th>単価</th>
								<th>売上</th>
							</tr>
						</thead>
						<tbody id="dailySales">

						</tbody>
					</table>
				</div>
			</div>

			<div class="col-sm-6">
				<h3>
					<?= h($ymWa); ?> 売上品一覧<br>
					<small>売上合計：<?= h(number_format($salePrice,0)); ?>円</small>
				</h3>

				<table class="table table-sm">
					<tr>
						<th>名前</th>
						<th>個数</th>
						<th>売上</th>
					</tr>
				<?php foreach ($saleData as $data): ?>
					<tr>
						<td class="text-start">
							<a href="inout.php?id=<?= h($data->otc_id); ?>">
								<?= h($data->name); ?>
							</a>
						</td>
						<td class="text-end"><?= h($data->totalNums); ?></td>
						<td class="text-end"><?= h(number_format($data->totalPrice, 0)); ?>円</td>
					</tr>
				<?php endforeach; ?>
				</table>
			</div>
		</div>

  	</div>




<?php include('template/footer.php'); ?>

<script>
$(function(){
	$('table#calen tbody td.on').click(function(){
		var d = $(this).data('date');
		d+="";
		var e = d.substr(0,4)+"年"+d.substr(4,2)+"月"+d.substr(6,2)+"日";
		$('#dayTitle').text(e);
		$('#dailySales').empty();
		$.get('calendarSub.php?date='+d)
			.done(function(data){
				$('#dailySales').append(data);
			})
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
