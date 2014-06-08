<?php

function envoi_ics($ics, $nom)
{
  // header("Content-Type: text/plain"); // pour mise au point

  header("Content-Type: text/calendar; charset=UTF-8");
  header("Content-Transfer-Encoding: 8bit");
  header('Content-Disposition: inline; filename="'.
	 $nom .
	 '"; creation-date="' .
	 gmdate("D, d M Y H:i:s", time()));

  foreach($ics as $ligne) echo $ligne;
}
?>
