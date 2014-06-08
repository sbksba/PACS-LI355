TD 2
====

Tableaux en PHP
---------------

     <?php
     // 1.
     $Candidats = array("candidatB","candidatA","candidatC");

     // 2. A
     asort($Candidats);
     echo "<h1>Liste avec for</h1>\n<ul>\n";
     for ($i =0; $i<count($Candidats); $i++) {
      echo "<li>", $Candidats[$i], "</li>\n";
     }
     echo "</ul>\n";

     // 2. B
     echo "<h1>Liste avec while</h1>\n<ul>\n";
     $i=0;
     while ($i < count($Candidats)) {
     	    echo "<li>", $Candidats[$i], "</li>\n";
      	    $i=$i+1;
     }
     echo "</ul>\n";

     // 2. C
     echo "<h1>Liste avec foreach</h1>\n<ul>\n";
     foreach ($Candidats as $elt) {
     	     echo "<li>", $elt, "</li>\n" ;
     }
     echo "</ul>\n";  
     // 2. D
     // La fonction asort conservant la relation entre une valeur et son index
     // l'usage de For ou While provoquera l'affichage dans l'ordre d'origine,
     // tandis que Foreach affichera bien par ordre alphabetique.

     // 3.
     $Scores = array("candidatA"=>130,"candidatB"=>300,"candidatC"=>30);

     // 4. 
     asort($Scores);
     echo "<table>\n";
     echo "<caption>Tableau par scores croisssants</caption>\n";
     echo "<tr>\n<th>Nom</th>\n<th>Score</th>\n</tr>\n";
     foreach ($Scores as $k => $v) {
     	     echo "<tr>\n<td>", $k, "</td>\n<td>", $v, "</td>\n</tr>\n" ;
     }
     echo "</table>\n";

     // 5.
     ksort($Scores);
     echo "<table>\n";
     echo "<caption>Tableau par ordre alphabétique</caption>\n";
     echo "<tr>\n<th>Nom</th>÷n<th>Score</th>÷n</tr>\n";
     foreach ($Scores as $k => $v) {
     	     echo "<tr>\n<td>", $k, "</td>\n<td>", $v, "</td>\n</tr>\n" ;
     }
     echo "</table>\n";
     ?>

Fonctions en PHP
----------------

     <?php
     // 1
     // Remarque: cette fonction est diponible en PHP sous le nom de "join"
     function array_to_string($tab){
     	      $chaine = "";
  	      foreach($tab as $v)
    	      		   $chaine .= " $v";
  	      return substr($chaine,1);
     }
     // 2.
     function array_to_list($tab){
     	      $chaine = "";
  	      foreach($tab as $v)
    	      		   $chaine .= "<li>$v</li>\n";
              return $chaine ? "<ol>$chaine</ol>\n" : '';
     }
     // 3.
     function array_to_table($tab){
     	      if (!$tab) return '';
  	      $chaine = "";
  	      foreach($tab as $k => $v)
    	      		   $chaine .= "<tr>\n<td>$k</td>\n<td>$v</td>\n</tr>\n";
              $th = "<tr>\n<td>Index</td>\n<td>Valeur</td>\n</tr>\n";
   	      return "<table>\n<caption>Table</caption$th$chaine$th</table>\n";
     }

     // tests
     // $Scores = array("candidatA"=>130,"candidatB"=>300,"candidatC"=>30);
     // echo array_to_string($Scores);
     // echo array_to_list($Scores);
     // echo array_to_table($Scores);
     ?>

Arguments variables des fonctions
---------------------------------

     <?php
     // 1 .
     function array_to_string($tab, $max=80){
     	      $chaine = "";
  	      foreach($tab as $v) {
    	      		   if (strlen($chaine) + strlen($v) > $max) break;
    			   $chaine .= " $v";
              }
  	      return substr($chaine,1);
     }
     // 2.
     function mult_vect ($vect, $other){
     	      if(is_array($other)){
		if(count($vect)!=count($other)){
			return array();
                }
    		$scal=0;
    		for ($i=0; $i<count($vect); $i++) {
       		    $scal+=$vect[$i]*$other[$i];
                }
    		return $scal;
              }
  	      else{
		foreach($vect as $k => $v){
      			      $vect[$k] = $v * $other;
                }
    		return $vect;
    	      }
     }
     // Tests
     // echo "\nPremier tableau :";
     // $tab=array(10, 20, 30, 40, 50);
     // echo array_to_string($tab);
     // $t=array(5, 4, 3, 2, 1);                               
     // echo "\nSecond tableau :";
     // echo array_to_string($t);
     // echo "\nProduit scalaire : ".mult_vect ($tab,$t)."\n";
     // echo "\nMultiplication des éléments du tableau par 3:\n";
     // echo array_to_string(mult_vect ($tab,3));
     // echo "\n";
     ?> 

Syntaxe des expressions regulieres
----------------------------------

     <?php
     // 1.
     define('RE_NUMERO', "/Numéro d'étudiant : ([1-9][0-9]{6})[^0-9]/"); 

     // 2. le "s" final force l'acceptation de \n par le motif "."
     // il n'est pas necessaire si la chaine n'en contient pas
     define('RE_OREMUN', "/^.*Numéro d'étudiant : ([1-9][0-9]{6})[^0-9]/s"); 

     // define('RE_TEST', 
     //     "Numéro d'étudiant : 123,
     //         Numéro d'étudiant : 2456783,
     //         Numéro d'étudiant : 457894566,
     //         Numéro d'étudiant : 4510236,
     //         Numéro d'étudiant : 01234567");
     // 
     // if (preg_match(RE_NUMERO, RE_TEST, $m)) echo $m[1], "\n";
     // if (preg_match(RE_OREMUN, RE_TEST, $m)) echo $m[1], "\n";
     ?> 

Expressions regulieres en PHP
-----------------------------

     <?php

     define('RE_MAIL', '/^([A-Z][a-z]+(-[A-Z][a-z]+)?)\.([A-Z][a-z]+(-[A-Z][a-z]+)?)@etu\.upmc\.fr$/');

     function titulaire_mail($mail) {
     	      if (preg_match(RE_MAIL, $mail, $m))
      	      	 return $m[1] . ' ' . $m[3];
  	      return false;
     }

     $test = array("Anne@etu.upmc.fr",
     //         "Anne-Marie.Manne-Ari@etu.upmc.fr",	
     //         "Anne.Manne-Arie@etu.upmc.fr",
     //         "Anne.Manne@etu.upmc.fr",
     //         "Anne-Marie.Manne@etu.upmc.fr",
     //         "A.B@etu.upmc.fr",
     //         "Rien");
     // 
     // for ($i =0; $i<count($test); $i++)
     //   echo $test[$i], "\t", titulaire_mail($test[$i]), "\n";
     ?> 

Expressions rationnelles a plusieurs solutions
----------------------------------------------

     <?php
     define('RE_HORAIRE', "%(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])%");

     function horaires($calendrier)
     {
	if (preg_match_all(RE_HORAIRE, $calendrier, $m) != 2)
    	   return array();
  	return $m[0][0] . '-' . $m[0][1];
     }

     //$test = array(
     //  "05:24 Avez-vous l'heure ? il est 10:12 22:64, 32:24, 0:56, 12:32, 12:58",
     //  "venez entre 10:12 et 22:54",
     //           );
     //  for ($i =0; $i<count($test); $i++)
     //    echo $test[$i], "\t", horaires($test[$i]), "\n";
     ?> 
