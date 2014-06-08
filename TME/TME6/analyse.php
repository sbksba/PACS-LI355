<?php
global $width, $height, $table, $last;

$table = $last = array();

function ouvrante($phraseur, $name, $attrs)
{
  global $width, $height, $table, $last;

  $last['contenu'] = $name;
  switch ($name) {
  case "table": $width = $attrs['width'];$height = $attrs['height'];break;
  case "tr": $table[] = array(); break;
  case "td": 
    $last['colspan'] = isset($attrs['colspan']) ? $attrs['colspan'] : 1;
    $last['style'] = isset($attrs['style']) ? $attrs['style'] : 'background-color: white';
    break;
  }
}

function fermante($phraseur, $name) {}

function texte($phraseur, $data)
{
  global $last, $table;
  if ($last['contenu'] == 'td') {
      $last['contenu'] = trim($data);
      $table[count($table)-1][] = $last;
  }
}

?>
