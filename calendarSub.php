<?php

require_once('config/config.php');

$app = new \MyApp\Calendar();

$data = $app->getProceeds($_GET['date']);
$daySum = $app->getSum($_GET['date']);

?>
		<?php foreach($data as $d): ?>
			<tr>
				<td class="text-start">
					<a href="inout.php?id=<?= h($d->otc_id); ?>">
						<?= h($d->name); ?>
					</a>
				</td>
				<td class="text-end"><?= h($d->nums); ?>個</td>
				<td class="text-end"><?= $d->actual_price ? h(number_format($d->actual_price,0)): ''; ?>円</td>
				<td class="text-end"><?= $d->actual_price ? h(number_format($d->actual_price*$d->nums,0)): ''; ?>円</td>
			</tr>
    <?php endforeach; ?>
			<tr>
				<td colspan="4">
					合計：<?= $daySum ? h($daySum ? number_format($daySum, 0): 0): '';?>円
				</td>
			</tr>
