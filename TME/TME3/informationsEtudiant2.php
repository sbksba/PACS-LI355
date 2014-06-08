<?php
/******************************************************************************
 *  Quelques précisions concernant cet exercice.
 *  Pour tester le bon fonctionnement
 *  de ce script il faut inclure le formulaire créé dans l'exercice précédent. 
 *
 * */   

error_reporting(E_ALL);
require_once('../2/entete.php');
require_once('utilitaires.php');

echo entete("Informations Etudiant");

echo "<body>\n";
;
?>

<h1> Données par $_POST </h1>

<?php  echo arrayEnTableHTML($_POST); ?>

</body>
</html>


<?php
/*********************************************************************************
 * Réponse à la deuxième question
 *
 * */  
error_reporting(E_ALL);
require_once('../2/entete.php');
require_once('utilitaires.php');

echo entete("Informations Etudiant");

echo "<body>\n";

// Je vérifie que le champ des données n'est pas vide 
// (remplissage formulaire valide)
if (!empty($_POST["numero"]) && !empty($_POST["mail"]) && 
    (!empty($_POST["envoiMail"]) || !empty($_POST["soumission"]))) {
     echo "j'ai bien enregistré la demande d'inscription <br/>\n";
     echo "L'inscription de l'étudiant ",
       $_POST["numero"],
       " va être enregistrée";
}else{ //remplissage formulaire non valide, alors le réafficher
   echo "<form action = 'inscrireEtudiant2.php' method='post'><fieldset>\n",
	"<label for='i1'> Numéro de la carte d'étudiant :</label>\n",
	"<input type='text' name ='numero' id='i1' />\n",
	"<label for='i2'> Mail :</label>\n",
	"<input type='text' name ='mail' id='i2' />\n",
	"<label for='i3'> Envoi par mail :</label>\n",
	"<input type='checkbox' name='envoiMail' id='i3' />\n",
	"<label for='i4'> Soumission :</label>\n",
	"<input type='checkbox' name='soumission' id='i4' />\n",
	"<input type='submit' value='Envoyer' />\n",
        "</fieldset></form>";  
 }
?>
</body>
</html>
