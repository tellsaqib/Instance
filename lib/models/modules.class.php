<?php
class Modules extends DBTable {
var $moduleID='';
var $moduleName='';
var $moduleCategories='';
var $moduleNestedCategories='';
var $moduleTags='';
var $moduleComments='';
var $moduleNestedComments='';
var $moduleItemRating='';
var $moduleStatistics='';

function Modules(){
$this->tableKey="moduleID";
$this->tableName="modules";

}
function setModuleID($moduleID){
$this->moduleID=$moduleID;
}
function getModuleID(){
return $this->moduleID;
}
function setModuleName($moduleName){
$this->moduleName=$moduleName;
}
function getModuleName(){
return $this->moduleName;
}
function setModuleCategories($moduleCategories){
$this->moduleCategories=$moduleCategories;
}
function getModuleCategories(){
return $this->moduleCategories;
}
function setModuleNestedCategories($moduleNestedCategories){
$this->moduleNestedCategories=$moduleNestedCategories;
}
function getModuleNestedCategories(){
return $this->moduleNestedCategories;
}
function setModuleTags($moduleTags){
$this->moduleTags=$moduleTags;
}
function getModuleTags(){
return $this->moduleTags;
}
function setModuleComments($moduleComments){
$this->moduleComments=$moduleComments;
}
function getModuleComments(){
return $this->moduleComments;
}
function setModuleNestedComments($moduleNestedComments){
$this->moduleNestedComments=$moduleNestedComments;
}
function getModuleNestedComments(){
return $this->moduleNestedComments;
}
function setModuleItemRating($moduleItemRating){
$this->moduleItemRating=$moduleItemRating;
}
function getModuleItemRating(){
return $this->moduleItemRating;
}
function setModuleStatistics($moduleStatistics){
$this->moduleStatistics=$moduleStatistics;
}
function getModuleStatistics(){
return $this->moduleStatistics;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET moduleName='" . mysql_escape_string($this->moduleName) . "' ,
moduleCategories='" . mysql_escape_string($this->moduleCategories) . "' ,
moduleNestedCategories='" . mysql_escape_string($this->moduleNestedCategories) . "' ,
moduleTags='" . mysql_escape_string($this->moduleTags) . "' ,
moduleComments='" . mysql_escape_string($this->moduleComments) . "' ,
moduleNestedComments='" . mysql_escape_string($this->moduleNestedComments) . "' ,
moduleItemRating='" . mysql_escape_string($this->moduleItemRating) . "' ,
moduleStatistics='" . mysql_escape_string($this->moduleStatistics) . "'";
$dbConnection->query($sql);
$this->moduleID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE moduleID=".$this->moduleID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET moduleName='" . mysql_escape_string($this->moduleName) . "',
moduleCategories='" . mysql_escape_string($this->moduleCategories) . "',
moduleNestedCategories='" . mysql_escape_string($this->moduleNestedCategories) . "',
moduleTags='" . mysql_escape_string($this->moduleTags) . "',
moduleComments='" . mysql_escape_string($this->moduleComments) . "',
moduleNestedComments='" . mysql_escape_string($this->moduleNestedComments) . "',
moduleItemRating='" . mysql_escape_string($this->moduleItemRating) . "',
moduleStatistics='" . mysql_escape_string($this->moduleStatistics) . "'
 WHERE moduleID=" . $this->moduleID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE moduleID= " . $this->moduleID;
$dbConnection->query($sql);
}
}?>