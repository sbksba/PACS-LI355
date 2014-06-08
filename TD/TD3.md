TD 3
====

Affichage des valeurs transmises
--------------------------------

     <?php
     // La fonction demandee est la meme qu'au TME 2
     // sauf qu'il faut neutraliser les caracteres speciaux des saisies.

     include('../../TM/2/tableau_en_table.php');

     function arrayEnTableHTML($t, $legende)
     {
	$r = array();
  	// Le tableau etant des saisies de l'utilisateur
  	// il faut se mefier de ce qu'il a pu ecrire comme "<" etc
  	// y compris pour les index qui peuvent resulter d'une query-string ad hoc
  	foreach ($t as $k => $v) $r[htmlspecialchars($k)] = htmlspecialchars($v);
  	// A l'inverse, la legende etant fournie par le programmeur
  	// on fait confiance aux chevrons qui y figurent, on ne transcode pas.
  	// cf exemple ci-dessous
  	return tableau_en_table($r, $legende);
     }

     function queryString ()
     {
	return "<p>". htmlspecialchars($_SERVER['QUERY_STRING']) . "</p>";
     }
     // Test
     // include('../../TM/2/entete.php');
     // echo entete('ShowForm'), '<body>';
     // echo queryString ();
     // echo arrayEnTableHTML($_GET, '<code>$_GET</code>');
     // echo '</body></html>';
     ?> 

Conception d un formulaire
--------------------------

     <?php
     error_reporting(E_ALL);
     require_once("../../TM/2/entete.php");
     require_once('ShowForm.php');
     echo entete("Etudiant");
     echo   "<body>\n","<h1>Etudiant</h1>\n";
     if (isset($_POST['mail']) AND isset($_POST['id']) AND 
     	!empty($_POST['mail']) AND !empty($_POST['id'])){
 	echo arrayEnTableHTML($_POST, "Informations");
     } else {
        echo "<form action='' method='post'><fieldset>\n",
   	"<label for='id'>Identifiant :</label>",
   	"<input id='id' name='id' />\n",
   	"<label for='mail'>Mail :</label>",
   	"<input id='mail' name='mail' />\n",
   	"<input type='submit' value='Envoyer'>\n",
   	"</fieldset></form>\n";
     }
     ?>
     </body>
     </html>

Controle des saisies
--------------------

     <?php
     require_once("../../TM/2/entete.php");
     error_reporting(E_ALL);
     require('ShowForm.php');

     function validerNuEtudiant($nu){
     	      return preg_match("/^[0-9]{7}$/", $nu);
     }

     function validerMail($mail){
     	      $re = '[A-Z][a-z]+';
 	      $re = "$re(-$re)?";
 	      // Ne pas écrire "/^$re[.]", PHP fait une erreur
 	      // si on veut [.] mettre "/^" . $r . "[.].....
 	      $re = "/^$re\.$re@etu\.upmc\.fr$/";

              return preg_match($re, $mail);
     }

     echo entete("Etudiant");
     echo   "<body>\n", "<h1>Etudiant</h1>\n";
     $mail = (isset($_POST['mail']) AND validerMail($_POST['mail']))? $_POST['mail'] : '';
     $id = (isset($_POST['id']) AND validerNuEtudiant($_POST['id']))? $_POST['id'] : '';

     if ($mail AND $id)
     	echo arrayEnTableHTML($_POST, "Informations &eacute;tudiant");
     else
	echo "<form action='' method='post'><fieldset>\n",
   	"<label for='id'>Identifiant :</label>",
   	"<input id='id' name='id' value='", htmlspecialchars($id), "' />\n",
   	"<label for='mail'>Mail :</label>",
   	"<input id='mail' name='mail' value='", htmlspecialchars($mail), "' />\n",
   	"<input type='submit' value='Envoyer'>\n",
   	"</fieldset></form>\n";

	echo "</body>\n","</html>\n";	
     ?> 

Saisies indicees
----------------

     <?php	
     require_once("../../TM/2/entete.php");
     error_reporting(E_ALL);

     $ens = array(
         'LI326',  'LI348',  'LI362',
         'LI314',  'LI328',  'LI350',  'LI355',
         'LI316',  'LI334',  'LI351',
         'LI320',  'LI335',  'LI353',
         'LI322',  'LI336',  'LI354',
         'LI323',  'LI339',  'LI369',
         'LI324',  'LI344',  'LI356',
         'LI325',  'LI345',  'LI357'
         );

     function arrayEnListeHTML($tableauPHP){
   	  $resultat = "";
  	  foreach($tableauPHP as $k => $v){ 
  	      $resultat .=  "<li>$k</li>";
          }
  	  return  $resultat ? "<ul>$resultat</ul>" : '';
     }

     echo entete("Enseignements");
     echo   "<body>\n","<h1>Enseignements</h1>\n";

     if (empty($_POST['ens'])) {
     	echo "<form action='' method='post'><fieldset>\n",
   	"<label for='ens'>Enseignements :</label><ul>";
  	foreach($ens as $nom)
    		     echo "<li><input id='ens-$nom' name='ens[$nom]' type='checkbox' /> $nom</li>\n";
         echo   "</ul><input type='submit' value='Envoyer'>\n</fieldset></form>\n";
     } else {
       	 echo arrayEnListeHTML($_POST['ens']);  
     }
     ?>
     </body>
     </html> 

Gestion des notes des etudiants (1/2)
-------------------------------------

     <?php // entrerNotes.php
     require_once("../../TM/2/entete.php");
     error_reporting(E_ALL);

     define("NBTD", 4);

     $listeEtudiantsTDn=array("Dupond","Dupont","Castafiore","Haddock","Hergé","Milou","Tintin","Tournesol");

     echo entete("Formulaires numTD puis notes");

     echo   "<body>\n";

     if (empty($_GET['td']) OR ($_GET['td'] > NBTD)) {
     	#echo "vous avez peut-être oublié d'envoyer le formulaire"."\n";
     	#echo "ou vous avez oublié de rentrer le numéro d'un TD"."\n";
     	#echo "ou le TD ".$_GET['td']." n'existe pas"."\n";
    	echo '<form action="entrerNotes.php" method="get"><fieldset>';
    	echo "<label for='td'>groupe de TD</label>\n";
    	echo "<input type='text' size ='2' name='td' id='td'> <br />\n";
    	echo '<input type="submit" value="Envoyer"> <br />';
    	echo '</fieldset></form>';
     } else {
        echo "<form action='notesEntrees.php' method='post'>\n";
  	echo '<table>';
  	echo "<tr> <th>Nom</th><th>Note</th></tr>\n";
  	for ($i=0; $i<count($listeEtudiantsTDn); $i++) {
    	    echo "<tr style='background-color:#", ($i%2 ? 777 : 999) . "'>\n";
    	    echo "<td><input type='text' size ='10' name='etu[]' value='";
    	    echo $listeEtudiantsTDn[$i]. "'>";
    	    echo "</td>\n<td> <input type='text' size ='5' name='note[]'>";
    	    echo "</td></tr><br />\n";
        }
  	echo '</table>';
  	echo "<div><input type='submit' value='Envoyer'> </div>\n";   
  	echo '<form>';
      }
      echo "</body></html>\n"
      ?> 

Gestion des notes des etudiants (2/2)
-------------------------------------

     <?php // notesEntrees.php
     require_once("../../TM/2/entete.php");
     error_reporting(E_ALL);

     function noteValide($note){
     	      return preg_match("/^(([0-1]?[0-9])|20)(\.(25|50|5|75))?$/",$note);
     }
  
     function moyenne($notes){
     	      $nombreNoteValides  = 0;
    	      $somme              = 0;
    
	      for ($i=0; $i<count($notes); $i++) {
      	      	  if(noteValide($notes[$i])){
			$nombreNoteValides++;
        		$somme = $somme + $notes[$i];
                  }
               }    
    	       return $somme / $nombreNoteValides;
     }
  
     function notesNonValidesEnListe($etudiants, $notes){
     	      $liste = "";
    
	      for ($i=0; $i<count($notes); $i++) {
     	          if (!noteValide($notes[$i])){
               	      $liste .= "<li>Etudiant " . $etudiants[$i] . " : note invalide.</li>";
                  }
    	       }
    	       return $liste ? "<ul>$liste</ul>" : '';
     }
  
     function genererTableHTML($etudiants, $notes){
    
		if (count($etudiants) != count($notes)){
    		      return "<p>Erreur : le nombre de notes est différent du nombre des étudiants.</p>";
  		} else {
    		      $table = "";
    		      for ($i=0; $i<count($etudiants); $i++) {
      		           $c = ($i%2 ? 777 : 999);
      			   $e = $etudiants[$i];
      			   $n = $notes[$i];
      			   $table .= "<tr style='background-color:#$c'><td>$e</td><td>$n</td></tr>";
    		      }
    		      if (!$table) return '';
    		      return "<table summary=\"Notes étudiants\">\n"
      		      . "<caption>Notes étudiants</caption>\n"
      		      ." <tr><th>Nom</th><th>Note</th></tr>\n"
      		      . $table
      		      . "</table>";
  		}    
     }

     echo entete("Les notes et la moyenne obtenue");
     echo   "<body>\n";
     if (isset($_POST["etu"])) {
     	echo genererTableHTML($_POST["etu"], $_POST["note"]);
  	echo "<div>Moyenne obtenue : ", moyenne($_POST["note"]), "</div>";
  	echo notesNonValidesEnListe($_POST["etu"], $_POST["note"]);
     } else "<div>Aucune note</div>";
     ?>
     </body>
     </html> 
