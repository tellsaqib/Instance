<?php
class Dbtablefields extends DBTable {
var $dbTableFieldID='';
var $dbTableFieldName='';
var $dbTableFieldType='';
var $dbTableID='';
var $dbTableShowInList='';

function Dbtablefields(){
$this->tableKey="dbTableFieldID";
$this->tableName="dbtablefields";

}
function setDbTableFieldID($dbTableFieldID){
$this->dbTableFieldID=$dbTableFieldID;
}
function getDbTableFieldID(){
return $this->dbTableFieldID;
}
function setDbTableFieldName($dbTableFieldName){
$this->dbTableFieldName=$dbTableFieldName;
}
function getDbTableFieldName(){
return $this->dbTableFieldName;
}
function setDbTableFieldType($dbTableFieldType){
$this->dbTableFieldType=$dbTableFieldType;
}
function getDbTableFieldType(){
return $this->dbTableFieldType;
}
function setDbTableID($dbTableID){
$this->dbTableID=$dbTableID;
}
function getDbTableID(){
return $this->dbTableID;
}
function setDbTableShowInList($dbTableShowInList){
$this->dbTableShowInList=$dbTableShowInList;
}
function getDbTableShowInList(){
return $this->dbTableShowInList;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET dbTableFieldName='" . mysql_escape_string($this->dbTableFieldName) . "' ,
dbTableFieldType='" . mysql_escape_string($this->dbTableFieldType) . "' ,
dbTableID='" . mysql_escape_string($this->dbTableID) . "' ,
dbTableShowInList='" . mysql_escape_string($this->dbTableShowInList) . "'";
$dbConnection->query($sql);
$this->dbTableFieldID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE dbTableFieldID=".$this->dbTableFieldID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET dbTableFieldName='" . mysql_escape_string($this->dbTableFieldName) . "',
dbTableFieldType='" . mysql_escape_string($this->dbTableFieldType) . "',
dbTableID='" . mysql_escape_string($this->dbTableID) . "',
dbTableShowInList='" . mysql_escape_string($this->dbTableShowInList) . "'
 WHERE dbTableFieldID=" . $this->dbTableFieldID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE dbTableFieldID= " . $this->dbTableFieldID;
$dbConnection->query($sql);
}
}?>