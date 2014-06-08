<?php
// Construit 3 boutons de soumissions permettant de naviguer et choisir
// dans un catalogue decrit par le tableau $catalogue de forme: 
// array(article1 => prix1, article2 => prix2, ....)
// $n est le numero de page en cours de consultation
// $v est un multiplicateur du prix (par exemple une TVA de 20% => $v=1,2)

function naviguer($catalogue, $n, $v=1, $corps='')
{
  $att = " type='submit' name='page'";
  if (($n <= 0) OR ($n > count($catalogue))) $n = 1;
  if ($n > 1) 
    $p = "<input$att style='float:left' value='" . ($n-1) . "' />\n";
  else $p = '';
  if ($n < count($catalogue))
    $s = "<input$att style='float:right' value='" . ($n+1) . "' />\n";
  else $s = '';
  $choix = '';
  foreach($catalogue as $nom => $prix) {
    if (!--$n)
      $choix = "<input$att value='" . $nom . "' /> " . ($v * $prix)  . '€'; 
  }
  $corps .= "<fieldset>$p$s</fieldset>\n<fieldset>$choix</fieldset>\n";
  return "<form action='' method='post' style='width:15%'>\n$corps</form>";
}
// Test
$bd = array('Londres' => 100, 'Madrid' => 200 , 'Berlin' => 300);
//require_once('../2/entete.php');
//$n = isset($_POST['page']) ? $_POST['page'] : 1;
//$titre = "Page $n";
//echo entete($titre), "<body>\n<h1>", $titre, "</h1>\n";
//if (!is_numeric($n))
//  echo "<div>Bon voyage pour " . $bd[$n] .  "€ </div>";
//else echo naviguer($bd, $n);
//echo "</body</html>\n";
?>
