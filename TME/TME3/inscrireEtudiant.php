<?php 
/***********************************************************************
 *  Quelques précisions concernant cet exercice. Le formulaire à créer 
 *  doit contenir un champ de saisi "numéro étudiant" et un autre champ 
 *  de sélection (1..N) pour le numéro du groupe TD "TD". N étant le 
 *  nombre de groupes de TD. Les données sont à soumettre avec la méthode 
 *  GET. 
 *
 * */  

error_reporting(E_ALL);
require_once('../2/entete.php');
require_once('utilitaires.php');

echo entete("Inscription");

echo "<body>\n";

echo '<h1>QUERY_STRING </h1>';

echo $_SERVER['QUERY_STRING'];

echo '<h1>$_GET </h1>';

echo arrayEnTableHTML($_GET);

?>
</body>
</html>

<?php
// Deuxieme version
// la génération du formulaire est intégrée dans le script qui le traite

error_reporting(E_ALL);
require_once('../2/entete.php');
require_once('utilitaires.php');

echo entete("Inscription") . "\n<body>\n";

// le formulaire html
function genereFormulaire($nbreTD){
 $ch = "<option value='TD?'>TD?</option>\n";

 for ($i=1; $i<=$nbreTD; $i++){
   $ch .="<option>TD$i</option>\n";
 }
 
 return "<h1>Inscription</h1>\n" .
   "<form action=''><fieldset>\n" .
   "<label for='numero'>Identifiant : </label>\n" .
   "<input type='text' name='numero' id='numero'/>\n" .
   "<label for='td'> Groupe de TD :</label>\n" .
   "<select id='td' name='TD'>\n" .
   $ch .
   "</select>\n" .
   "<p><input type='submit' name ='envoi' value='Envoyer' /></p>\n" .
   "</fieldset></form>\n";
}

if (!isset($_GET["envoi"])) { //envoi du formulaire pour la première fois
  echo 'Valeur de !isset($_GET["envoi"] : ' .!isset($_GET["envoi"])."<br/>\n";
  echo  "Premier envoi du formulaire";
  echo genereFormulaire(10);
  }

else { // le formulaire a déjà été envoyé

 // Quelles données ai-je reçues ?
 echo '<h1> Contenu de $_GET </h1>'."\n";
 echo arrayEnTableHTML($_GET);

 // Je vérifie que le champ des données n'est pas vide
 if (!empty($_GET["numero"]) && ($_GET["TD"] <> "TD?")){
     echo "Enregistrement de la demande d'inscription <br/>\n";
     echo "L'inscription de ".$_GET["numero"]." faite";
 }
 else {

   if (empty ($_GET["numero"]))
     echo "Vous avez omis de rentrer l'<strong>identifiant</strong><p/>";

   if (empty ($_GET["TD"]) OR (!intval($_GET["TD"])))
     echo "Vous avez omis de rentrer le <strong>TD</strong><p/>";

   echo genereFormulaire(10);
 }

}//fin du else indiquant que le formulaire a bien été envoyé
/*
Pour en faire plus, vous pouvez améliorer le programme précédent :
- en travaillant, non pas sur deux champs, mais sur une dizaine de champs ;
- en travaillant sur un formulaire où des champs doivent être obligatoirement 
  remplis et d’autres non ;
- si, le formulaire doit être reproposé car des champs n’ont pas été remplis, 
les champs, qui ont eux été correctement remplis, restent remplis avec la 
valeur initiale.
*/
?>
</body>
</html>
