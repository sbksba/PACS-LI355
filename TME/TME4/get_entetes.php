<?php
include 'entete.php';

function getentetes($serveur, $port, $ressource)
{
  $d=@fsockopen($serveur,$port);
  if (!$d)
      return ($serveur . " sur le port " . $port . " ne répond pas.");
  else
      {
	fputs($d, "GET http://$serveur$ressource HTTP/1.1\nHost: $serveur\n\n");
	$status = fgets($d,4096);
	$reponse = array('status' => $status);
	while (strlen($l = fgets($d,4096)) > 2) {
	  if (preg_match('@([^:]+): +(.*)$@', $l, $x))
	    $reponse[$x[1]] = $x[2];
	}
	fclose($d);
	return $reponse;
      }
}

function arrayEnTableHTML($t){
  $r = "";
  $i = 0;
  foreach ($t as $k => $v){
    $i++;
    $color = ($i%2) ? '#777' : '#aaa';
    $r .= "\n<tr style='background-color:$color'><td>"
      . htmlspecialchars($k)
      . '</td><td>' 
      . htmlspecialchars($v)
      . "</td></tr>\n";
  }
  return "<table>\n<tr><th>Nom</th><th>Valeur</th></tr>\n$r</table>\n";
}

if (!isset($_GET['url']) OR
    !preg_match(',^(https?)://([^/:]*)(:\d+)?(.*)$,',$_GET['url'],$r))
  {echo "Argument 'url' incorrect";}
 else {
   list(, $schema, $serveur, $port, $ressource) = $r;
   if (!$port) $port = ($schema == 'http') ?  80 : 443;
   $r = getentetes($serveur, $port, $ressource);
   if (!is_array($r))
     echo $r;
   else {
     include "entete.php";
     error_reporting(E_ALL);
     echo DOCTYPE_XHTML_BASIC_11, "\n";
     echo HTML_FR, "\n";
     echo "<head>\n";
     echo META_TYPE_TEXT_HTML_UTF8, "\n";
     echo "<title>Date du jour</title>\n";
     echo "</head>\n<body>\n";
     echo arrayEnTableHTML($r);
     echo "</body></html>\n";
   }
 }
?>
