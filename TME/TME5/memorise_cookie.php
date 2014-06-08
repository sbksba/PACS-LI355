<?php
require_once('../2/entete.php');
include('naviguer.php');

function memorise_cookie()
{
  if (!isset($_COOKIE['visite'])) {
    $v = 1;
    $f = 'COOKIE/' .  md5(mt_rand() . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
  } else {
    $f = 'COOKIE/' . $_COOKIE['visite'];
    $v = array_shift(file($f));
  }
  if ($d = fopen($f, 'w')) {
    fputs($d, $v+1);
    fclose($d);
  }
  setcookie('visite', $f);
  return $v;

}

$n = isset($_POST['page']) ? $_POST['page'] : 1;
$titre = "Page $n";
$v = memorise_cookie();
echo entete($titre), "<body>\n<h1>", $titre, "</h1>\n";
if (!is_numeric($n))
  echo "<div>Bon voyage pour " . ($bd[$n] * (($v > 1) ? ($v-1) : 1)) . "€ </div>";
else {
  $h = "";
  echo naviguer($bd, $n, $v, $h);
}
echo "</body</html>\n";

?>
