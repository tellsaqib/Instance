<?php
class Partproperties extends DBTable {
var $propertyID='';
var $propertyTitle='';
var $propertyValue='';
var $propertyPartID='';

function Partproperties(){
$this->tableKey="propertyID";
$this->tableName="partproperties";

}
function setPropertyID($propertyID){
$this->propertyID=$propertyID;
}
function getPropertyID(){
return $this->propertyID;
}
function setPropertyTitle($propertyTitle){
$this->propertyTitle=$propertyTitle;
}
function getPropertyTitle(){
return $this->propertyTitle;
}
function setPropertyValue($propertyValue){
$this->propertyValue=$propertyValue;
}
function getPropertyValue(){
return $this->propertyValue;
}
function setPropertyPartID($propertyPartID){
$this->propertyPartID=$propertyPartID;
}
function getPropertyPartID(){
return $this->propertyPartID;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET propertyTitle='" . mysql_escape_string($this->propertyTitle) . "' ,
propertyValue='" . mysql_escape_string($this->propertyValue) . "' ,
propertyPartID='" . mysql_escape_string($this->propertyPartID) . "'";
$dbConnection->query($sql);
$this->propertyID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE propertyID=".$this->propertyID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET propertyTitle='" . mysql_escape_string($this->propertyTitle) . "',
propertyValue='" . mysql_escape_string($this->propertyValue) . "',
propertyPartID='" . mysql_escape_string($this->propertyPartID) . "'
 WHERE propertyID=" . $this->propertyID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE propertyID= " . $this->propertyID;
$dbConnection->query($sql);
}
}?>