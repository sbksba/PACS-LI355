<?php 

function fusionne_ics($f1, $f2) 
{ 
 $f1 = file($f1); 

//suppression du END:VCALENDAR
 array_pop($f1); 

 $f2 = file($f2);

 //suppression du BEGIN:VCALENDAR
 array_shift($f2); 

 //suppression du debut jusqu'au premier BEGIN
 while (!preg_match("/^BEGIN:/",$f2[0])){
   array_shift($f2);
 }

 return array_merge($f1, $f2); 
}
?>