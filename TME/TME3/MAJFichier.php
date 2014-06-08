<?php
/********************************************************************
 * Quelques précisions concernant cet exercice. On suppose que le fichier 
 * à lire est un fichier texte de plusieurs lignes ou chaque ligne contient
 * le couple numéroEtudiant numéroTD (avec l'espace séparant le numéro étudiant 
 * et le numéro TD) 
 *
 * */   

//Question 1
function tabFromFich($nomFich) {
    /*La fonction "file" fait que les éléments du tableau $lignes sont 
      des chaînes terminées par "\n".*/
   
  $lignes = is_readable($nomFich) ? file($nomFich) : array(); 

  // Il faut supprimer ces caractères parasites
   
  for ($i = 0; $i < count($lignes); $i++ ) {
       $lignes[$i] = rtrim($lignes[$i]);
   }
   
   /* Il faut décomposer chaque ligne en un tableau à deux éléments 
      (ici appelé $tabligne). On peut alors inscrire le couple clef-valeur 
      dans le tableau associatif  $clefVal créé pour l'occasion. 
   */
  $clefVal = array();
   foreach ( $lignes as $lg ) {
        $tabligne = explode(" ", $lg);
        $clefVal[$tabligne[0]] = $tabligne[1];
   }

   // et on renvoie comme valeur le tableau $Clef_Val  rempli.
   return $clefVal;
} // fin du texte de la fonction tabFromFich

//Question 2
function TDdeEtudiant($nomFichier, $numeroEtudiant){
  $tabClefVal = tabFromFich($nomFichier);
  if($tabClefVal[$numeroEtudiant])
    return $tabClefVal[$numeroEtudiant];
  else
    return 0;
}

//Question 3
function ajoutEnFinFile($nomFich,$nuEtu, $TD){
   $lignes = is_readable($nomFich) ? file($nomFich) : array(); 
   $lignes[count($lignes)]=$nuEtu." ".$TD."\n";
   $fichier =@fopen($nomFich,"w");
   foreach ($lignes as $lg){
     fputs($fichier, $lg);
   }
   fclose($fichier);
}//fin du texte de ajoutEnFinFile

// Pour tester l'ajout dans le fichier des inscrits:

error_reporting(E_ALL);
require_once('../2/entete.php');
require_once('utilitaires.php');

echo entete("MAJ Fichier");

define ("FICHIER_ETUDIANTS", "etudiants.txt");

echo "<body>\n"."<h1> Etat initial </h1>\n";
echo arrayEnTableHTML(tabFromFich("fichierInscrits.txt"));

echo "<h1>Insertions</h1>"; 
for ($i=0; $i<5;$i++){
       $nuEtu="";
       for ($j=0;$j<7;$j++) $nuEtu=$nuEtu.rand(0,9);
       $TD="TD".rand(1,4);
       echo "<p>Etudiant : ", $nuEtu, " inscrit dans le ", $TD, "</p>\n";
       ajoutEnFinFile("fichierInscrits.txt",$nuEtu,$TD);
}
echo "<h1> Etat final </h1>"; 
echo arrayEnTableHTML(tabFromFich("fichierInscrits.txt"));
echo "</body></html>\n";
?>

<?php
// Deuxieme version du fichier Inscrire Etudiant
// MAJ du fichier d'étudiants

error_reporting(E_ALL);
require_once('../2/entete.php');
require_once('utilitaires.php');
include "MAJFichier.php"; 

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
     $numEtu = $_GET["numero"];
     $numTD  = $_GET["TD"];
     
     if(TDdeEtudiant(FICHIER_ETUDIANTS, $numEtu)){
      echo "<p> Etudiant déjà inscrit</p>";
     }else{
      ajoutEnFinFile(FICHIER_ETUDIANTS, $numEtu, $numTD);
     }
 }
 else {

   if (empty ($_GET["numero"]))
     echo "<p>Vous avez omis de rentrer l'<strong>identifiant</strong></p>";

   if (empty ($_GET["TD"]) OR (!intval($_GET["TD"])))
     echo "<p>Vous avez omis de rentrer le <strong>TD</strong><p>";

   echo genereFormulaire(10);
 }

}

