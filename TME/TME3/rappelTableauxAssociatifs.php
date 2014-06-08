<?php
error_reporting(E_ALL);
require_once('../2/entete.php');

echo entete("Tableaux");
echo "<body>\n";

$fruits = array("banane","pomme","litchie");
$fruits2 = array("banane"=>150,"pomme"=>300,"litchie"=>30);


echo '<h1>Avec une boucle for()</h1>';
echo "<ul>\n";
for ($i=0; $i <3; $i++){
        echo "<li>" . $fruits[$i] . "</li>\n";
}
echo "</ul>\n";


echo '<h1>Avec une boucle while()</h1>';
$i = 0;
echo "<ul>\n";
while ($i <3){
        echo "<li>" . $fruits[$i] . "</li>\n";
        $i++;
}
echo "</ul>\n";


//Pour l'affichage avec la boucle foreach on peut réutiliser
//la fonction array_to_list vu en TD 2
include('../../TD/2/array_to.php');
echo '<h1>Avec une boucle foreach()</h1>';
echo array_to_list($fruits);


/*Pour l'affichage avec la boucle foreach on peut réutiliser
la fonction arrayEnTableHTML vu en TD 3 qui se trouve dans 
le fichier ShowForm.php*/
include('../../TD/3/ShowForm.php');
echo '<h1>Calories</h1>';
echo "<h2>Tri par valeurs de calories croissantes</h2>\n";
asort($fruits2);
echo arrayEnTableHTML($fruits2, "Table tri&eacute;e par valeur");

echo '<h2>Tri par noms de fruits</h2>';
ksort($fruits2);
echo arrayEnTableHTML($fruits2, "Table tri&eacute;e par clef");


echo '</body></html>';
?>

