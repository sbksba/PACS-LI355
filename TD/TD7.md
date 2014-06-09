TD 7
====

Les balises auto-fermantes
--------------------------

     <?php
     global $ferme;
     $ferme = true;

     function ouvrante($parser, $name, $attrs)
     {
         global $ferme;

 	 if (!$ferme) {
    	    echo '>';
    	    $ferme = true;
         }
  	 echo "<$name"; 

  	 foreach ($attrs as $k => $v) {
    	    echo " $k='$v'";
  	 }
  	 $ferme = false;
     }

     function fermante($parser, $name)
     {
        global $ferme;
  	if (!$ferme) 
    	   echo ' />';
  	else echo "</", $name, ">";
  	$ferme = true;
     }

     function texte($parser, $data)
     {
        global $depth, $ferme;
  	if (!$ferme) {
    	   echo '>';
    	   $ferme = true;
        }
  	echo $data;
     }

     //Tests
     function accessibiliser($file) {
        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, "ouvrante", "fermante");
        xml_set_character_data_handler($xml_parser, "texte");
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
        if (!($f = fopen($file, "r"))) {
          die("Impossible d'ouvrir le fichier '$file'");
        }

        while ($data = fread($f, 1024)) {
          if (!xml_parse($xml_parser, $data, feof($f))) {
            die(sprintf("erreur XML : %s ligne %d",
                        xml_error_string(xml_get_error_code($xml_parser)),
                        xml_get_current_line_number($xml_parser)));
          }
        }
        xml_parser_free($xml_parser);
     }

     accessibiliser("test.html");
     ?> 

Les attributs Alt
-----------------

     <?php
     global $depth, $ferme;
     $depth = 0;
     $ferme = array(0 => true);

     function ouvrante($parser, $name, $attrs)
     {
        global $depth, $ferme;

  	if (!$ferme[$depth]) {
    	   echo '>';
    	   $ferme[$depth] = true;
        }
  	$depth++;
  	echo "<$name";
  
	$alt = ($name == 'img');
  	foreach ($attrs as $k => $v) {
    	   if ($k == 'alt') $alt = false;
    	   elseif ($k == 'src') $src = $v;
    	   echo " $k='$v'";
  	}
  	if ($alt){
    	   $baseName = basename($src); 
    	   if(preg_match("/(\w+)\.\w+$/", $baseName, $match))  
      	      echo " alt='", $match[1], "'";
  	} 
    
	$ferme[$depth] = false;
     }

     function fermante($parser, $name)
     {
        global $depth, $ferme;
  	if (!$ferme[$depth]) 
    	   echo ' />';
  	else echo "</", $name, ">";
  	$depth--;
     }

     function texte($parser, $data)
     {
        global $depth, $ferme;
  	if (!$ferme[$depth]) {
    	   echo '>';
    	   $ferme[$depth] = true;
        }
     	echo $data;
     }

     //Tests
     function accessibiliser($file) {
        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, "ouvrante", "fermante");
        xml_set_character_data_handler($xml_parser, "texte");
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
        if (!($f = fopen($file, "r"))) {
          die("Impossible d'ouvrir le fichier '$file'");
        }

        while ($data = fread($f, 1024)) {
          if (!xml_parse($xml_parser, $data, feof($f))) {
            die(sprintf("erreur XML : %s ligne %d",
                        xml_error_string(xml_get_error_code($xml_parser)),
                        xml_get_current_line_number($xml_parser)));
          }
        }
        xml_parser_free($xml_parser);
     }
     ?> 

Les attributs Title
-------------------

     <?php
     global $depth, $ferme;
     $depth = 0;
     $ferme = array(0 => true);

     function ouvrante($parser, $name, $attrs)
     {
        global $depth, $ferme;
     	static $titles = array();

     	if (!$ferme[$depth]) {
           echo '>';
   	   $ferme[$depth] = true;
     	}
     	$depth++;

 	if (($name == 'img') AND !isset($attrs['alt'])) {
           $attrs['alt'] = basename($attrs['src']);
 	}
 	if (($name == 'a') AND isset($attrs['href'])) {
           $precedent = isset($titles[$attrs['href']]) ? $titles[$attrs['href']] : '';
   	   if (!isset($attrs['title'])) {
     	      if(!$precedent)                
                 $precedent = 'Lien ' . (count($titles)+1);
     
	      $attrs['title'] = $precedent;
   	   }else{
    	      if(($precedent) AND ($attrs['title'] != $precedent))
                 $attrs['title'] = $precedent;          
    	      else
      	         $precedent = $attrs['title']; 
           }
   	   $titles[$attrs['href']] = $precedent;
 	}
	echo "<$name";
 	foreach ($attrs as $k => $v) echo " $k='$v'";
 	$ferme[$depth] = false;
     }

     function fermante($parser, $name)
     {
        global $depth, $ferme;
 	if (!$ferme[$depth]) 
   	   echo ' />';
 	else echo "</", $name, ">";
 	   $depth--;
     }

     function texte($parser, $data)
     {
        global $depth, $ferme;
 	if (!$ferme[$depth]) {
   	   echo '>';
   	   $ferme[$depth] = true;
 	}
 	echo $data;
     }

     //Tests
     function accessibiliser($file) {
        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, "ouvrante", "fermante");
        xml_set_character_data_handler($xml_parser, "texte");
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
        if (!($f = fopen($file, "r"))) {
          die("Impossible d'ouvrir le fichier '$file'");
        }

        while ($data = fread($f, 1024)) {
          if (!xml_parse($xml_parser, $data, feof($f))) {
            die(sprintf("erreur XML : %s ligne %d",
                        xml_error_string(xml_get_error_code($xml_parser)),
                        xml_get_current_line_number($xml_parser)));
          }
        }
        xml_parser_free($xml_parser);
     }
     ?> 

Les tables
----------

     <?php

     global $depth, $ferme, $tables, $tableIndex;
     $depth = $tableIndex = 0;
     $ferme = array(0 => true);
     $tables = array ();

     function ouvrante($parser, $name, $attrs)
     {
        global $depth, $ferme, $tables, $tableIndex;
 	static $titles = array();

 	if (!$ferme[$depth]) {
   	   echo '>';
   	   $ferme[$depth] = true;
 	}
 	// La ligne suivante concerne la Question 4 + declaration global
 	//une nouvelle table dont la premiere ligne n'est pas encore rencontrée
 	if ($name == 'table') {$tables[$tableIndex] = true; $tableIndex++;}
 
	//ce sont les TD de la première ligne de la table courante
 	if (($name == 'td') AND $tables[$tableIndex - 1]) $name = 'th'; 
 	$depth++;
 
	if (($name == 'img') AND !isset($attrs['alt'])) {
           $attrs['alt'] = basename($attrs['src']);
 	}
 
	if (($name == 'a') AND isset($attrs['href'])) {
   	   $precedent = isset($titles[$attrs['href']]) ? $titles[$attrs['href']] : '';
   	   if (!isset($attrs['title'])) {
     	      if(!$precedent)                
                 $precedent = 'Lien ' . (count($titles)+1);
     
              $attrs['title'] = $precedent;
           }else{
      	      if(($precedent) AND ($attrs['title'] != $precedent))
                 $attrs['title'] = $precedent;          
      	      else
                 $precedent = $attrs['title']; 
           }
   
	   $titles[$attrs['href']] = $precedent;
         }
   
	 echo "<$name";
 	 foreach ($attrs as $k => $v) echo " $k='$v'";
 	 $ferme[$depth] = false;
     }

     // L'essentiel de la question 4 est fait ici
     function fermante($parser, $name)
     {
        global $depth, $ferme, $tables, $tableIndex;
 	if (($name == 'td') AND $tables[$tableIndex-1]) $name = 'th';
 	if (!$ferme[$depth]) 
   	   echo ' />';
 	else echo "</", $name, ">";
 
	if ($name == 'table') {unset($tables[$tableIndex  - 1]); $tableIndex--;};
 	$depth--;
 
	if ($name == 'tr') $tables[$tableIndex  - 1] = false; //la première ligne de la table courante est forcément déjà traitée
     }

     function texte($parser, $data)
     {
        global $depth, $ferme;
        if (!$ferme[$depth]) {
           echo '>';
   	   $ferme[$depth] = true;
        }
        echo $data;
     }

     //Tests
     function accessibiliser($file) {
        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, "ouvrante", "fermante");
        xml_set_character_data_handler($xml_parser, "texte");
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
        if (!($f = fopen($file, "r"))) {
          die("Impossible d'ouvrir le fichier '$file'");
        }

        while ($data = fread($f, 1024)) {
          if (!xml_parse($xml_parser, $data, feof($f))) {
            die(sprintf("erreur XML : %s ligne %d",
                        xml_error_string(xml_get_error_code($xml_parser)),
                        xml_get_current_line_number($xml_parser)));
          }
        }
        xml_parser_free($xml_parser);
     } 

     accessibiliser("test.html");   
     ?> 

Les balises input
-----------------

     <?php
     function ouvrante($parser, $name, $attrs)
     {
        global $depth, $ferme, $tables;
 	static $titles = $tables = $labels = array();

 	if (!$ferme[$depth]) {
   	   echo '>';
   	   $ferme[$depth] = true;
 	}
 	// La ligne suivante concerne la Question 4 + declaration global
 	if (($name == 'td') AND !isset($tables[$depth])) $name = 'th';
 	$depth++;
 	if (($name == 'img') AND !isset($attrs['alt'])) {
           $attrs['alt'] = basename($attrs['src']);
 	}
 	if (($name == 'a') AND isset($attrs['href'])) {
   	   $precedent = isset($titles[$attrs['href']]) ? $titles[$attrs['href']] : '';
   	   if (!isset($attrs['title']) OR ($precedent AND $precedent != $attrs['title'])) {
     	      if (!$precedent) $precedent = 'Lien ' . (count($titles)+1);
     	      $attrs['title'] = $precedent;
   	   }
   	   $titles[$attrs['href']] = $precedent;
   	   // Question 5
   	   // si pas de ID prendre name, bien que ca ne marche pas si repetition
        } elseif (($name == 'input') AND isset($attrs['name'])){
    	   $id = (isset($attrs['id']))?$attrs['id']:$attrs['name'];
    	   $attrs['id'] = $id;
    
	   if (!isset($labels[$id]) AND isset($attrs['value'])){
      	      echo "<label for='$id'>", $attrs['value'], "</label>";
    	   }  
 	} elseif ($name == 'label')
       	   $labels[$attrs['for']] = true;
  
	echo "<$name";
 	foreach ($attrs as $k => $v) echo " $k='$v'";
 	$ferme[$depth] = false;
     }    
     ?> 

Indentation du texte HTML
-------------------------

     <?php
     $contenu = array(" " => " ");
     $depth = " ";

     function ouvrante($parser, $name, $attrs)
     {
        global $depth, $contenu;
  	$t = $contenu[$depth];
  
	echo preg_replace("%[\n\t ]+$%", "", $t), "\n$depth";
  
	$contenu[$depth] = "";
  	$res = '';
  	foreach ($attrs as $k => $v) {
    	   $res .= "\n " . $depth . $k . "='" . addslashes($v) . "'";
    	}
  	echo "<" . $name . $res . ">";
  	$depth .= '  ';
  	$contenu[$depth]= "";
     }

     function fermante($parser, $name)
     {
        global $depth, $contenu;
  	$t = $contenu[$depth];
  	$depth = substr($depth, 2);
  	echo preg_replace("%[\n\t ]+$%", "\n$depth", $t);
  	echo "</", $name, ">";
     }

     function texte($parser, $data)
     {
        // en cas de texte de grande longueur, plusieurs appels de cette fonction se suivront.
 	global $contenu, $depth;
  	$contenu[$depth] .= $data;
     }

     //Tests
     /*function accessibiliser($file) {
        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, "ouvrante", "fermante");
        xml_set_character_data_handler($xml_parser, "texte");
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
        if (!($f = fopen($file, "r"))) {
          die("Impossible d'ouvrir le fichier '$file'");
        }

        while ($data = fread($f, 1024)) {
          if (!xml_parse($xml_parser, $data, feof($f))) {
            die(sprintf("erreur XML : %s ligne %d",
                        xml_error_string(xml_get_error_code($xml_parser)),
                        xml_get_current_line_number($xml_parser)));
          }
        }
        xml_parser_free($xml_parser);
     } */
     ?> 
