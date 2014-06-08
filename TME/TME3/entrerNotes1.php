<?php
define('MAX_ID',12);

require_once('../2/entete.php');

function creerForm($val='') {
  return
    "<form action='' method='get'><fieldset>\n" .
    "<label>Numero de groupe : </label>\n" .
    "<input type='text' name='etu_id' value='$val' />\n" .
    "<input type='submit' />\n" .
    "</fieldset></form>\n";
}


echo entete("Saisir Notes");
echo "<body>\n";

if ( empty($_GET)  ) {
  echo creerForm();
} else {
  if ( isset($_GET['etu_id']) ) {
    $num = intval($_GET['etu_id']);
    if (!$num) {
      echo '<div>Le groupe ne peut etre vide</div>';
    } else if ( $num > MAX_ID  ) {
      echo '<div>Numero de groupe trop grand</div>';
    }
    echo creerForm($num);
  }
}

echo "</body></html>";

?>
