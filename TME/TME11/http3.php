<?php           
// Ecriture en deux fonctions pour preparer le TME

define("RE_REWRITERULE", "/^RewriteRule\s+(.*)\s+(.*)(\s+\[\w+\])?$/");


function TraitePerso ($etapes){
  return TraitePersoRoot($etapes, $_SERVER['DOCUMENT_ROOT']);
}

function TraitePersoRoot ($etapes, $document_root){
	$auth = false;
	$path = $document_root;
	$dirs = preg_split(',/+,',  $etapes[1][0]);
	array_shift($dirs); // saute le "" initial
	foreach($dirs as $dir) {
	  $file = $path . "/.htaccess";
	  if (file_exists($file)) {
	    if (!is_readable($file) 
		OR (fileperms ($file) & 2)) {
	      return array(500, "Probleme d’acces sur $file");
	    } else{
        $lignes = file($file);
        if (in_array("require valid-user\n", $lignes)){
  	      $auth = true;
  	      return array(401, "Demande d'authentification");  
        }
        foreach ($lignes as $ligne){
          //Voir si c'est réecriture d'url 
          if(preg_match(RE_REWRITERULE, $ligne, $a)){
            $htaccessRegex = $a[1];
            if(preg_match($htaccessRegex, $etapes[1][0])){
              //prendre la substitution
              return array(200, "Autorise", $document_root . "/" . $a[2]);           
            } 
          }
        }
                
	    }
	  }
	  $path .= '/' . $dir;
	}
  //Pas d'authentification et pas réecriture d'URL
	return array(200, $document_root . "/" . $etapes[1][0]);
	  
}

?>