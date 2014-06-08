<?php
error_reporting(E_ALL);
require_once('../2/entete.php');

function afficheCouleur($couleur){
  $c = (strcmp($couleur,"Rouge") == 0) ? "#ff0000"
  :   ((strcmp($couleur,"Vert") == 0) ? "#00ff00"
       :   ((strcmp($couleur,"Bleu") == 0) ? "#0000ff"
	    :   ((strcmp($couleur,"Jaune") == 0) ? "#ffff00"
		 :   ((strcmp($couleur,"Noir") == 0) ? "#000000" 
		      :   "#888888")))); // Par défaut couleur "gris"

  return "<div style='height:10px;width:10px;background-color:$c'>&nbsp;</div>";
}

echo entete("Couleurs");

echo "<body>\n";

if (isset($_POST["couleurs"])){
	foreach ($_POST["couleurs"] as $coul){
		// echo "<div>$coul</div>"; // Question 3
		echo afficheCouleur($coul); // Question 5
	}
}
?>
<h1>Sélection de couleur</h1>
<form action="" method="post">
	<select multiple="multiple" name="couleurs[]" size="4">
		<option>Rouge</option>
		<option selected="selected">Vert</option><!-- Question 2 -->
		<option>Bleu</option>
		<option>Jaune</option>
		<option disabled="disabled">Noir</option>
		<option>Gris</option>
	</select>
	<input type="submit" name="sub-mite" value="Afficher les couleurs !"/>
</form>
</body>
</html>
