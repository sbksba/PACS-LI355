<?php

function tableau_en_table($t, $caption, $sum='', $width='100%')
{
  if (!$t) return '';
  $i = 0;
  $chaine = '';
  foreach ($t as $k => $v) {
    $c = ($i%2) ? '#eee' : '#ddd';
    $chaine .= "<tr style='background-color:$c'><td>$k</td><td>$v</td></tr>\n";
    $i++;
  }
  $h = "<tr style='background-color:#777'><th>Index</th><th>Valeur</th></tr>\n";
  $c = "<caption style='background-color:#aaa'>$caption</caption>";
  return "<table style='width:$width' summary='$sum'>$c$h$chaine$h</table>";
}
// Test
// include('entete.php');
// echo entete('Les Variables du serveur');
// echo tableau_en_table($_SERVER, 'Les Variables du serveur');
?>
