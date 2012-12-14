<?php
class Usertype extends DBTable {
var $UserID='';
var $multiuser='';
var $userprofile='';
var $Usergroup='';
var $secretquestion='';

function Usertype(){
$this->tableKey="UserID";
$this->tableName="usertype";

}
function setUserID($UserID){
$this->UserID=$UserID;
}
function getUserID(){
return $this->UserID;
}
function setMultiuser($multiuser){
$this->multiuser=$multiuser;
}
function getMultiuser(){
return $this->multiuser;
}
function setUserprofile($userprofile){
$this->userprofile=$userprofile;
}
function getUserprofile(){
return $this->userprofile;
}
function setUsergroup($Usergroup){
$this->Usergroup=$Usergroup;
}
function getUsergroup(){
return $this->Usergroup;
}
function setSecretquestion($secretquestion){
$this->secretquestion=$secretquestion;
}
function getSecretquestion(){
return $this->secretquestion;
}
function insert(){
global $dbConnection;
$sql="INSERT INTO $this->tableName SET multiuser='" . mysql_escape_string($this->multiuser) . "' ,
userprofile='" . mysql_escape_string($this->userprofile) . "' ,
Usergroup='" . mysql_escape_string($this->Usergroup) . "' ,
secretquestion='" . mysql_escape_string($this->secretquestion) . "'";
$dbConnection->query($sql);
$this->UserID = $dbConnection->getInsertID();
}
function select(){
global $dbConnection;
$sql="SELECT * FROM $this->tableName WHERE UserID=".$this->UserID;
if($dbConnection->query($sql))
return $dbConnection->getResults();
}
function update(){
global $dbConnection;
$sql="UPDATE $this->tableName SET multiuser='" . mysql_escape_string($this->multiuser) . "',
userprofile='" . mysql_escape_string($this->userprofile) . "',
Usergroup='" . mysql_escape_string($this->Usergroup) . "',
secretquestion='" . mysql_escape_string($this->secretquestion) . "'
 WHERE UserID=" . $this->UserID;
$dbConnection->query($sql);
}
function delete(){
global $dbConnection;
$sql="DELETE FROM $this->tableName WHERE UserID= " . $this->UserID;
$dbConnection->query($sql);
}
}?>