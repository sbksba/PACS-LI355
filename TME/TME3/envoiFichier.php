<?php
// Après avoir récupéré le nom du TD associé à l'étudiant, 
// il faut rajouter dans le script "envoiFichier.php" la ligne suivante,
// permetttant de ranger le fichier dans un repertoire non temporaire: 

  move_uploaded_file ($_FILES["fichier"]["tmp_name"], "./TD?/".$_FILES["fichier"]["name"]);
  
  //Envoi par mail
  $contenuFichier = file_get_contents($_FILES["fichier"]["tmp_name"]);
  if($contenuFichier)
    mail("email@domain.tld", "Subject", $contenuFichier);
    /* La fonction mail permet d'envoyer un e-mail. 
      Attention, pour que cette fonction marche il 
      faut installer un serveur mail et configurer 
      l'interprete php pour qu'il l'utilise. */
?>
