<?php
// include files
include 'core.dbfunctions.php';
//include 'core_classes/DGEN_Generator.php';

// default database
if($_POST['db_name']){
    $dbName = $_POST['db_name'];
}else{
    $dbName = 'instance';
}

// Database Configuration
$dbConn = new DbConnection();
$dbConn->useManualDefinition("localhost", $dbName, "root", "");
$dbConn->doConnection();



?>
