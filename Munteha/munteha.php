<?php
$a=1;
while($a<=20){
    if($a==5 || $a==10 || $a==15 || $a==20){
        $a+=1;
        continue;
    }
    echo $a;
    echo "<br>";
    $a+=1;    
}

?>