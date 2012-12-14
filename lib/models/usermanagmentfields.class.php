<?php
class Usermanagmentfields extends DBTable {
var $UserFieldID='';
var $UserFieldName='';
var $UserFieldinput='';
var $UserFieldVisual='';
var $UserFieldStore='';
var $UserID='';

function Usermanagmentfields(){
$this->tableKey="UserFieldID";
$this->tableName="usermanagmentfields";

}
function setUserFieldID($UserFieldID){
$this->UserFieldID=$UserFieldID;
}
function getUserFieldID(){
return $this->UserFieldID;
}
function setUserFieldName($UserFieldName){
$this->UserFieldName=$UserFieldName;
}
function getUserFieldName(){
return $this->UserFieldName;
}
function setUserFieldinput($UserFieldinput){
$this->UserFieldinput=$UserFieldinput;
}
function getUserFieldinput(){
return $this->UserFieldinput;
}
function setUserFieldVisual($UserFieldVisual){
$this->UserFieldVisual=$UserFieldVisual;
}
function getUserFieldVisual(){
return $this->UserFieldVisual;
}
function setUserFieldStore($UserFieldStore){
$this->UserFieldStore=$UserFieldStore;
}
function getUserFieldStore(){
return $this->UserFieldStore;
}
function setUserID($UserID){
$this->UserID=$UserID;
}
function getUserID(){
return $this->UserID;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET UserFieldName='" . mysql_escape_string($this->UserFieldName) . "' ,
UserFieldinput='" . mysql_escape_string($this->UserFieldinput) . "' ,
UserFieldVisual='" . mysql_escape_string($this->UserFieldVisual) . "' ,
UserFieldStore='" . mysql_escape_string($this->UserFieldStore) . "' ,
UserID='" . mysql_escape_string($this->UserID) . "'";
$dbConnection->query($sql);
$this->UserFieldID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE UserFieldID=".$this->UserFieldID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET UserFieldName='" . mysql_escape_string($this->UserFieldName) . "',
UserFieldinput='" . mysql_escape_string($this->UserFieldinput) . "',
UserFieldVisual='" . mysql_escape_string($this->UserFieldVisual) . "',
UserFieldStore='" . mysql_escape_string($this->UserFieldStore) . "',
UserID='" . mysql_escape_string($this->UserID) . "'
 WHERE UserFieldID=" . $this->UserFieldID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE UserFieldID= " . $this->UserFieldID;
$dbConnection->query($sql);
}
}?>