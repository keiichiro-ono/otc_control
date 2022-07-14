<?php

require_once('config/config.php');

$app = new \MyApp\Proceeds();
$data = $app->threeDay();
// var_dump($data);exit;
?>

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