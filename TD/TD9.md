TD 9
====

L objet Date de Javascript
--------------------------

     //afficheMessage.js

     function afficheMessage(){ 
        d = new Date(); 
 	time = d.getHours(); 
 	if (time < 12) { 
  	   return ("<h1>Good morning</h1> Il est " + time + " heure") ;
 	}else if(time < 17){ 
     	   return("<h2>Good Afternoon </h2> Il est " + time + " heure");
 	}else { 
   	   return ("<h3>Good Evening</h3>Il est " + time + " heure"); 
        } 
     }

L objet Regexp en Javascript
----------------------------

     // valabs.js

     function valabs(n){
        var exprR = /^([\+\-]?[1-9][0-9]*)|0$/;
    	if (exprR.test(n)) // ou  n.match(exprR)
           return (n >= 0) ? (n + 0) : (0 - n);
        // (n + 0) car la regexp accepte de retourner +3 au lieu de 3
        else return 0;
     }

     function is_num(val){
        var res = /^(0|(\+|\-)?\s*[1-9]+[0-9]*(\.[0-9]+)?)$/.test(val);
    	return (res)? Number(val):false;
     }

Tableaux et tableaux associatifs
--------------------------------

     // sommeElementsTableau.js

     function listerTab(t){
        var s = 0;
    	for (var i in t){
	   var tmp = is_num(t[i]);
	   if (tmp) s = s + tmp;
    	}
    	return s;
     }

     // Ancienne solution reposant sur isNaN
     function listerTab(t){
        for(var i in t){
    	if (t[i] != undefined && !isNaN(t[i])){
           s = s + t[i];
        }
    	return s;
     }

Recuperer les saisies
---------------------

     <html>
     <head>
     <title>Convertiseur Franc-Euro</title>
     <script type="text/javascript">

     function convF_E(d){ 

        if (!estNombre(d.value)) {
    	   alert("La valeur n'est pas un nombre.");
           //conversion explicite Chaine-->Nombre
  	else  d = Number(d.value) / 6.55957; 
           //conversion explicite Nombre-->Chaine
  	return String(d);
     }

     function convE_F(d){
        if (!estNombre(d.value)) {
    	   alert("La valeur n'est pas un nombre.");
        else d = Number(d.value) * 6.55957; 
  	return String(d);
     }

     function estNombre(n){
        var exprR = /^(|[\+\-])?[1-9][0-9]*$/;
  	return exprR.test(n);
     }
     </script>
     </head>
     <body>
     <h2>Convertiseur Franc-Euro </h2>

     <form onsubmit='return false'>
        <label for=e,euro'>
    	   Entrer une somme en euros
    	</label>
    	<input type="text" name="eneuro" id="eneuro"
      	   onchange='alert(convE_F(this))' />
     </form>
      
      <form onsubmit='return false'>
         <label for=e,euro'>
    	    Entrer une somme en francs
    	 </label>
    	 <input type="text" name="enfrancs" id="enfrancs"
      	    onchange='alert(convF_E(this))' />
     </form>
     </body>
     </html>

Insertion de contenu dans une page HTML en Javascript
-----------------------------------------------------

     <html>
     <head>
     <title>Introduction au DOM</title>
     <script language="javascript" type="text/javascript">
      // Création d'une table et ajout à la fin du corps du document
      var table = document.createElement("table");
      
      function verifNombreEntier(value){
         var r = /^([1-9][0-9]+|[0-9])$/;
    	 return r.test(value);
      }
              
      function construction(debut,fin,pas){
         if (verifNombreEntier(debut) 
         && verifNombreEntier(fin) 
         && verifNombreEntier(pas)){               
      	    deb = Number(debut);
      	    f = Number(fin);
      	    p = Number(pas);
      	    if (p == 0){
               alert("Le pas d'increment est nul");
      	    } else {
               tr = document.createElement("tr");
        
	       for (i=deb; i <= f; i = i+ p){
                  var txt = document.createTextNode(i);
               	  var td = document.createElement("td");
               	  td.appendChild(txt);
          	  tr.appendChild(td);
               }
               table.appendChild(tr);
               /*
               if (table.hasChildNodes()){
                  table.replaceChild(tr, table.firstChild);    
               } else {
                  table.appendChild(tr);
               }
       	       */
           } // fin if (p == 0)
      	   // alternative verifNombreEntier
        } else {
      	   alert("Au moins une des valeurs saisie n'est pas un entier");       
    	}
     }
     </script>
     </head>
    
    <body onload="document.getElementsByTagName('body')[0].appendChild(table);">
       <form>
          <fieldset>
      	     <label for="debut">Entrez une valeur de debut : </label>
      	     <input type="text" name="debut" id="debut" value="0"/>
      
	     <label for="fin">Entrez une valeur de fin : </label>
      	     <input type="text" name="fin" id="fin" value="0"/>
      
	     <label for="pas">Entrez une valeur de pas : </label>
      	     <input type="text" name="pas" id="pas" value="0"/><br/>

      	     <input type="button" onClick="construction(debut.value, fin.value,pas.value);" 
      	     value="Construire le tableau de valeurs"/>
           </fieldset>
        </form>
     </body>
     </html>
