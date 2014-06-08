<?php

define('RE_SECUSOC', '/\b[12]\d{13}\b/');
define('RE_HORAIRES', "/([0-1][0-9]|2[0-3]):([0-5][0-9])/");
define('RE_MAILETU', '/[a-z\'-]+@etu\.upmc\.fr/i');
define('RE_NOTE', "@\b([0-9]|1[0-9]|20)(/20)?\b@");

function listeOccurrences($regexp, $texte){
        if (preg_match_all($regexp, $texte, $res)){
	  return tableau_en_table($res[0], "$regexp $texte");
        } return "<div>$texte ne correspond pas au motif $regexp</div>";
}

define('TEST_SECUSOC', '12345678901234 02345678901234 123456789012345');
define('TEST_HORAIRES', "12:34, 05:18 et 23:14 et ensuite une heure erronée 77:17");
define('TEST_MAILETU', "l'elu@etu.upmc.fr saint-eloi@etu.upmc.fr faux@etu_umpc_fr");
define('TEST_NOTE', "20, 18/20 et 7/20 7.5");

// test
//include('entete.php');
//include('tableau_en_table.php');
// echo entete('Expressions rationnelles statiques');
// echo listeOccurrences(RE_SECUSOC, TEST_SECUSOC);
// echo listeOccurrences(RE_HORAIRES, TEST_HORAIRES);
// echo listeOccurrences(RE_MAILETU, TEST_MAILETU);
// echo listeOccurrences(RE_NOTE, TEST_NOTE);
// echo listeOccurrences(RE_NOTE, '21');
?>
