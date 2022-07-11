<?php

require_once('config/config.php');

$app = new \MyApp\Receipt();
$data = $app->getReceOnDate();

?>

<div class="list-group" id="mg_id_list">
<?php foreach($data as $d): ?>
  <button type="button" class="list-group-item">
    管理番号:
    <span data-id="<?= h($d->mg_id) ; ?>">
      <?= h($d->mg_id) ; ?>
    </span>
    ( <?= h(substr($d->created, -8)); ?> )
  </button>
<?php endforeach; ?>
</div>

<script>
$(function(){
  $('#mg_id_list').on('click', 'button', function(){
    var mgId = $(this).children('span').data('id');
    window.location.href = "?mgId=" + mgId;
  });

});
</script>
