<?php

// define('HTTPD_CONF', '/Users/esj/Sites/esj.conf'); // test
include('pseudo-xml.php');

$roots = array();
$ports = array(80);
$names = array('localhost');

function ouvre2($phraseur, $name, $attrs){
  global $pile, $ports, $names;
  array_push($pile, $name);
  if ($name == 'VirtualHost') {
    preg_match('#^([^:]*)(:(\d+))?$#', $attrs['v'], $a);
    array_push($ports, $a[3] ? $a[3] : 80);
    array_push($names, (($a[1] == '*') OR !$a[1]) ? 'localhost' : $a[1]);
  }
}

function ferme2($phraseur, $name){
  global $pile, $ports, $names;
 array_pop($pile);
  if ($name == 'VirtualHost')
    array_pop($ports);
    array_pop($names);
}

function cherche_document_root($phraseur, $texte)
{
 static $name ='defaut';
 global $pile, $ports, $roots, $names;
 if (preg_match('/\bServerName\s+(\S+)/', $texte, $a))
   $names[count($names)-1] = $a[1];
 if (preg_match('/\bDocumentRoot\s+(\S+)/', $texte, $a)) {
   $roots[$names[count($names)-1]][$ports[count($ports)-1]] = $a[1];
 }
}

analyse_http_conf(HTTPD_CONF, 'ouvre2', 'ferme2', 'cherche_document_root');

// var_dump($roots); //test

// modification du TD:

function TraitePerso ($etapes){
  global $roots;
  return TraitePersoRoot($etapes, 
		$roots[$_SERVER['HTTP_HOST']][$_SERVER['SERVER_PORT']]);
}

?>
