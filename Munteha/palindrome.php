<?php
    $a=123;
    $c=0;
    while($a!=0){
        $b=$a%10;
        $c=($c*10)+ $b;
        $a=$a/10;
    }
    echo $c;
?>