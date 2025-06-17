<?php
$grade=array(
    "math" => "3",
    "art" => "5",
    "history" => "4",
    "music" => "4"
);

foreach($grade as $subject=> $grade){
    echo "subject:" . $subject . ", Grade:" . $grade;
    echo "<br>";
}
?>