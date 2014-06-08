TD 5
====

Trouver le sous-type
--------------------

     <?php
     define('RE_CONTENT_TYPE', ',Content-Type:\s+\w+/([^\s;]+),');

     function typer_cache($headers){
     	      foreach ($headers as $l) {
    	          if (preg_match(RE_CONTENT_TYPE, $l, $match)){
      		     return $match[1];
                  }
              }
      	      return 'html';
      }
      ?>

L'expire n arrive pas toujours
------------------------------

      <?php

      define('RE_EXPIRE', "%^Expires: (.*)%");

      function limiter_cache($headers){
            foreach($headers as $l){
                if (preg_match(RE_EXPIRE, $l, $match)){
                    return  (strtotime($match[1]) < time()) ;
                }
            }
  	    return true;
       }
       ?>

Retrouver un cache
------------------

      <?php
      function trouver_cache($nom)
      {
           if (!is_readable($nom . '.http')) return array();
  	   $h = file($nom . '.http');
  	   $type = typer_cache($h);
  	   return (is_readable($nom . '.' . $type) ? $h : array());
       }
       ?>

Memoriser un cache
------------------

       <?php
       function memoriser_cache($nom, $entetes, $page)
       {
	     $type = typer_cache($entetes);
  	     if (($d1 = fopen($nom . ".http",'w')) AND ($d2 = fopen($nom . "." . $type,'w'))) {
    	            fputs($d1, join($entetes));
    		    fclose($d1);
    		    fputs($d2, $page);
    		    fclose($d2);
    		    return true;
             }
  	     return false;
        }
	?> 

Detruire un cache
-----------------

        <?php
	function nettoie_cache($tabCaches){
  		 sort($tabCaches);
  		 $nom = key($tabCaches);
  		 $nom_h = $nom . '.http';
  		 $nom_t = $nom . '.' . trouve_type(file($nom_h));
  		 unlink($nom_h);        
  		 unlink($nom_t);
  		 array_shift($tabCaches); 
  		 return $tabCaches;
	}
	?>

Mettre a jour le cache
----------------------

        <?php
	// La fonction "file" retourne un tableau de lignes qui se terminent par \n
	// On coupe en deux chaque ligne par preg_split avec \s+ 
	// afin de supprimer aussi ces \n.
	// On memorise la duree sous forme numerique pour accelerer le tri ulterieur

	function charger_cache($nom)
	{
		$clefVal = array();
  		foreach (is_readable($nom) ? file($nom) : array() as $v ) {
    			list($nom, $age) = preg_split('@\s+@', $v);
    			$clefVal[$nom] = intval($age);
                }
  		return $clefVal;
	}

	function actualiser_cache($nom)
	{
		 $tabCaches = charger_cache(CACHEFILE);
  		 if ($d = fopen(CACHEFILE,'w')){
    		    $tabCaches[$nom] = time();
    		    if (count($tabCaches) > MAXCACHES) 
      		    $tabCaches = nettoie_cache($tabCaches);
    		    foreach ($tabCaches as $k => $heure) fputs($d, $k." ".$heure."\n");
    		    fclose($d);
 		 }
	}
	?>

Cache a l'eau
-------------

       <?php

       define('RE_HTTP200', "%^HTTP.*200 OK%");
       define('RE_NOCACHE', "%^(Pragma|Cache-Control):.*no-cache%");

       function no_cache($serveur, $port, $resource){
       		$d = fsockopen($serveur,$port);
       		if (!$d)
       	  	   echo $serveur, " sur le port ", $port, " est muet.";
       		else{
		   $entetes = array();
    	  	   $cache = true;
    	  	   fputs($d, "GET http://$serveur$resource HTTP/1.1\nHost: $serveur\n\n");
    	  	   while (strlen($l = fgets($d)) >2) { 
      	  	   	 if (preg_match(RE_NOCACHE, $l)) $cache = false;
      			 $entetes[] = $l;
    	           }
    	  	   $page='';
    	  	   while ( !feof($d) ) $page .= fgets($d);
    	  	   foreach($entetes as $l) header($l);
    	  	   echo $page;
    	  	   return ($cache AND preg_match(RE_HTTP200, $entetes[0])) ? array($entetes, $page) : false;
       	        }
       }      
       ?>

Utiliser votre systeme de cache
-------------------------------

       <?php

       // Constante indiquant le nombre maximum de cache
       define('MAXCACHES', 6);
       // Répertoire des caches
       define('DIRCACHE', 'Cache/'); 
       // Fichier de la table des caches : md5 => date (en secondes depuis le 1/1/1970)
       define('CACHEFILE', 'Cache/caches');
       // Analyser une URL
       define('RE_URL', "%http://([^/:]*)(:(\d+))?(/.*)$%");

       include('actualiser_cache.php');
       include('limiter_cache.php');
       include('memoriser_cache.php');
       include('nettoyer_cache.php');
       include('no_cache.php');
       include('trouver_cache.php');
       include('typer_cache.php');

       function utiliser_cache($url)
       {
		$md5 = md5($url);
    		$h = trouver_cache(DIRCACHE . $md5);
    		if ($h AND limiter_cache($h)) {
      		       actualiser_cache($md5);
      		       foreach ($h as $l) header($l);
      		       readfile(DIRCACHE . $md5 . "." . typer_cache($h));
    		} elseif (!preg_match(RE_URL,$url,$desc)) {
      		       header('HTTP/1.1 400');
      		       echo "URL incomprise";
                } else {
      		       $r = no_cache($desc[1], $desc[3] ? $desc[3] : 80, $desc[4]);
      		       if ($r AND memoriser_cache(DIRCACHE . $md5, $r[0], $r[1])) {
    		       	  actualiser_cache($md5);
                       }
                }
        }
	// Pour tester (avec utiliser_cache.php?URL sans meme de truc=URL):
	utiliser_cache($_SERVER["QUERY_STRING"]);
	?>
