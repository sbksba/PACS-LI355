TD 6
====

Ecriture de DTD
---------------

     <!ELEMENT annuaire      (elemcarnet*)>
     <!ELEMENT elemcarnet    (personne, adresse, telephone) >
     <!ELEMENT personne      (nom, prenom) >
     <!ELEMENT adresse       (rue, ville) >
     <!ELEMENT telephone     EMPTY >
     <!ELEMENT nom           (#PCDATA) >
     <!ELEMENT prenom        (#PCDATA) >
     <!ELEMENT rue           (#PCDATA) >
     <!ELEMENT ville         (#PCDATA) >

     <!ATTLIST elemcarnet
         date         CDATA   #REQUIRED>
     <!ATTLIST personne 
         sexe         (F|M)   #REQUIRED>
     <!ATTLIST rue 
         numero       CDATA   #REQUIRED>
     <!ATTLIST ville  
         codepostal   CDATA   #REQUIRED>

     <!ATTLIST telephone  
         fixe         CDATA   #REQUIRED
         mobile       CDATA   #REQUIRED>

Conformite d'un document XML
----------------------------

     <?php

     function lancer_phraseur($fichier){
     	$xml_phraseur = xml_parser_create();  
  
	// Les noms de balise et attributs ne doivent pas passer en majuscules
  	// automatiquement car XHTML ne le fait pas.
  	xml_parser_set_option($xml_phraseur, XML_OPTION_CASE_FOLDING, 0);
  
	// Ouverture et analyse du fichier
  	if (!$fp = fopen($fichier,'r'))
    	   return array(false, false);
  
        while ($data = fread($fp,256)){
      	   if(!xml_parse($xml_phraseur, $data, feof($fp))) 
      	      return array($xml_phraseur, true);     
        }
  
	return array($xml_phraseur, false);
      }


      function get_xml_error_as_string($xml_phraseur){
         return "Erreur XML : ".xml_error_string(xml_get_error_code($xml_phraseur)).
    	 " ligne ".xml_get_current_line_number($xml_phraseur);
      }

      $fichier = "annuaire.xml";

      list($phraseur, $si_erreur) = lancer_phraseur($fichier);

      if(!$phraseur){
          echo "impossible de lire le fichier ", $fichier;
      }else if ($si_erreur){
          echo get_xml_error_as_string($phraseur); 
      }else {
          echo "Le fichier XML ", $fichier, " est bien form&eacute;";
      }
      ?> 

Gestion des evenements avec SAX
-------------------------------

     <?php
     include("entete.php");
     echo entete("Analyse d'un fichier XML d'annuaire");
     echo "<body>";

     function ouverture($parser, $name, $attrs){
        echo "<div style='color:green'>Ouverture de : </div>";
        echo "&lt;$name " ;
        foreach ($attrs as $cle=>$valeur){
            echo "$cle='" . $valeur . "' ";
        }
        echo "&gt;<br/>\n";
     }

     function fermeture($parser, $name){
        echo "<div style='color:red'>Fermeture de : </div>";
        echo "&lt;/$name&gt;<br/>\n";
     }
    
     function texte($parser, $data){
        if (trim($data) == ""){
            echo "<div style='color:orange'>Saut de ligne</div>";
        } else {
            echo "<div style='color:blue'>R&eacute;ception du texte : </div>";
            echo $data . "<br/>\n";
        }
     }

     function lancer_phraseur($fichier){
     	$xml_phraseur = xml_parser_create();  
    
        // Les noms de balise et attributs ne doivent pas passer en majuscules
    	// automatiquement car XHTML ne le fait pas.
    	xml_parser_set_option($xml_phraseur, XML_OPTION_CASE_FOLDING, 0);
    	xml_set_element_handler($xml_phraseur, "ouverture", "fermeture");
    	xml_set_character_data_handler($xml_phraseur, "texte");
    
	// Ouverture et analyse du fichier
    	if (!$fp = fopen($fichier,'r'))
           return array(false, false);
    
        while ($data = fread($fp,256)){
           if(!xml_parse($xml_phraseur, $data, feof($fp))) 
              return array($xml_phraseur, true);     
        }
    
	return array($xml_phraseur, false);
     }

     function get_xml_error_as_string($xml_phraseur){
        return "Erreur XML : ".xml_error_string(xml_get_error_code($xml_phraseur)).
        " ligne ".xml_get_current_line_number($xml_phraseur);
     }

     list($phraseur, $si_erreur) = lancer_phraseur($fichier);
     if(!$phraseur){
	echo "impossible de lire le fichier ", $fichier;
     }else if ($si_erreur){
        echo get_xml_error_as_string($phraseur); 
     }
     ?>
     </body>
     </html> 

Extraction de contenu avec variables globales
---------------------------------------------

     <?php
     /*
      * Preneur sur les ouvertures de balises
      */
      function ouverture($p, $name, $attrs){
    
        global $personne, $contenu;
        // Rechercher si Mme ou M.
    
        if ($name == "personne"){
            if (!isset($attrs['sexe'])){
                die ("Erreur XML : pas d'attribut sexe<br/>");
            } else {
              $personne = ($attrs['sexe'] == "M")?"M.":"Mme";
            }
        }
        // preparation de la lecture du contenu (nb etapes inconnu)
        $contenu = ""; 
      }

      /*
       * Preneur sur les fermetures de balises
       */ 
       function fermeture($p, $name){

           global $personne, $contenu;

           if ($name == "elemcarnet"){
            echo "<li>", $personne, "</li>\n";
           } else if (($name == "prenom" )||
             ($name == "nom" )||
             ($name == "fixe")||
             ($name == "mobile")){
                $personne .=  ' ' . $contenu;
           }
       }

      /*
       * Preneur sur les evenements de type "texte" 
       */ 
       function texte($p, $data_text){
         global $personne, $contenu;
         $contenu .= $data_text;
       }

      /*
       * Lancement du parsing
       */ 
       function lancer_phraseur($fichier){
            $xml_phraseur = xml_parser_create();  
  
            // Les noms de balise et attributs ne doivent pas passer en majuscules
  	    // automatiquement car XHTML ne le fait pas.
  	    xml_parser_set_option($xml_phraseur, XML_OPTION_CASE_FOLDING, 0);
  	    xml_set_element_handler($xml_phraseur, "ouverture", "fermeture");
  	    xml_set_character_data_handler($xml_phraseur, "texte");
  
	    // Ouverture et analyse du fichier
  	    if (!$fp = fopen($fichier,'r'))
    	       return array(false, false);
  
            while ($data = fread($fp,256)){
      	        if(!xml_parse($xml_phraseur, $data, feof($fp))) 
      		     return array($xml_phraseur, true);     
            }
  
	    return array($xml_phraseur, false);
      }

      function get_xml_error_as_string($xml_phraseur){
          return "Erreur XML : ".xml_error_string(xml_get_error_code($xml_phraseur)).
    	  " ligne ".xml_get_current_line_number($xml_phraseur);
      }

      include("entete.php");
      echo entete("Analyse d'un fichier XML d'annuaire");
      echo "<body>";
      ?>

      <h1>Liste des noms et telephones</h1>
      <ul>

      <?php    
      	$fichier = "annuaire.xml";
    
	list($phraseur, $si_erreur) = lancer_phraseur($fichier);
  
	if(!$phraseur){
    	    echo "Fichier ", $fichier, " introuvable. Analyse suspendue.";
        }else if ($si_erreur){
            echo get_xml_error_as_string($phraseur); 
        }
	?>
    	</ul>
	</body>
	</html> 

Extraction de contenu avec un objet PHP
---------------------------------------

      <?php

      class extraire {

          public $phraseur;         // instance du phraseur xml
    	  public $personne = "";
    	  public $contenu = "";

    
	/*
     	 * Constructeur par défaut du phraseur
     	 */
    	 function __construct(){
         	  $p = xml_parser_create();
      		  xml_set_object($p, $this);
        	  xml_set_element_handler($p, "ouverture", "fermeture");
        	  xml_set_character_data_handler($p, "texte");
        	  // phraseur sensible à la casse
        	  xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, false);
        	  $this->phraseur = $p;
          }

    	/*
     	 * Preneur sur les ouvertures de balises
         */
    	 function ouverture($p, $name, $attrs){
    
		// Rechercher si Mme ou M.
    
		if ($name == "personne"){
            	   if (!isset($attrs['sexe'])){
                      die ("Erreur XML : pas d'attribut sexe<br/>");
            	   } else {
              	      $this->personne = ($attrs['sexe'] == "M")?"M.":"Mme";
                   }
                }
        	// preparation de la lecture du contenu (nb etapes inconnu)
        	$this->contenu = ""; 
         }  

        /*
     	 * Preneur sur les fermetures de balises
     	 */ 
    	 function fermeture($p, $name){
            if ($name == "elemcarnet"){
               echo "<li>", $this->personne, "</li>\n";
            } else if (($name == "prenom" )||
              ($name == "nom" )||
              ($name == "fixe")||
              ($name == "mobile")){
                $this->personne .=  ' ' . $this->contenu;
            }
          }

	/*
         * Preneur sur les evenements de type "texte" 
     	 */ 
    	 function texte($p, $data_text){
            $this->contenu .= $data_text;
         }

      } // fin de la classe

      include("entete.php");
      echo entete("Analyse d'un fichier XML d'annuaire");
      echo "<body>";
      ?>

      <h1>Liste des noms et telephones</h1>
      <ul>

      <?php    
          $fp = fopen("annuaire.xml",'r') or 
            die ("Fichier introuvable; analyse suspendue");

          // Creation de l'objet
    	  $p = new extraire();
          /*
     	   * Analyse d'une chaine de caracteres
     	   */
    	   while ($data = fread($fp,256)) {
              xml_parse($p->phraseur, $data) or die (
              sprintf("Erreur XML : %s à la ligne %d\n", 
              xml_error_string(xml_get_error_code($p->phraseur)),
              xml_get_current_line_number($p->phraseur))
              );
           }
      ?>
      </ul>
      </body>
      </html> 
