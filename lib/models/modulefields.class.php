<?php
class Modulefields extends DBTable {
var $moduleFieldID='';
var $moduleFieldName='';
var $moduleFieldInput='';
var $moduleFieldVisual='';
var $moduleFieldStore='';
var $moduleID='';

function Modulefields(){
$this->tableKey="moduleFieldID";
$this->tableName="modulefields";

}
function setModuleFieldID($moduleFieldID){
$this->moduleFieldID=$moduleFieldID;
}
function getModuleFieldID(){
return $this->moduleFieldID;
}
function setModuleFieldName($moduleFieldName){
$this->moduleFieldName=$moduleFieldName;
}
function getModuleFieldName(){
return $this->moduleFieldName;
}
function setModuleFieldInput($moduleFieldInput){
$this->moduleFieldInput=$moduleFieldInput;
}
function getModuleFieldInput(){
return $this->moduleFieldInput;
}
function setModuleFieldVisual($moduleFieldVisual){
$this->moduleFieldVisual=$moduleFieldVisual;
}
function getModuleFieldVisual(){
return $this->moduleFieldVisual;
}
function setModuleFieldStore($moduleFieldStore){
$this->moduleFieldStore=$moduleFieldStore;
}
function getModuleFieldStore(){
return $this->moduleFieldStore;
}
function setModuleID($moduleID){
$this->moduleID=$moduleID;
}
function getModuleID(){
return $this->moduleID;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET moduleFieldName='" . mysql_escape_string($this->moduleFieldName) . "' ,
moduleFieldInput='" . mysql_escape_string($this->moduleFieldInput) . "' ,
moduleFieldVisual='" . mysql_escape_string($this->moduleFieldVisual) . "' ,
moduleFieldStore='" . mysql_escape_string($this->moduleFieldStore) . "' ,
moduleID='" . mysql_escape_string($this->moduleID) . "'";
$dbConnection->query($sql);
$this->moduleFieldID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE moduleFieldID=".$this->moduleFieldID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET moduleFieldName='" . mysql_escape_string($this->moduleFieldName) . "',
moduleFieldInput='" . mysql_escape_string($this->moduleFieldInput) . "',
moduleFieldVisual='" . mysql_escape_string($this->moduleFieldVisual) . "',
moduleFieldStore='" . mysql_escape_string($this->moduleFieldStore) . "',
moduleID='" . mysql_escape_string($this->moduleID) . "'
 WHERE moduleFieldID=" . $this->moduleFieldID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE moduleFieldID= " . $this->moduleFieldID;
$dbConnection->query($sql);
}
}?>