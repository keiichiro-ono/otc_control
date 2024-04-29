<?php

require_once('config/config.php');

$app = new \MyApp\Otc48_list();

$otc_cat_list = [
	['精神神経用薬', 'かぜ薬（内用）'],
	['精神神経用薬', '解熱鎮痛薬'],
	['精神神経用薬', '催眠鎮静薬'],
	['精神神経用薬', '眠気防止薬'],
	['精神神経用薬', '鎮うん薬（乗物酔防止薬、つわり用薬を含む。）'],
	['精神神経用薬', '小児鎮静薬（小児五疳薬等）'],
	['精神神経用薬', 'その他の精神神経用薬'],
	['消化器官用薬', 'ヒスタミンＨ２受容体拮抗剤含有薬'],
	['消化器官用薬', '制酸薬'],
	['消化器官用薬', '健胃薬'],
	['消化器官用薬', '整腸薬'],
	['消化器官用薬', '制酸・健胃・消化・整腸を２以上標榜するもの'],
	['消化器官用薬', '胃腸鎮痛鎮けい薬'],
	['消化器官用薬', '止瀉薬'],
	['消化器官用薬', '瀉下薬（下剤）'],
	['消化器官用薬', '浣腸薬'],
	['循環器・血液用薬', '強心薬（センソ含有製剤等）'],
	['循環器・血液用薬', '動脈硬化用薬（リノール酸、レシチン主薬製剤等）'],
	['循環器・血液用薬', 'その他の循環器・血液用薬'],
	['呼吸器官用薬', '鎮咳去痰薬'],
	['呼吸器官用薬', '含嗽薬'],
	['泌尿生殖器官及び肛門用薬', '内用痔疾用剤、外用痔疾用剤'],
	['泌尿生殖器官及び肛門用薬', 'その他の泌尿生殖器官及び肛門用薬'],
	['滋養強壮保健薬', 'ビタミン主薬製剤等'],
	['滋養強壮保健薬', 'その他の滋養強壮保健薬'],
	['女性用薬', '婦人薬'],
	['女性用薬', 'その他の女性用薬'],
	['アレルギー用薬', '抗ヒスタミン薬主薬製剤'],
	['アレルギー用薬', 'その他のアレルギー用薬'],
	['外皮用薬', '殺菌消毒薬（特殊絆創膏を含む）'],
	['外皮用薬', 'しもやけ・あかぎれ用薬'],
	['外皮用薬', '化膿性疾患用薬'],
	['外皮用薬', '鎮痛・鎮痒・収れん・消炎薬（パップ剤を含む）'],
	['外皮用薬', 'みずむし・たむし用薬'],
	['外皮用薬', '皮膚軟化薬（吸出しを含む）'],
	['外皮用薬', '毛髪用薬（発毛、養毛、ふけ、かゆみ止め用薬等）'],
	['外皮用薬', 'その他の外皮用薬'],
	['眼科用薬', '一般点眼薬、人工涙液、洗眼薬'],
	['眼科用薬', '抗菌性点眼薬'],
	['眼科用薬', 'アレルギー用点眼薬'],
	['耳鼻科用薬', '鼻炎用内服薬、鼻炎用点鼻薬'],
	['歯科口腔用薬', '口腔咽喉薬（せき、たんを標榜しないトローチ剤を含む）'],
	['歯科口腔用薬', '口内炎用薬'],
	['歯科口腔用薬', '歯痛・歯槽膿漏薬'],
	['禁煙補助剤', '禁煙補助剤'],
	['漢方製剤', '漢方製剤等'],
	['公衆衛生用薬', '消毒薬'],
	['公衆衛生用薬', '殺虫薬']
];


if(isset($_GET['id']) && !empty($_GET['id'])){
	$id = (int)$_GET['id'];
	$items = $app->get_items($id);
	// var_dump($items);
	$title = '【'. $otc_cat_list[$id][0].'】';

} elseif(isset($_GET['edit']) && !empty($_GET['edit'])) {
	$title = 'カテゴリー一括編集';
} else {
	$title = 'otc48一覧';
}

$medItems = $app->get_med_items();
// var_dump($medItems);exit;






?>

<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">

		<?php if(isset($_GET['id']) && !empty($_GET['id'])): ?>
			<p class="text-end m-0">
				<a href="otc48_list.php">OTC48一覧へ戻る</a>
			</p>
			<p class="text-end m-0">
				<a href="otc48_list.php?edit=on">一括編集</a>
			</p>
			<?php if(!$items): ?>
				まだ登録している医薬品がありません

			<?php else: ?>

				<h1 class="m-0">
					<small class="text-secondary">
						<?= h( $otc_cat_list[$id-1][0] ); ?>
					</small>
				</h1>
				<h1><?= h($otc_cat_list[$id-1][1]); ?></h1>
				<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>ID</th>
						<th>名前</th>
						<th>規格</th>
						<th>在庫数</th>
						<th>入値</th>
						<th>売値</th>
						<th>税込価格</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($items as $index => $item): ?>
						<tr>
							<td><?= h($index+1); ?></td>
							<td><?= h($item->mainId); ?></td>
							<td><?= h($item->name); ?></td>
							<td><?= h($item->size); ?></td>
							<td><?= h($item->stock_nums); ?>個</td>
							<td><?= h($item->purchase_price); ?>円</td>
							<td><?= h($item->selling_price); ?>円</td>
							<td><?= h($item->tax_include_price); ?>円</td>
							<td>
								<a href="inout.php?id=<?= h($item->mainId); ?>">[詳細]</a>
							</td>
						</tr>

					<?php endforeach; ?>
				</tbody>

			</table>

			<?php endif; ?>

		<?php elseif(!isset($_GET['id']) && !isset($_GET['edit'])): ?>
			<div class="row">
				<p class="text-end m-0">
					<a href="otc48_list.php?edit=on">一括編集</a>
				</p>

			<?php foreach($otc_cat_list as $index=>$list): ?>

				<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-3">
					<div class="card">
						<?php if( $app->check_stock($index+1) > 0 ): ?>
							<div class="card-body bg-success text-white">
						<?php else: ?>
							<div class="card-body bg-warning text-danger">
						<?php endif; ?>
								<p class="m-0"><small>
									<?= h($list[0]); ?>
								</small></p>
								<h5 class="card-title">
									<?= $index+1; ?>
									<?= h($list[1]); ?>
								</h5>
								<p class="text-end m-0 p-0">
									<a href="?id=<?= h($index+1); ?>" class="btn btn-light btn-sm">詳細</a>
								</p>
							</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>


		<!-- 入力用のみ -->
		<?php if(isset($_GET['edit']) && !empty($_GET['edit'])) : ?>
			<?php if($_GET['edit']=="on"): ?>
				<p class="text-end m-0">
					<a href="otc48_list.php">OTC48一覧へ戻る</a>
				</p>
				<p class="m-0">
					<button id="allItems" class="btn btn-primary btn-sm" disabled>全件表示</button>
					<button id="extractItems" class="btn btn-primary btn-sm">未入力のみ表示</button>
				</p>

				<h1>OTC48用カテゴリー一括編集</h1>
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th>ID</th>
							<th>class</th>
							<th>名前</th>
							<th>規格</th>
							<th>在庫数</th>
							<th>製品分類No.</th>
						</tr>
					</thead>
					<tbody id="editTable">
					<?php foreach($medItems as $idx => $med): ?>
						<tr data-otc-id="<?= h($med->mId); ?>">
							<td><?= h($idx+1); ?></td>
							<td><?= h($med->mId); ?></td>
							<td><?= h($med->class_name); ?></td>
							<td><?= h($med->name); ?></td>
							<td><?= h($med->size); ?></td>
							<td><?= h($med->stock_nums); ?></td>
							<td>
								<input type="text" class="form-control cat_input" value="<?= h($med->category_id); ?>" <?= ($med->category_id) ? "disabled" : ""; ?>>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		<?php endif; ?>

		

	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>

<script>
$(function(){
	$(".cat_input").on('keypress', function(e) {
		$this = $(this);
		if (e.which == 13) {
			let nbr = $(this).val();
			let otc_id = $(this).parent('td').parent('tr').data('otc-id');
			if(!isNaN(nbr) && nbr>0 && nbr<86){
				$.post('_ajax.php', {
					"url": "otc48_list",
					"mode": "update_cat_id",
					"otc_id": otc_id,
					"cat_id": nbr
				}, function(res){
					$this.prop('disabled', true);
					$this.parent('td').parent('tr').next('tr').children('td').children('input').focus();
				});
			} else {
				alert("入力は数値で「1～85」となっています");
				$(this).select();
				$(this).focus();
			}
			return false;
		}
	});
	$('.cat_input').on('');

	$('#extractItems').click(function(){
		$('#editTable').children('tr').each(function(){
			let num = $(this).children('td').children('input').val();
			if(num>0 && num<86){
				$(this).fadeOut(800);
				$('#allItems').prop('disabled', false)
				$('#extractItems').prop('disabled', true)
			}
		});
	});

	$('#allItems').click(function(){
		$('#editTable').children('tr').each(function(){
			$(this).fadeIn(800);
			$('#allItems').prop('disabled', true)
			$('#extractItems').prop('disabled', false)

		});
	});

});
</script>

</body>
</html>
