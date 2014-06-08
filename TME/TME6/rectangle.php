<?php

define('HAUTEUR', 128);
define('EPAISSEUR', 16);

define("RE_COLOR", "@background-color:\s*([^;]+)@");

function rectangle($table)
{
	$res = array();
	$i = 1;
	foreach ($table as $ligne) {
	  $k = 0;
	  foreach($ligne as $v) {
	    if (!preg_match(RE_COLOR, $v['style'], $m))
	       return 'style incorrect: ' . $v['style'];
	    $res[]= sprintf("\n<rect x='%d' y='-%d' width='%d' height='%ld'
 fill='%s' />",
			 $k,
			 $i * HAUTEUR,
			 $v['colspan'] * EPAISSEUR,
			 $v['contenu'],
			 $m[1]
);
	    $k+=$v['colspan'] * EPAISSEUR;
	  }
	  $i++;
	}
	return $res;
}

?>
