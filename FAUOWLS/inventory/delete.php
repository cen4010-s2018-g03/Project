<?php
// include database connection
include 'config/database.php';
 
try {
     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $perry_part_num=isset($_GET['perry_part_num']) ? $_GET['perry_part_num'] : die('ERROR: Record ID not found.');
 
    // delete query
    $query = "DELETE FROM Inventory WHERE perry_part_num = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $perry_part_num);
     
    if($stmt->execute()){
        // redirect to read records page and 
        // tell the user record was deleted
        header('Location: index.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>