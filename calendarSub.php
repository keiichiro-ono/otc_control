<?php

require_once('config/config.php');

$app = new \MyApp\Calendar();

$data = $app->getProceeds($_GET['date']);
$daySum = $app->getSum($_GET['date']);

?>
		<?php foreach($data as $d): ?>
			<tr>
				<td class="text-left">
					<a href="inout.php?id=<?= h($d->otc_id); ?>">
						<?= h($d->name); ?>
					</a>
				</td>
				<td class="text-right"><?= h($d->nums); ?>個</td>
				<td class="text-right"><?= h(number_format($d->actual_price,0)); ?>円</td>
				<td class="text-right"><?= h(number_format($d->actual_price*$d->nums,0)); ?>円</td>
			</tr>
    <?php endforeach; ?>
			<tr>
				<td colspan="4">
					合計：<?= h(number_format($daySum, 0));?>円
				</td>
			</tr>
