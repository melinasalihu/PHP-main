<?php
function callCounter(){
    static $count = 0;
    $count++;
    echo "the value of count variable is: $count <br>";
}

callCounter();
callCounter();
callCounter();
callCounter();
callCounter();

?>