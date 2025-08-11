<?php
$a=1;
    while($a<=10){
         $b=$a%2;
         if($b==0){
             $a+=1;
             continue;
            
         }
         echo $a;
         echo "<br>";
         $a+=1;
        
     }
?>