function init(){
  nbadeviner = Math.floor(Math.random()*10+1);
  delai = setTimeout ("delaiExpire()", 10000);
}

function controler(input){
  n = input.value;
  if (isNaN(n))
    alert( " Farceur, ce n'est pas un nombre !");
  else if (n == nbadeviner) {
    clearTimeout(delai);
    alert( "gagné");
  } else if (n <  nbadeviner)
    alert("C'est plus");
  else 
    alert("C'est moins");
}

function delaiExpire(){
  chaine = "Le délai est expiré !";
  chaine += "Il fallait trouver " + nbadeviner;
  chaine += ". Voulez-vous continuer ?";
  if(confirm(chaine)) init();
}
