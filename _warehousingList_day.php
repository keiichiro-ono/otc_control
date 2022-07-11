<?php

require_once('config/config.php');

$app = new \MyApp\Warehousing_list();
$data = $app->getWarehousingOnDate();
$sum = $app->getPriceSum();

?>
<table class="table table-condensed">
  <tr>
    <!-- <th>時間</th> -->
    <!-- <th>写真</th> -->
    <th>名前</th>
    <th>仕入れ先</th>
    <th>単価</th>
    <th>個数</th>
    <th>合計</th>
  </tr>
  <?php foreach($data as $d): ?>
  <tr>
    <!-- <td><?= h(substr($d->created, -8)); ?></td> -->
  <!-- <?php if($d->img): ?>
    <td><img src="img/<?= h($d->img); ?>" class="img-thumbnail"></td>
  <?php else: ?>
    <td>
      <span class="fa-stack fa-lg">
        <i class="fa fa-camera fa-stack-1x"></i>
        <i class="fa fa-ban fa-stack-2x text-danger"></i>
      </span>
    </td>
  <?php endif; ?> -->
    <td><?= h($d->name); ?></td>
    <td><?= h($app->getWholesaleName($d->wholesale)); ?></td>
    <td class="text-right">
      <?= h(number_format($d->actual_price, 0)); ?>円
    </td>
    <td class="text-right">
      <?= h($d->enter_nums); ?>
    </td>
    <td class="text-right">
      <?= h(number_format($d->actual_price*$d->enter_nums)); ?>円
    </td>
  </tr>
  <?php endforeach; ?>
  <tfoot>
    <tr>
      <th colspan="4" class="text-right">合計</th>
      <th class="text-right"><?= h(number_format($sum)); ?>円</th>
    </tr>
  </tfoot>
</table>
