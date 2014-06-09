TD 8
====

Les balises Link
----------------

     <?php
     function entete($title, $links = array())
     {
        $liens = '';
  	foreach ($links as $link) {
    	   $atts = '';
    	   foreach ($link as $k => $v) $atts .= " $k='$v'";
    	   $liens .= "<link$atts />\n";
  	}
  	return
    	"<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML Basic 1.1//EN'
        'http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd'>\n" .
    	"<html xmlns='http://www.w3.org/1999/xhtml' lang='fr'>\n" .
    	"<head>\n" .
    	"<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />\n" .
    	"<title>" . 
    	$title .
    	"</title>\n" .
    	$liens .
    	"</head>\n";
     }
     ?>

Securiser les choix
-------------------

     <?php
     define('RE_SECU', '/^[^<>"\']+$/');

     function get_securise($index, $t, $defaut='')
     {
        if (isset($t[$index]) AND preg_match(RE_SECU, $t[$index]))
    	   return $t[$index];
  	return $defaut;
     }
     ?>

Changer de style
----------------

     <?php
     include 'get_securise.php';
     $s = get_securise('screen', $_GET, 'screen.css');
     $h = get_securise('handheld', $_GET, 'handheld.css');
     $p = get_securise('print', $_GET, 'print.css');
     $a = get_securise('all', $_GET);
     if ($a) {
        setcookie('all', $a);
     } else {
        $a = get_securise('all', $_COOKIE, 'all.css');
     }
     include "entete.php";
     echo entete("EDT Screen: $s, Handheld $h, Print $p",
     array(
     array('rel'=>'stylesheet', 'href'=>$a),
     array('rel'=>'stylesheet', 'href'=>$p, 'media'=>'print'),
     array('rel'=>'stylesheet', 'href'=>$h, 'media'=>'handheld'),
     array('rel'=>'stylesheet', 'href'=>$s, 'media'=>'screen')));
     echo "<body>\n";
     echo "<ul>";
     $qs = "?screen=$h&amp;handheld=$p&amp;print=$s";
     echo "<li><a href='$qs'>Rotation des périphériques</a></li>\n";
     $qs = "?screen=$s&amp;handheld=$h&amp;print=$p&amp;all=" .
       (($a == 'all.css') ? 'all2.css' : 'all.css');
     echo "<li><a href='$qs'>Permutation des styles</a></li>\n";
     echo "</ul>\n";
     include 'edt.html';
     echo "</body></html>\n";
     ?>

Caracteristiques generales de la table
--------------------------------------

     .calendrier-salle { text-align: center; width: 100%;}
     .calendrier-salle caption { font-weight: bold; background: #ccc}
     .calendrier-salle td+td+td[rowspan] {font-style: italic;} /* Groupe */
     .calendrier-salle td+td+td+td[rowspan] {
      font-variant: small-caps; /* Les noms en petite capitales, c'est classe */
       font-style: normal; /* neutraliser la regle ci-dessus */
     }
     /* Si un TD est reduit a un UL, la presentation std est une perte de place */
     .calendrier-salle 

Des couts et des couleurs
-------------------------

     .calendrier-salle th { width: 12%;} /* Groupe */
     .calendrier-salle th+th { width: 35%;} /* Intervenant */
     .calendrier-salle th+th+th { width: 25%;} /* Salle */
     .calendrier-salle th+th+th+th { width: 10%;} /* Jour */
     .calendrier-salle th+th+th+th+th { width: 18%;} /* Horaire */
     .calendrier-salle td { border: 1px solid;}

     .couleur2 /* Bleu */ {
	background: #edf3fe; border-color: #5da7c5; color: #5da7c5;
     } 

     .couleur3 /* Bleu pastel */ { 
	background: #ebe9ff; border-color: #766cf6; color: #766CF6;
     } 

     .couleur4 /* Orange */ {
	background: #fec; border-color: #fa9a00; color: #fa9a00;
     } 

     .couleur5 /* Rouge */ {
	background: #ffeded; border-color: #f00; color: #f00;
     } 

     /* Pour forcer la superposition verticale, display:block est indispensable */
     a.abonnement {
	height: 2em;
	width: 2em;
	margin-left: 1em;
	display: block;
	background: url(agenda-24.gif) no-repeat;
     }
     a.telechargement {
	height: 2em;
	width: 2em;
	margin-left: 1em;
	display: block;
	background: url(calendrier-24.gif) no-repeat;
     }
     /* Pour que le texte qui suit ne provoque pas un saut de ligne, pas de bloc. */
     /* Cependant display:inline ferait croire que cette balise vide est superflue */
     /* display:inline-block est la seule solution */

     .modif {
	width: .75em;
	height: .75em;
	display: inline-block;
	background: url(puce-blanche.gif)  no-repeat;
     }

Table telephonee
----------------

     .couleur2 /* Bleu */   { background: #edf3fe;  color: #5da7c5; } 
     .couleur3 /* Bleu pastel */ { background: #ebe9ff; color: #766CF6; } 
     .couleur4 /* Orange */ { background: #fec; color: #fa9a00; } 
     .couleur5 /* Rouge */  { background: #ffeded; color: #f00; }
     /* Neutraliser la premiere ligne et les 2 premieres colonnes */
     .calendrier-salle th, .calendrier-salle td[rowspan] { display: none;}
     /* Pour toutes les autres, supprimer la bordure et occuper toute la largeur */
     .calendrier-salle td, .calendrier-salle td+td+td[rowspan]
      { display: block; width: 100%; border: 0 }


Table imprimee
--------------

     /* compenser la disparition des couleurs par une bordure fine */

     .couleur2 td,
     .couleur3 td,
     .couleur4 td,
     .couleur5 td,
     .couleur2 td+td+td[rowspan], 
     .couleur3 td+td+td[rowspan],
     .couleur4 td+td+td[rowspan],
     .couleur5 td+td+td[rowspan] { 
	border: 1px solid;
     } 

     .couleur2 td+td+td+td+td,
     .couleur3 td+td+td+td+td,
     .couleur4 td+td+td+td+td, 
     .couleur5 td+td+td+td+td{ 
	border-bottom: 1px dashed
     }

     .couleur2+.couleur2 td,
     .couleur3+.couleur3 td,
     .couleur4+.couleur4 td,
     .couleur5+.couleur5 td {
	border-top: 1px dashed ;
     }

     .couleur2 td[rowspan], 
     .couleur3 td[rowspan], 
     .couleur4 td[rowspan],
     .couleur5 td[rowspan] { 
	border: 0; 
     }

Un defaut dans les defauts
--------------------------

     .calendrier-salle caption { background: #888}
