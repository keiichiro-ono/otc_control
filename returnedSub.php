<?php

require_once('config/config.php');

$app = new \MyApp\Returned();
$data = $app->threeDay();

?>

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
