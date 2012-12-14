<?php
class Components extends DBTable {
var $componentID='';
var $componentName='';

function Components(){
$this->tableKey="componentID";
$this->tableName="components";

}
function setComponentID($componentID){
$this->componentID=$componentID;
}
function getComponentID(){
return $this->componentID;
}
function setComponentName($componentName){
$this->componentName=$componentName;
}
function getComponentName(){
return $this->componentName;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET componentName='" . mysql_escape_string($this->componentName) . "'";
$dbConnection->query($sql);
$this->componentID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE componentID=".$this->componentID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET componentName='" . mysql_escape_string($this->componentName) . "'
 WHERE componentID=" . $this->componentID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE componentID= " . $this->componentID;
$dbConnection->query($sql);
}
}?>