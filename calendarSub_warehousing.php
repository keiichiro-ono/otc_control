<?php

require_once('config/config.php');

$app = new \MyApp\Calendar();

$data = $app->getWarehousing($_GET['date']);
$daySum = $app->getSumWarehousing($_GET['date']);

?>
		<?php foreach($data as $d): ?>
			<tr>
				<td class="text-start">
					<a href="inout.php?id=<?= h($d->otc_id); ?>">
						<?= h($d->name); ?>
					</a>
				</td>
				<td class="text-end"><?= h($d->enter_nums); ?>個</td>
				<td class="text-end"><?= h(number_format($d->actual_price,0)); ?>円</td>
				<td class="text-end"><?= h(number_format($d->actual_price*$d->enter_nums,0)); ?>円</td>
			</tr>
    <?php endforeach; ?>
			<tr>
				<td colspan="4">
					合計：<?= h($daySum ? number_format($daySum, 0): 0);?>円
				</td>
			</tr>
