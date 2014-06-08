<?php
// entrerNotes.php

define("NBTD", 24);
$listeEtudiantsTDn=array("Dupond","Dupont","Castafiore","Haddock","Hergé",
"Milou","Tintin","Tournesol");

error_reporting(E_ALL);
require_once('../2/entete.php');
require_once('utilitaires.php');

echo entete("Entrer Notes");

echo   "<body>\n"."<h1>Notes entr&eacute;es</h1>\n";

if (!isset($_GET["td"]) ||  ($_GET["td"]=="") || ($_GET["td"]> NBTD)) {
     #echo "vous avez peut-être oublié d'envoyer le formulaire"."\n";
     #echo "ou vous avez oublié de rentrer le numéro d'un TD"."\n";
     #echo "ou le TD ".$_GET['td']." n'existe pas"."\n";
    echo '<form action="entrerNotes.php" method="get">';
    echo 'groupe de TD ? <input type="text" size ="2" name="td"> <br />';
    echo '<input type="submit" value="Envoyer"> <br />';
    echo '</form>';
  }
  else {
    echo '<form action="notesEntrees.php" method="post"><br />'."\n";
    echo '<table border="1">';
    echo '<tr> <th>Nom</th><th>Note</th></tr>';
    for ($i=0; $i<count($listeEtudiantsTDn); $i++) {
      echo '<tr><td><input type="text" size ="10" name="etu[]" value="';
      echo $listeEtudiantsTDn[$i]. '">';
      echo '</td><td> <input type="text" size ="5" name="note[]">';
      echo '</td></tr><br />',"\n";
    }
    echo '</table>';
    echo '<input type="submit" value="Envoyer"> <br />';   
    echo '<form>';
  }
?>
</body>
</html>

<?php
//notesEntrees.php

error_reporting(E_ALL);
require_once('../2/entete.php');
require_once('utilitaires.php');

define("RE_VALIDER_NOTE", "/^\s*([0-1]?[0-9](\.(25|50|5|75))?|20)\s*$/");

echo entete("Notes entr&eacute;es") . "<body>\n";
?>
<table><tr> <th>Nom</th><th>Note</th></tr>
<?php
  function noteValide($note){
    return preg_match(RE_VALIDER_NOTE,$note); 
  }
  
  $ch=""; 
  $som=0;
  $nbrEtu=0;
  for ($i=0; $i<count($_POST["etu"]); $i++) {
    echo '<tr><td>'. $_POST["etu"][$i];
    echo '</td><td>'.$_POST["note"][$i].'</td></tr><br />'."\n";
    if (!($_POST["note"][$i]=="")) {
      if  (noteValide($_POST["note"][$i])){
	  $som=$som + $_POST["note"][$i];
	  $nbrEtu=$nbrEtu+1;
      }
      else {
	$ch.="La note ". $_POST["note"][$i]. " de l'étudiant ".$_POST["etu"][$i] ;
	$ch.=" n'est pas valide"."<br />";
      }
    }
  }
  echo '</table>';
  if ($nbrEtu==0){
    echo "Aucun étudiant n'a de note"."<br />";
  }
  else {
    echo "<br />"."Moyenne obtenue :". ($som/$nbrEtu)."<br />"."<br />";
  }
  echo $ch;
?>
</body>
</html>
