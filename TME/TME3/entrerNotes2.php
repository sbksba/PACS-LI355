<?php
define('MAX_ID',2);
require_once('../2/entete.php');
global $etudiants;
$etudiants = array(
              array('bob', 'john'),                // groupe 1
              array('alice','bob','stef','arthur') // groupe 2
            ); 

function creerForm($val='') {
  return
    "<form action='' method='get'><fieldset>\n" .
    "<label>Numero de groupe : </label>\n" .
    "<input type='text' name='etu_id' value='$val' />\n" .
    "<input type='submit' />\n" .
    "</fieldset></form>\n";
}

//$n étant le numéro du groupe
function creerFormEtudiants($n) {
       global $etudiants;
       $grp = $etudiants[$n-1];
       $form='';
       for ($i=0;$i<count($grp);$i++) {
               $form .= "<div><label for='etu$i'>Etudiant ".$grp[$i]." </label>"
               . "<input type='text' name='etu$i' id='etu$i' /></div>\n";
       }
       return "<form action='notesEntrees.php' method='post'><fieldset>\n" .
	 $form .
	 "<input type='hidden' name='grp' value='$n' />\n" .
	 "<input type='submit' />\n</fieldset></form>\n";
}


echo entete("Saisir Notes");
echo "<body>\n";

if ( empty($_GET)  ) {
       echo creerForm();
} else {
       if ( isset($_GET['etu_id']) ) {
               $num = intval($_GET['etu_id']);
               if ( !$num) {
                       echo '<div>Le groupe ne peut etre nul</div>';
                       echo creerForm();
               } else if ($num > MAX_ID  ) {
                       echo '<div>Numero de groupe trop grand</div>';
                       echo creerForm();
               } else {
                       echo creerFormEtudiants($num);
               }
       }
}

echo "</body>\n</html>";
?>