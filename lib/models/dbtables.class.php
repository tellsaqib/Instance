<?php
class Dbtables extends DBTable {
var $dbTableID='';
var $dbTableName='';
var $dbTableKeyField='';

function Dbtables(){
$this->tableKey="dbTableID";
$this->tableName="dbtables";

}
function setDbTableID($dbTableID){
$this->dbTableID=$dbTableID;
}
function getDbTableID(){
return $this->dbTableID;
}
function setDbTableName($dbTableName){
$this->dbTableName=$dbTableName;
}
function getDbTableName(){
return $this->dbTableName;
}
function setDbTableKeyField($dbTableKeyField){
$this->dbTableKeyField=$dbTableKeyField;
}
function getDbTableKeyField(){
return $this->dbTableKeyField;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET dbTableName='" . mysql_escape_string($this->dbTableName) . "' ,
dbTableKeyField='" . mysql_escape_string($this->dbTableKeyField) . "'";
$dbConnection->query($sql);
$this->dbTableID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE dbTableID=".$this->dbTableID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET dbTableName='" . mysql_escape_string($this->dbTableName) . "',
dbTableKeyField='" . mysql_escape_string($this->dbTableKeyField) . "'
 WHERE dbTableID=" . $this->dbTableID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE dbTableID= " . $this->dbTableID;
$dbConnection->query($sql);
}
}?>