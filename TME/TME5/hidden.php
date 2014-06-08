<?php
require_once('../2/entete.php');
include('naviguer.php');
$n = isset($_POST['page']) ? $_POST['page'] : 1;
$v = isset($_POST['visite']) ? $_POST['visite'] : 1;
$titre = "Page $n";
echo entete($titre), "<body>\n<h1>", $titre, "</h1>\n";
if (!is_numeric($n))
  echo "<div>Bon voyage pour " . ($bd[$n] * (($v > 1) ? ($v-1) : 1)) . "€ </div>";
else {
  $h = "<div><input type='hidden' name='visite' value='". ($v+1). "' /></div>\n";
  echo naviguer($bd, $n, $v, $h);
}
echo "</body</html>\n";
?>
