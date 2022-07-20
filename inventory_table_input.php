<?php

require_once('config/config.php');

$app = new \MyApp\Inventory_table_input();

$items = $app->getAll();

$title = '棚卸し入力画面';

?>
<?php include('template/header.php'); ?>
	<style media="screen">
		.input{
			cursor: pointer;
			color: blue;
		}
		.inventory{
			background: #ccc;
		}
	</style>
<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="page-header">
			<h1>棚卸し表 入力</h1>
		</div>

		<div class="btn-group mb-2" role="group" id="exist_btns">
			<button class="btn btn-sm btn-primary exist_list">在庫あり</button>
			<button class="btn btn-sm btn-outline-primary not_exist_list">在庫なし</button>
		</div>
		<div class="btn-group mb-2" role="group" id="inventory_btns">
			<button class="btn btn-sm btn-outline-success not_inventory_list">未棚卸</button>
		</div>


		<div class="row">
			<p class="bg-primary text-center text-white">棚卸しリスト</p>
			<table class="table table-sm">
				<thead>
					<tr>
						<th class="text-center">名前</th>
						<th class="text-center">規格</th>
						<th class="text-center">分類</th>
						<th class="text-center">入値</th>
						<th class="text-center">販売価格</th>
						<th class="text-center">税込価格</th>
						<th class="text-center">在庫数</th>
						<th class="text-center"></th>
					</tr>
				</thead>
				<tbody id="mainTable">
				<?php foreach($items as $item): ?>
					<tr id="<?= h($item->mainId); ?>" class="<?= $item->stock_nums>0 ? 'exist': '' ;?> <?= $item->inventory==1 ? 'inventory': '' ;?>">
						<td><?= h($item->name); ?></td>
						<td class="text-center"><?= h($item->size); ?></td>
						<td class="text-center"><?= h($item->class_name); ?></td>
						<td class="text-end"><?= h(number_format($item->purchase_price,0)); ?>円</td>
						<td class="text-end"><?= h(number_format($item->selling_price, 0)); ?>円</td>
						<td class="text-end"><?= h(number_format($item->tax_include_price, 0)); ?>円</td>
						<td class="text-end"><input type="text" size="5" class="nums text-right" value="<?= h($item->stock_nums); ?>">個</td>
						<td class="text-end input">[入力]</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
  <!-- container -->
  <?php include('template/footer.php'); ?>
<script>
$(function(){
	let isEdit = false;
	$('input:eq(0)').select().focus();

	$('#mainTable').children('tr').each(function(){
		if(!$(this).hasClass('exist')){
			$(this).hide();
		}
	});

	// 在庫ありボタンを押したときのリスト変更
	$('button.exist_list').click(function(){
		$('#mainTable').children('tr').each(function(){
			if(!$(this).hasClass('exist')){
				$(this).hide();
			} else {
				$(this).show();
			}
		});

		$('#inventory_btns').children('button').each(function(){
			if($(this).hasClass('btn-success')){
				$(this).removeClass('btn-success');
				$(this).addClass('btn-outline-success');
			}	
		});

		if( $(this).hasClass('btn-outline-primary') ){
			$(this).removeClass('btn-outline-primary');
			$(this).addClass('btn-primary');
			$('button.not_exist_list').removeClass('btn-primary');
			$('button.not_exist_list').addClass('btn-outline-primary');
		}
	})

	// 在庫なしボタンを押したときのリスト変更
	$('button.not_exist_list').click(function(){
		$('#mainTable').children('tr').each(function(){
			if($(this).hasClass('exist')){
				$(this).hide();
			} else {
				$(this).show();
			}
		});

		$('#inventory_btns').children('button').each(function(){
			if($(this).hasClass('btn-success')){
				$(this).removeClass('btn-success');
				$(this).addClass('btn-outline-success');
			}	
		});

		if( $(this).hasClass('btn-outline-primary') ){
			$(this).removeClass('btn-outline-primary');
			$(this).addClass('btn-primary');
			$('button.exist_list').removeClass('btn-primary');
			$('button.exist_list').addClass('btn-outline-primary');
		}
	})

	// 未棚卸のボタンを押したとき
	$('button.not_inventory_list').click(function(){
		$('#mainTable').children('tr').each(function(){
			if($(this).hasClass('inventory')){
				$(this).hide();
			} else {
				$(this).show();
			}
		});

		if( $(this).hasClass('btn-outline-success') ){
			$(this).removeClass('btn-outline-success');
			$(this).addClass('btn-success');
		}
		$('#exist_btns').each(function(){
			$(this).children('button').each(function(){
				$(this).removeClass('btn-primary');
				$(this).addClass('btn-outline-primary');
			})
		});

	});

	$('table').on('click', 'td.input', function(){
		if(isEdit) return false;
		isEdit = true
		var $this = $(this);
		var nums = $this.prev('td').children('input').val();
		var id = $this.parent('tr').attr('id');
		let btn_check;

		if(nums.search(/^[0-9]+$/) != 0){
			$this.prev('td').children('input').select().focus();
			alert('数字だけだよ！');
			return;
		}

		$.post('_ajax.php', {
			url: 'inventory_table_input',
			mode: 'inventory_nums',
			id: id,
			nums: nums
		}, function(res){
			$this.parent('tr').hide(800);
			if(!$this.parent('tr').hasClass('inventory')){
				$this.parent('tr').addClass('inventory');
			}
			if(nums==0){
				$this.parent('tr').removeClass('exist');
			}
			$this.parent('tr').show(400,function(){
				if($('button.exist_list').hasClass('btn-primary')){
					$this.parent('tr').nextAll('tr.exist').children('td:eq(6)').children('input.nums').select().focus();
				} else if(($('button.not_exist_list').hasClass('btn-primary'))){
					$this.parent('tr').nextAll('tr:not(".exist")').children('td:eq(6)').children('input.nums').select().focus();
				} else if(($('button.not_inventory_list').hasClass('btn-success'))){
					$this.parent('tr').nextAll('tr:not(".inventory")').children('td:eq(6)').children('input.nums').select().focus();
				}
				isEdit = false;
			});
		});
	});

	$(document).on('keypress', 'td>input.nums',  function(e){
		if(e.which==13){
			$(this).parent('td').next('td.input').click();
		}
	});
});
</script>

</body>
</html>
