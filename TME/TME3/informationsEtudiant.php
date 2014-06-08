<?php
error_reporting(E_ALL);
require_once('../2/entete.php');

echo entete("Soumission de TME");

echo   "<body>\n";
?>
  <h1> Soumettre un TME </h1>
    <form action="" method="post">
      <fieldset>
        <label for="numero">Numéro de carte</label>
        <input type="text" name="numero" id="numero">
  
        <label for="mail">Mail</label>
        <input type="text" name="mail" id="mail">
  
        <label for="envoiMail">Envoi par mail</label>
        <input type="checkbox" name="envoiMail" id="envoiMail">
  
        <label for="soumission">Soumission</label>
        <input type="checkbox" name="soumission" id="soumission">
        
        <input type="submit" value="Envoyer">
      </fieldset>
    </form>
</body>
</html>
