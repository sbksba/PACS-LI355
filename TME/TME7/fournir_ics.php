<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" 
        "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Transmission de calendriers </title></head> 
  <body> 
  <form action="fournir_ics.php" method="post" enctype="multipart/form-data"> 
  <fieldset>
  <label for='ics1'>Premier fichier ICS</label>
  <input type='file' name='ics1' id='ics1' />
  <label for='ics2'>Premier fichier ICS</label>
  <input type='file' name='ics2' id='ics2' />
  <input type='submit' value='Fusionne'  /> 
  </fieldset>
  </form> 
  </body> 
</html>
<?php
} else {
  include 'envoi_ics.php';
  include 'fusionne_ics.php';
  $res = fusionne_ics($_FILES["ics1"]["tmp_name"], $_FILES["ics2"]["tmp_name"]);
  envoi_ics($res, 'fusion.ics');
}
?>
