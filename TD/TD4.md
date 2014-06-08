TD 4
====

Mecanisme general
-----------------

> POP est un protocole à état, car avant de pouvoir utiliser les requêtes d'accès
> à la boîte de réception, il faut s'authentifier.
> Comme il  n'y a pas d'en-têtes comme en HTTP, une unique requête ne peut pas 
> à la fois fournir l'authentification et la demande d'accès,
> il faut au moins deux requêtes et même trois
> (car il y a USER et PASS, on ne donne pas les deux informations d'un coup).
> Entre chacune de ces requêtes, le serveur change d'état
> ("inconnu" puis "nommé" puis "authentifié").

> Scénario plausible: 
> USER PASS STAT QUIT
> qui permet juste de savoir si on a des mails et combien.

Connexion
---------

     <?php

     // Fonction qui envoie une commande au serveur POP3 
     // et renvoie vrai ssi le retour commence par "+OK"
     // $com ne doit pas contenir CR/LF

     function commande($sock,$com){
        fputs($sock, trim($com) . "\r\n");
        $reponse = fgets($sock);
        return preg_match("/^\+OK/",$reponse) ? $reponse : false;
     }

     // Fonction de connexion à un serveur POP3
     // Le timeOut est fixé à 5 secondes (par défaut 300s)
     function connexion($server,$user,$pass){
        $sock = fsockopen($server,110,$errno,$errstr,5);
        if ($sock == false){
                echo "Erreur de connexion au serveur POP [$errno] : $errstr\n";
                return false;
        } else {
                // Chercher le message de bienvenue du serveur
                $reponse = fgets($sock);
                // Envoi de la commande USER
                $res = commande($sock,"USER " . $user);
                if ($res){
                        // Envoi de la commande PASS
                        $res = commande($sock,"PASS " . $pass);
                        if ($res) {
              // L'utilisateur est reconnu
              // on retourne le descripteur de socket
                                return $sock;
                        } else {
                                return false;
                        }
                } else {
                        return false;
                }
        }
     }       
     ?>

Deconnexion
-----------

     <?php
	function deconnexion($sock){
    		 fputs($sock, "QUIT\r\n");
    		 echo fgets($sock) . "\n";
    		 @fclose($sock);
        }
     ?> 

Contenu de la boite
-------------------

     <?php
     function get_mail_count($sock){
     	      $res = commande($sock, "STAT");
  	      if ($res) {
    	         $res = preg_plit('/\s+/', $res);
   		  array_shift($res);
              }
  	      return $res;
     }
     ?>

Recuperation des en-tetes SMTP
------------------------------

     <?php
    
     define('RE_ENTETE_SMTP', '/^([A-Z][-a-zA-Z0-9]+):(.*)$/');
    
    
     function recuperation_entetes($sock, $num){
        $res = commande($sock,"TOP $num 0");
          if (!$res) return false;
        $entetes = array();
        
        $cle = '';
        
        while (($ligne = trim(fgets($sock))) != '.') {
            //$tmp = preg_replace("/\r\n/", "<br />\n", htmlentities($ligne));
              $tmp = htmlentities($ligne);    
            if (preg_match(RE_ENTETE_SMTP, $tmp, $r)){
                  $cle = $r[1];
                  if (isset($entetes[$cle])){
                      $entetes[$cle] .= "<br />\n" . $r[2];
                  } else {
                      $entetes[$cle] = $r[2];
                  }              
              } else {
                  // Autre ligne : ajout a la derniere cle trouvee
                  $entetes[$cle] .= "<br />\n" . $tmp;
              }
        }
        
        return $entetes;
      }
        
      ?> 

Recuperation du corps du message
--------------------------------

     <?php

     function recuperation_message($sock, $num){
        $res = commande($sock,"RETR $num");
          if (!$res) return false;
        
        $message = '';
        
        while (($ligne = trim(fgets($sock))) != '') {
            // On passe les en-têtes
        }
        
        // Lecture du corps du message
        while (($ligne = trim(fgets($sock))) != '.') {
            $tmp = preg_replace("/\r\n/", "<br />\n", htmlentities($ligne));
              $message .= $tmp;
        }
        return $message;
      }

      ?> 

Filtrage des e-mails
--------------------

     <?php
     function selection_message($entetes, $contraintes){
        foreach ($contraintes as $cle=>$val){
            if (! isset($entetes[$cle]) || ($entetes[$cle] != $val)) return false;
         }
         return true;
     }
     ?> 

Selection des e-mails
---------------------

     <?php
     function selection_mail($sock, $criteres) {
          $res = '';
          $n = get_mail_count($sock);
          if ($n) $n = $n[0];
          for (;$n;$n--) {
            $entetes = recuperation_entetes($sock, $n);
            $res = selection_mail($entetes, $criteres);
            if ($res){
                $message = recuperation_message($sock, $num);
                $res .= affiche_mail($num, $entetes, $message);
            }
        }
        return "<html><head><title>Mails filtrés</title></head><body>$res</body></html>"; 
      }
        
      function affiche_mail($num, $entetes, $message){
        $res = "<table summary='Mail num. $num'>\n";
        $res .= "<caption>" . $entetes["From"] . "</caption>";
        $res .= "<tr><th>Entêtes</th><th>Valeurs</th></tr>";
        
        foreach ($tab as $k=>$v) $res .= "<tr><td>$k</td><td>$v</td></tr>\n";
        $res .= "<tr><td colspan='2'>$message</td></tr>\n";
        $res .= "</table>\n";
        return $res;
      }
      ?> 
