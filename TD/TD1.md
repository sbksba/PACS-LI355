TD 1
====

Lecture d un fichier HTML
-------------------------

> 1. Doctype indique la version de la grammaire HTML à utiliser

> 2. Il y a un en-tête (balise Head) et un corps (balise Body); 
>    le corps a deux balises Div, la première pour le titre de l'enseignement,
>    la deuxième pour le contenu proprement dit,
>    qui comporte une liste (balise Ul) de deux éléments (balise Li).

> 3. Les deux balises Link dont l'attribut Rel vaut "stylesheet".

> 4. Les attributs Href de ces deux balises indiquent où sont ces feuilles de styles,
>    elles sont fournies par le serveur Http de la licence.

> 5. A préciser l'encodage du texte, notamment les lettres accentuées.

> 6. Les occurrences sont &amp; &gt et &nbsp;
>    qui servent à afficher respectivement "&" ">" et " ". 
>    Les deux premiers sont des caractères réservés de XHTML
>    et doivent donc être transcodés quand on veut les afficher.
>    Le troisième est un espace dont on précise qu'il est insécable
>    (pas remplaçable par un saut de ligne).

Premiere page HTML creee dynamiquement
--------------------------------------

      #!/bin/sh
      cat <<EOF
      Content-Type: text/html; charset=utf-8
      <html><head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title> Page HTML dynamique indiquant la date</title>
      </head>
      <body>
      Voici la date d'aujourd'hui :
      <br />
      EOF
      date
      echo '</body></html>

> Envoyer "<br />" permet d'afficher la date en dessous de la ligne
> "Voici la date d'aujourd'hui".
> Mettre une ligne vide dans le texte HTML 
> ne provoquerait pas l'affichage en deux lignes par le navigateur,
> car il identifie espace et saut de ligne.`

Afficher les informations du serveur
------------------------------------

     #!/bin/sh 
     echo 'Content-Type: text/html; charset=utf-8'
     echo
     echo '<html><head>'
     echo '<title> Afficher les informations connues du serveur</title>'
     echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
     echo '</head>'
     echo '<body>'
     echo 'Je suis le script <strong>' 
     echo $SCRIPT_NAME 
     echo '</strong>'
     echo ' servi par <strong>' $SERVER_SOFTWARE '</strong>'
     echo ' pour <strong>' $HTTP_USER_AGENT '</strong>'
     echo '</body></html>'

Table de quelques variables du serveur
--------------------------------------

     #!/bin/sh 
     echo 'Content-Type: text/html; charset=utf-8'
     echo
     echo '<html><head>'
     echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
     echo '<title> Table des variables du serveur</title>'
     echo '</head>'
     echo '<body>'
     echo '<table summary="Table des principales variables du serveur">’ 
     echo '<caption> Table des variables du serveur</caption>'
     echo '<tr><th>Nom</th><th>Valeur</th></tr>'
     echo '<tr><td>SERVER_NAME</td><td>'$SERVER_NAME'</td></tr>'
     echo '<tr><td>SERVER_SOFTWARE</td><td>'$SERVER_SOFTWARE'</td></tr>'
     echo '<tr><td>SERVER_ADDR</td><td>'$SERVER_ADDR'</td></tr>'
     echo '<tr><td>REMOTE_PORT</td><td>'$REMOTE_PORT'</td></tr>'
     echo '<tr><td>REMOTE_ADDR</td><td>'$REMOTE_ADDR'</td></tr>'
     echo '</table>' 
     echo '</body></html>'

La multiplication des td
------------------------

     #!/bin/sh 
     echo 'Content-Type: text/html; charset=utf-8'
     echo
     echo '<html><head>'
     echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
     echo '<title>Tables de multiplication par 2</title>'
     echo '</head><body>' 
     echo '<table summary="Table de multiplication par 2 sur 2 colonnes">'
     echo '<caption>Table de 2</caption>'
     echo '<tr><th>x</th><th>2x</th></tr>'
     i=0
     while [ $i -lt 10 ]
     do
     echo "<tr><td>" $i "</td><td>" $(($i*2)) "</td></tr>" 
     i=$((i+1))
     done
     echo '</table></body></html>'

La stylisation des td
---------------------

     #!/bin/sh 
     echo 'Content-Type: text/html; charset=utf-8'
     echo
     echo '<html><head>'
     echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
     echo '<title>Tables de multiplication par 2</title>'
     echo '</head><body>' 
     echo '<table summary="Table de multiplication par 2 sur 2 colonnes">'
     echo '<caption>Table de 2</caption>'
     echo '<tr><th>x</th><th>2x</th></tr>'
     i=0
     while [ $i -lt 10 ]
     do
     if [ $((i % 2)) -eq 0 ]
     then
     color='#777'
     else
     color='#111'
     fi
     echo "<tr style='background-color:$color'><td>$i</td><td>" 
     echo $(($i*2))
     echo "</td></tr>" 
     i=$((i+1))
     done
     echo '</table></body></html>'

La division des td
------------------

     #!/bin/sh 
     echo 'Content-Type: text/html; charset=utf-8'
     echo
     echo '<html><head>'
     echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
     echo '<title>Tables de multiplication par 2 sur 10 lignes</title>'
     echo '</head><body>' 
     echo '<table summary="Table de 2 sur 10 colonnes">'
     echo '<caption>Table de 2</caption>'

     # Première ligne
     echo "<tr><th>x</th>"
     i=0
     while [ $i -lt 10 ]
     do
     echo "<td>" $i "</td>"
     i=$((i+1))
     done
     echo "</tr>"

     # Deuxième ligne

     echo '<tr><th>2x</th>'
     i=0
     while [ $i -lt 10 ]
     do
     echo "<td>" $((2*$i)) "</td>"
     i=$((i+1))
     done
     echo "</tr>"
     echo '</table></body></html>'
