<?php
class Pageparts extends DBTable {
var $pagePartID='';
var $pagePartParentID='';
var $pagePartCategory='';
var $pagePartText='';

function Pageparts(){
$this->tableKey="pagePartID";
$this->tableName="pageparts";

}
function setPagePartID($pagePartID){
$this->pagePartID=$pagePartID;
}
function getPagePartID(){
return $this->pagePartID;
}
function setPagePartParentID($pagePartParentID){
$this->pagePartParentID=$pagePartParentID;
}
function getPagePartParentID(){
return $this->pagePartParentID;
}
function setPagePartCategory($pagePartCategory){
$this->pagePartCategory=$pagePartCategory;
}
function getPagePartCategory(){
return $this->pagePartCategory;
}
function setPagePartText($pagePartText){
$this->pagePartText=$pagePartText;
}
function getPagePartText(){
return $this->pagePartText;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET pagePartParentID='" . mysql_escape_string($this->pagePartParentID) . "' ,
pagePartCategory='" . mysql_escape_string($this->pagePartCategory) . "' ,
pagePartText='" . mysql_escape_string($this->pagePartText) . "'";
$dbConnection->query($sql);
$this->pagePartID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE pagePartID=".$this->pagePartID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET pagePartParentID='" . mysql_escape_string($this->pagePartParentID) . "',
pagePartCategory='" . mysql_escape_string($this->pagePartCategory) . "',
pagePartText='" . mysql_escape_string($this->pagePartText) . "'
 WHERE pagePartID=" . $this->pagePartID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE pagePartID= " . $this->pagePartID;
$dbConnection->query($sql);
}
}?>