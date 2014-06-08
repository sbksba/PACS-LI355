<?php
include "pseudo_xml_vers_tableau.php";
# define('HTTPD_CONF', '/etc/apache2/httpd.conf'); // MacOSX
# define('HTTPD_CONF', '/etc/httpd/conf/httpd.conf'); // Linux
define('HTTPD_CONF', 'apache2.conf'); // copie de l'ARI
#define('HTTPD_CONF', 'apache2-default.conf'); // copie de l'ARI

$pile = array();

function ouvre($phraseur, $name, $attrs){
 global $pile;
 array_push($pile, $name);
}

function ferme($phraseur, $name){
 global $pile;
 array_pop($pile);
}

function enonce($phraseur,$texte){
 global $pile;
 echo count($pile), ' ', $texte, "\n";
}

function analyse_http_conf($path, $ouvre, $ferme, $enonce)
{
        $phraseur = xml_parser_create();
        xml_set_element_handler($phraseur, $ouvre, $ferme);
        xml_set_character_data_handler($phraseur, $enonce);
        xml_parser_set_option($phraseur, XML_OPTION_CASE_FOLDING, false);

        $file_conforme_xml = pseudo_xml_to_array_xml($path);

        foreach($file_conforme_xml as $l) {
              xml_parse($phraseur, $l, $l=='<CONF') or die (
                sprintf("Erreur XML : %s ! la ligne %d\n", 
                xml_error_string(xml_get_error_code($phraseur)),
                xml_get_current_line_number($phraseur))); 
        }
}

// Pour tester:
// analyse_http_conf(HTTPD_CONF, 'ouvre', 'ferme', 'enonce');
?>
