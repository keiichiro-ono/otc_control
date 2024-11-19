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

$category = $app->getCat();

if(isset($_GET['edit']) && !empty($_GET['edit'])) {
	$title = 'カテゴリー一括編集';
} else {
	$title = 'otc48一覧';
}

$medItems = $app->get_med_items();

?>

<?php include('template/header.php'); ?>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<?php if(!isset($_GET['edit']) && empty($_GET['edit'])) : ?>

			<div class="row">
				<p class="text-end m-0">
					<a href="otc48_list.php?edit=on">一括編集</a>
				</p>

			<?php foreach($otc_cat_list as $index=>$list): ?>

				<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-3">
					<div class="card">
					<?php if( $app->check_stock($index+1) == 1 ): ?>
						<div class="card-body bg-info text-white">
					<?php elseif( $app->check_stock($index+1) < 1 ): ?>
						<div class="card-body bg-danger text-warning">
					<?php else: ?>
						<div class="card-body bg-primary text-white">
					<?php endif; ?>
							<p class="m-0"><small>
								<?= h($list[0]); ?>
							</small></p>
							<h5 class="card-title">
								<?= $index+1; ?>
								<?= h($list[1]); ?>
							</h5>
							<p class="text-end m-0 p-0">
								<!-- <a href="?id=<?= h($index+1); ?>" class="btn btn-light btn-sm">詳細</a> -->
								<button class="catDetail btn btn-light btn-sm"
									data-id="<?= h($index+1); ?>" data-cat-name="<?= h($list[0]); ?>" data-cat-detail="<?= h($list[1]); ?>">詳細</button>
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
						<tr id="<?= h($med->mId); ?>" data-otc-id="<?= h($med->mId); ?>" data-cat-id="<?= isset($med->category_id) ? h($med->category_id) : ''; ?>">
							<td><?= h($idx+1); ?></td>
							<td><?= h($med->mId); ?></td>
							<td><?= h($med->class_name); ?></td>
							<td>
								<a href="correct_otc.php?id=<?= h($med->mId); ?>">
									<?= h($med->name); ?>
								</a>
							</td>
							<td><?= h($med->size); ?></td>
							<td><?= h($med->stock_nums); ?></td>
							<td>
								<?php
									if(!isset($med->category_id) || $med->category_id==0){
										$cat_name = "";
										$subcat_name = "";
										$sn = "";
									} else {
										$cat = $app->get_category_id_to_name($med->category_id);
										$cat_name = $cat->cat_name;
										$subcat_name = $cat->subcat_name;
										$sn = $subcat_name. '('. $cat_name. ')';
									}
								?>
								<?php if($sn==''): ?>
									<button class="btn btn-sm btn-secondary cat_init_input">入力</button>
								<?php else: ?>
									<input type="text" class="form-control cat_input" value="<?= h($sn); ?>" <?= isset($med->category_id) ? "disabled" : ""; ?>>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="detailModalLabel1"></h1>
				<h1 class="modal-title fs-2 ms-3" id="detailModalLabel2"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class="table">
					<thead>
						<tr>
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
					<tbody id="detailModalTbody">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
			</div>
			</div>
		</div>
	</div>


	<!-- Modal2 -->
	<div class="modal fade" id="catInputModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="catInputModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="header_label_1"></h1>
					<h1 class="modal-title fs-2 ms-3" id="header_label_2"></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<select name="category_name" id="sele_category" class="form-select mb-4">
						<option id="samp" disabled selected>下から選んでください</option>
					<?php foreach($category as $row): ?>
						<option value="<?= h($row->cat_name); ?>"><?= h($row->cat_name); ?></option>
					<?php endforeach; ?>
					</select>
					
					<select name="subcategory_name" id="sele_subcategory" class="form-select">
						<option value="">aaa</option>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
					<button type="button" id="editCategory" class="btn btn-primary" data-bs-dismiss="modal">登録</button>
				</div>
			</div>
		</div>
	</div>


  <!-- container -->
  <?php include('template/footer.php'); ?>

<script>
$(function(){
	$('#editTable').on('click', '.cat_init_input', function(){
		$('#sele_subcategory').empty();
		$('#sele_subcategory').prop('disabled', true);

		let $tr = $(this).parent('td').parent('tr');
		let otc_id = $tr.data('otc-id');
		let otc_name = $tr.children('td:eq(3)').children('a').text();
		$('#header_label_1').text(otc_id);
		$('#header_label_2').text(otc_name);

		$('#samp').prop('selected', true);
		$('#catInputModal').modal('show');
	});

	$('#catInputModal').on('change', '#sele_category', function(){
		$('#sele_subcategory').empty();
		$('#sele_subcategory').prop('disabled', false);

		let cat_name = $('[name=category_name]').val();
		let otc_id = $('#header_label_1').text();
		$.post('_ajax.php', {
			'url': 'otc48_list',
			'mode': 'getSubCat',
			'cat_name': cat_name
		}, function(res){
			for(let i=0; i<res.length; i++){
				let $option = $('<option>').val(res[i]['id']).text(res[i]['subcat_name']);
				$('#sele_subcategory').append($option);
			}
		});
	});

	$('#editCategory').click(function(){
		let otc_id = $('#header_label_1').text()*1;
		let cat_id = $('[name=subcategory_name]').val()*1;
		if(!cat_id){
			alert('カテゴリーを選択していないので登録しません');
			return false;
		}

		$.post('_ajax.php', {
			'url': 'otc48_list',
			'mode': 'update_cat_id',
			'otc_id': otc_id,
			'cat_id': cat_id
		}, function(res){
			let $td = $('tr#'+otc_id).children('td:eq(6)');
			let cat_name = $('[name=category_name]').val();
			let subcat_name = $('[name=subcategory_name] option:selected').text();
			let $input = $('<input class="form-control" disabled>').val(subcat_name+'('+cat_name+')');
			$td.empty().append($input);
		});
	});



	$(".cat_input").on('keypress', function(e) {
		$this = $(this);
		if (e.which == 13) {
			let nbr = $(this).val();
			let otc_id = $(this).parent('td').parent('tr').data('otc-id');
			if(!isNaN(nbr) && nbr>0 && nbr<93){
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
				alert("入力は数値で「1～92」となっています");
				$(this).select();
				$(this).focus();
			}
			return false;
		}
	});

	$('#extractItems').click(function(){
		$('#editTable').children('tr').each(function(){
			let input_val = $(this).children('td:eq(6)').children('input').val();
			if(input_val){
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

	$('body').on('click', '.catDetail', function(){
		$('#detailModalTbody').empty();
		let id = $(this).data('id');
		let cat_name = $(this).data('cat-name');
		let cat_detail = $(this).data('cat-detail');
		$.post('_ajax.php', {
			"url": "otc48_list",
			"mode": "getCatMed",
			"id": id
		}, function(res){
			$('#detailModalLabel1').text(cat_name);
			$('#detailModalLabel2').text(id + ' ' + cat_detail);
			console.dir(res);
			for(let i=0; i<res.length; i++){
				let $tr;
				if(res[i]['stock_nums']<1){
					$tr = $('<tr class="table-secondary">');
				} else {
					$tr = $('<tr>');
				}
				let $td = $('<td>').text(res[i]['mainId']);
				$tr.append($td);
				$td = $('<td>').text(res[i]['name']);
				$tr.append($td);
				$td = $('<td class="text-center">').text(res[i]['size']);
				$tr.append($td);
				$td = $('<td class="text-center">').text(res[i]['stock_nums']+'個');
				$tr.append($td);
				$td = $('<td class="text-center">').text(res[i]['purchase_price']+'円');
				$tr.append($td);
				$td = $('<td class="text-center">').text(res[i]['selling_price']+'円');
				$tr.append($td);
				$td = $('<td class="text-center">').text(res[i]['tax_include_price']+'円');
				$tr.append($td);
				let a = '<a href="inout.php?id='+res[i]["mainId"]+'">[詳細]</a>';
				$td = $('<td class="text-center">').html(a);
				$tr.append($td);
				$('#detailModalTbody').append($tr);
			}
		});

		$('#detailModal').modal('show');
	});

});
</script>

</body>
</html>
