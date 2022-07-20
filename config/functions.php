<?php

function h($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function wareki($s){
	$y = mb_substr($s, 0, 4);
	$m = mb_substr($s, 5, 2);
	$d = mb_substr($s, 8, 2);
	$h = mb_substr($s, 11, 2);
	$min = mb_substr($s, 14, 2);
	
	$wa = $y. '年'. $m. '月'. $d. '日 '. $h. '時'. $min. '分';
	return $wa;
}
