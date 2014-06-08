<?php

function message_erreur($s, $IP, $mois=''){
  $mip = str_replace('.', '\\.', $IP);
  if (!intval($mois)) $mois = @date('M');
  $re = "/$mois \d+ (..:..:..) 20..\] \[error\] \[client $mip\](.+)/";
  $n = preg_match_all($re, $s,$m,  PREG_SET_ORDER);
  if (!$n) return "<div>Rien vu.\n</div>";
  $sol = array();
  foreach($m as $v) $sol[$v[1]] = $v[2];
  return tableau_en_table($sol, "$mois $IP", "$n erreurs");
}
// Test
// error_reporting(E_ALL);
// $chaine=file_get_contents("/var/log/apache2/error_log");
// include('entete.php');
// include('tableau_en_table.php');
// echo entete('Les erreurs du serveur');
// echo '<body>';
// echo message_erreur($chaine, '127.0.0.1');
// echo '</body></html>';
?>
