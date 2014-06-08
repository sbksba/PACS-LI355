<?php

if (($_SERVER['REQUEST_METHOD'] == 'GET') OR !isset($_FILES["ICS"]["tmp_name"]))
  { ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" 
        "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Créneau dans ICS</title>
  </head> 
  <body>
    <h1>Créneau dans ICS</h1> 
    <form action="creneau_ics.php" method="post" enctype="multipart/form-data">
      <fieldset>
	<label for='jour'>Jour </label><input name='jour' id='jour'>
	<label for='debut'>Commencement </label><input name='debut' id='debut' />
	<label for='fin'>Fin </label><input name='fin' id='fin'/>
      </fieldset>
      <fieldset>
	<label for='ICS'>Agenda </label><input type='file' name='ICS' id='ICS'/>
	<input type='submit' value='Demander ce rendez-vous' />
    </fieldset>
    </form> 
  </body> 
</html>

<?php } else {
	function creneau($f1,$rdvd,$rdvf,$jour){ 
	  foreach ($f1 as $l) { 
	    if (preg_match("/^DTSTART.*:".$jour."T(.*)$/",$l,$a)){
	      $debut = $a[1];
	    }else{
	      if (preg_match("/^DTEND.*:".$jour."T(.*)$/",$l,$a)){ 
		$fin = $a[1]; 
		if ((($fin > $rdvd) && ($fin < $rdvf)) 
		    || (($debut > $rdvd) && ($debut < $rdvf)) 
		    || (($debut < $rdvd) && ($fin > $rdvd))){
		  return false; 
		} 
	      } 
	    }
	  }
	  return true; 
	}

 $debut = $_POST['debut'];
 $fin = $_POST['fin'];
 $jour = $_POST['jour'];
 $file = file($_FILES["ICS"]["tmp_name"]);

 if (!creneau($file, $debut, $fin, $jour)) {
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Pas libre';
  } else{
  header("Content-Type: text/calendar; charset=utf-8");
  header("Content-Transfer-Encoding: 8bit");
  header('Content-Disposition: inline; filename="'.
	 $_FILES["ICS"]["name"] . '.ics' .
	 '"; creation-date="' .
	 gmdate("D, d M Y H:i:s", time()));
  while(true) {$last = array_shift($file); if ($file) echo $last; else break;}
  echo "BEGIN:VEVENT\n";
  echo "DESCRIPTION: RDV\n";
  echo "DTSTART;TZID=Europe/PariS:$jour". 'T' . $debut . "\n";
  echo "DTEND;TZID=Europe/Paris:$jour". 'T' . $fin . "\n";
  echo "END:VEVENT\n";
  echo $last;
 }
}
?>