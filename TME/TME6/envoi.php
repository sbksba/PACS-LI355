<?php
define('HAUTEUR', 128);
define('EPAISSEUR', 16);

include "rectangle.php";

function rectangles($table, $width, $height)
{
	$svg = rectangle($table);
	if (!is_array($svg))
	  echo $svg;
	else {
	  header("Content-Type: image/svg+xml");
	  echo "<!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 
				'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'>";
	  echo "\n<svg  xmlns='http://www.w3.org/2000/svg' width='$width' 
			height='$height'>";	  
	  echo "<g transform='translate(10,10),scale(1,-1)'>";
	  echo join("\n", $svg);
	  echo "</g></svg>";
	}
}

?>
