<?php

require_once('config/config.php');

$app = new \MyApp\Hygiene_list();

$items = $app->allItem();

$title = '衛生用品一覧';

?>

<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>


<div class="container mt-3">
		<div class="page-header">
			<h1>衛生用品一覧画面 <i class="bi bi-list-columns-reverse" style="font-size: 3rem; color: cornflowerblue;"></i></h1>
		</div>

			<table class="table table-hover table-sm">
				<thead>
					<tr>
						<th>ID</th>
						<th>名前</th>
						<th>サイズ</th>
						<th class="text-center" data-name="jan">JAN</th>
						<th class="text-center" data-name="wholesale">取引卸</th>
						<th class="text-center">入値</th>
						<th class="text-center">売値</th>
						<th class="text-center">税込み価格</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($items as $item): ?>
					<tr>
						<td><?= h($item->mId); ?></td>
						<td><?= h($item->oname); ?></td>
						<td><?= h($item->size); ?></td>
						<td><?= h($item->jan); ?></td>
						<td><?= h($item->wname); ?></td>
						<td class="text-end"><?= h(number_format($item->purchase_price,0)); ?>円</td>
						<td class="text-end"><?= h(number_format($item->selling_price, 0)); ?>円</td>
						<td class="text-end"><?= h(number_format($item->tax_include_price, 0)); ?>円</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

		</div>
	</div>
  <!-- container -->
<script src="lib/js/jquery-3.2.1.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script>
$(function(){

});
</script>

</body>
</html>
