<?php
// used to connect to the database
$host = "lamp.cse.fau.edu";
$db_name = "CEN4010_S2018g03";
$username = "CEN4010_S2018g03";
$password = "cen4010_s2018";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}
  
// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>
