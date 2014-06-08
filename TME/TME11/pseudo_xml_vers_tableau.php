<?php
define ('RE_BALISE', "/^\s*(<\S+)\s+([^>]+)(>.*)$/");
define ('RE_ATTR', '#^".*"$#');

function pseudo_xml_to_array_xml($path){
  $resultat = array();
  
  $file = file($path);
  array_unshift($file, '<CONF>');
  array_push($file, '</CONF>');

  foreach($file as $l) {
    $l = ltrim($l);
    if ($l AND $l[0] !== '#') {
      if (preg_match(RE_BALISE, $l,$a)) {
        if (!preg_match(RE_ATTR, $a[2])) {
	  $s = strpos($a[2], '"') ? "'" : '"';
          $a[2] = $s . $a[2] . $s;
        }
        $l = $a[1] . " v=" . $a[2]  . $a[3];        
      }
      array_push($resultat, $l);     
    }
  }
  
  return $resultat;
}

//Test 
// var_dump (pseudo_xml_to_array_xml("httpd.conf"));
?>