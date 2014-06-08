<?php
require_once('../2/entete.php');
include('naviguer.php');

function protege_cookie()
{
  if (!isset($_COOKIE['visite'])) {
    $v = 1;
    $a = mt_rand();
    $f = 'COOKIE/' . md5($a . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
  } else {
    $f = 'COOKIE/' . $_COOKIE['visite'];
    if ($_COOKIE['visite'] AND is_readable($f)) {
      list($v, $a) = file($f);
      $f2 = md5($a . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    } else $f2 = '';
    if ($_COOKIE['visite'] != $f2) {
      header('HTTP/1.1 403 Forbidden');
      die("Vol de cookie mon gaillard");
    }
  }
  if ($d = fopen($f, 'w')) {
    fputs($d, $v+1 . "\n$a");
    fclose($d);
 }
  setcookie('visite', $f);
  return $v;
}

$n = isset($_POST['page']) ? $_POST['page'] : 1;
$titre = "Page $n";
$v = protege_cookie();
echo entete($titre), "<body>\n<h1>", $titre, "</h1>\n";
if (!is_numeric($n))
  echo "<div>Bon voyage pour " . ($bd[$n] * (($v > 1) ? ($v-1) : 1)) . "€ </div>";
else {
  $h = "";
  echo naviguer($bd, $n, $v, $h);
}
echo "</body</html>\n";

?>
