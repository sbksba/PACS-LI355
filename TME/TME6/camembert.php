<?php

define('HAUTEUR', 128);
define('EPAISSEUR', 16);

define("RE_COLOR", "@background-color:\s*([^;]+)@");

function camembert($table, $width, $height)
{
 	header("Content-Type: image/svg+xml");
	echo "<!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 
			'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'>";
	echo "\n<svg  xmlns='http://www.w3.org/2000/svg' 
			xmlns:xlink='http://www.w3.org/1999/xlink' 
			width='$width' height='$height'>";	  
	echo "<g transform='translate(10,500),scale(1,-1)'>";

	$i = 0;
	$angle = 0;
	foreach ($table as $ligne) {
	  echo sprintf("<g transform='translate(%d,%d)'>\n", 
						HAUTEUR + ($i *2 * HAUTEUR), HAUTEUR);
	  $x = HAUTEUR;
	  $y = 0;
	  $k = 0;
	  $j = 1;
	  foreach($ligne as $v) {
	    $angle += $v['contenu']*(3.14*2/100);
	    $xx = cos($angle) * HAUTEUR;
	    $yy = sin($angle) * ( 0 - HAUTEUR);
	    if (!preg_match(RE_COLOR, $v['style'], $m))
	      die('style incorrect: ' . $v['style']);
	    echo printf("<path d='M0,0 %f %f A%d,%d 0 %d 0 %f %f ' 
														fill='%s'/>\n",
                 $x,
                 $y,
                 HAUTEUR, // cmd lineto implicite lorsque M a + de 2 args
                 HAUTEUR,
                 (($v['contenu'] > 50) ? 1 : 0),
                 $xx,
                 $yy,
                 $m[1]);
	    $x = $xx;
	    $y = $yy;
	    $j++;
	  }
	  $i++;
	  echo "</g>";
	}
	echo "</g></svg>"; 
}
?>
