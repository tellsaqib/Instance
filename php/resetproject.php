<?php
include '../lib/database.class.php';

$query = 'TRUNCATE `usermanagmentfields` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `components` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `dbtablefields` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `dbtables` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `modulefields` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `modules` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `pageparts` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `pages` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `partproperties` ;';
$dbConnection->query($query);
$query = 'TRUNCATE `usermanagementoptions` ;';
$dbConnection->query($query);

header('location:../index.html');
?>
