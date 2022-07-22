<?php

require_once('config/config.php');

$app = new \MyApp\Setting();
$wholesales = $app->get_wholesales();
$otc_classes = $app->get_classes();

// echo '<pre>';
// var_dump($wholesales);
// var_dump($otc_classes);
// echo '</pre>';

$title = '設定';

?>
<?php include('template/header.php'); ?>
<style>
	.edit_wholesale{
		color: blue;
		cursor: pointer;
	}
	.delete_wholesale{
		color: red;
		cursor: pointer;
	}
</style>

<body>
	<?php include('template/navber.php'); ?>

	<div class="container mt-3">
		<div class="page-header">
			<h1>設定 </h1>
		</div>

		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
				<h2>卸、カテゴリの編集</h2>
				<div class="d-grid gap-3">
					<button type="button" class="btn btn-primary px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_wholesale">
						取引卸を編集する
					</button>
					<button type="button" class="btn btn-success px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_class">
						カテゴリ分類を編集する
					</button>
				</div>
			</div>
			<div class="col-xs-12 col-sm-10 col-md-4 col-lg-3 col-xl-2 mt-4">
				<h2>棚卸しシステム</h2>
				<div class="text-end">
					<button type="button" id="resetBtn" class="btn btn-danger">棚卸をリセットする</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal_1 -->
	<div class="modal fade" id="modal_wholesale" tabindex="-1" aria-labelledby="modal_wholesale_label" aria-hidden="true">
  		<div class="modal-dialog">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="modal_wholesale_label">取引卸の編集</h5>
        			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
      			<div class="modal-body">
					<button class="btn btn-success" id="new_wholesale">新規作成</button>
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>卸名</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="wholesale_list">
							<?php foreach($wholesales as $wholesale): ?>
							<tr data-id="<?= h($wholesale->id); ?>" data-name="<?= h($wholesale->name); ?>">
								<td><?= h($wholesale->id); ?></td>
								<td><?= h($wholesale->name); ?></td>
								<td>
									<span class="edit_wholesale">[編集]</span>
									<span class="delete_wholesale">[削除]</span>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      			</div>
    		</div>
  		</div>
	</div>

	<!-- Modal_2 -->
	<div class="modal fade" id="modal_class" tabindex="-1" aria-labelledby="modal_class_label" aria-hidden="true">
  		<div class="modal-dialog">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="modal_class_label">カテゴリの変更</h5>
        			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
      			<div class="modal-body">
        			...
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      			</div>
    		</div>
  		</div>
	</div>




  <!-- container -->
  <?php include('template/footer.php'); ?>
<script>
$(function(){

	$('#resetBtn').click(function(){
		if(confirm('本当にリセットしてもよろしいですか？')){
			$.post('_ajax.php', {
				url: 'setting',
				type: 'inventory_reset'
			}, function(){
				window.location.href="inventory_table.php";
			});
		}
	});

	let isEdit = false;

	$('tbody#wholesale_list').on('click', '.edit_wholesale', function(){
		// $(this).removeClass('edit_wholesale');
		if(isEdit) return false;
		isEdit = true;
		let id = $(this).parent('td').parent('tr').data('id');
		let $td = $(this).parent('td').prev('td');
		let old_name = $td.text();
		let edit_input = $('<input type="text">').val(old_name);
		let edit_submit = $('<button class="update_wholesale btn btn-sm btn-success"></button').text('更新');
		$td.empty()
			.append(edit_input).append(edit_submit);
		$td.children('input').select().focus();
	});

	$('tbody#wholesale_list').on('click', '.update_wholesale', function(){
		let $this = $(this);
		let id = $(this).parent('td').parent('tr').data('id');
		let old_name = $(this).parent('td').parent('tr').data('name');
		let new_name = $(this).prev('input').val();

		if(old_name==new_name){
			alert('名前の変更はありません！');
			return false;
		}

		$.post('_ajax.php', {
			url: 'setting',
			mode: 'delete_wholesale_check',
			id: id
		}, function(res){
			if(res>0){
				if( confirm('以前から使用しているすべての名前を\n新しい名前に変更しますがよろしいですか？') ){
					$.post('_ajax.php', {
						url: 'setting',
						mode: 'update_wholesale',
						id: id,
						name: new_name
					}, function(){
						let $td = $this.parent('td');
						$td.parent('tr').data('name', new_name);
						$td.empty();
						$td.text(new_name);
					});
				}
			} else {
				$.post('_ajax.php', {
					url: 'setting',
					mode: 'update_wholesale',
					id: id,
					name: new_name
				}, function(){
					let $td = $this.parent('td');
					$td.parent('tr').data('name', new_name);
					$td.empty();
					$td.text(new_name);
				});
			}
			isEdit=false;
		});



	});

	$('tbody#wholesale_list').on('click', '.delete_wholesale', function(){
		if(isEdit) return false;
		let id = $(this).parent('td').parent('tr').data('id');
		let $this = $(this);
		let old_name = $(this).parent('td').prev('td').text();
		if( confirm('『'+old_name+'』を\n本当に削除してもよろしいですか？') ){
			$.post('_ajax.php', {
				url: 'setting',
				mode: 'delete_wholesale_check',
				id: id
			}, function(res){
				if(res>0){
					alert('すでに使用しているので削除できません。');
					return false;
				}

				$.post('_ajax.php', {
					url: 'setting',
					mode: 'delete_wholesale',
					id: id
				}, function(){
					$this.parent('td').parent('tr').fadeOut(800);				
				});
			});
		}
	});

	$('#new_wholesale').click(function(){
		if(isEdit) return false;
		isEdit = true;
		$(this).prop('disabled', true);
		let w_input = $('<input type="text" id="new_input_wholesale">');
		let create_btn = $('<button class="btn btn-sm btn-success create_wholesale"></button>').text('登録');
		$(this).parent('div.modal-body').append(w_input).append(create_btn);
		$(this).parent('div.modal-body').children('input').select().focus();
	});

	$('#modal_wholesale div.modal-body').on('click', '.create_wholesale', function(){
		let w_name = $(this).prev('input').val();
		if( w_name=='' ){
			alert('入力が空です');
			$(this).prev('input').focus();
			return false;
		}
		let same_check = false;
		$('#wholesale_list').children('tr').each(function(){
			if( $(this).children('td:eq(1)').text() == w_name ){
				same_check=true;
			}
		});

		if(same_check){
			alert('すでに同じ名前の卸が登録されています。');
			return false;
		}

		$.post('_ajax.php', {
			url: 'setting',
			mode: 'create_wholesale',
			name: w_name
		}, function(res){
			let $tr = $('<tr data-id="'+res+'" data-name="'+w_name+'"></tr>');
			let $td_1 = $('<td></td>').text(res);
			let $td_2 = $('<td></td>').text(w_name);
			let $td_3 = $('<td></td>').append($('<span class="edit_wholesale"><span>').text('[編集]')).append($('<span class="delete_wholesale"><span>').text('[削除]'));
			$('tbody#wholesale_list').append(
				$tr.append($td_1).append($td_2).append($td_3)
			);

			$('#new_input_wholesale').next('button').remove();
			$('#new_input_wholesale').remove();

			$('#new_wholesale').prop('disabled', false);
			isEdit = false;
		});
	});


});
</script>

</body>
</html>
