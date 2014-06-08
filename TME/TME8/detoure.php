<?php

// Filtre d'Arnaud Martin pour detourer une image
// avec simplification par rapport a l'original, soucieux de portabilite
// http://www.paris-beyrouth.org/tutoriaux-spip/article/un-habillage-irregulier-float

function image_float ($img, $align, $texte, $margin=10) {
	list($w, $h)  = getimagesize($img);

	$pixels = imagecreatefrompng($img);
	$right = ($align == "right");
	$style = "float: $align; clear: $align; height: 1px; width: ";
	$forme = '';
	for ($j = 0; $j < $h; $j++) {
		$larg = $w+$margin;
		for ($i = 1; $i <= $w; $i++) {
		  $c = ImageColorAt($pixels, $right ? $i : ($w-$i), $j);
		  if ((($c >> 24) & 0xFF) > 125) $larg--;
		  else break;
		}
		$forme .= "\n<div style='$style$larg" . "px;'></div>";
	}
	$c = $w + round($w/2);
	return "<div style='border: 1px solid; width: ${c}px; padding: 8px;'>" .
	  "<div style='position: relative; float: $align;'><span style='background-image:url($img); position: absolute; $align: 0px;width: ${w}px; height:${h}px;'></span></div>$forme<p>$texte</p></div>";
}

echo '<html><body>',image_float ('gnu.png', 'right',
"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
Vivamus ut nunc eget ante ornare nonummy.
Ut arcu.
Duis tincidunt tincidunt quam.
In elementum blandit odio.
Nullam ultrices.
Nulla sem augue, mollis id, vulputate eget, ullamcorper ultrices, purus.
Aenean porttitor odio at mauris.
Mauris quis enim vitae purus dictum ultricies.
Proin pharetra lectus auctor lacus.
Quisque at sem ac lectus ornare vehicula.
Nunc pulvinar, leo ut tristique auctor, felis diam gravida neque,
consectetuer cursus sem nisl ut enim.
Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
Donec justo.
Aliquam erat volutpat.
Sed vel enim nec tellus suscipit imperdiet.
Maecenas sagittis, dolor id tincidunt suscipit, orci tortor fermentum mi,
id varius dolor nisi quis lectus.
Quisque ante sem, molestie a, euismod sed, tempus sit amet, mauris.
Integer vel ante eget urna sagittis consectetuer.
Quisque ullamcorper convallis velit.")
;
?>
