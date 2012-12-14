<?php
class Pages extends DBTable {
   var $pageID='';
   var $pageName='';
   var $pageOperationID='';
   var $pageMetaID='';
   var $pageContentID='';

   function Pages(){
      $this->tableKey="pageID";
      $this->tableName="pages";

   }
   function setPageID($pageID){
      $this->pageID=$pageID;
   }
   function getPageID(){
      return $this->pageID;
   }
   function setPageName($pageName){
      $this->pageName=$pageName;
   }
   function getPageName(){
      return $this->pageName;
   }
   function setPageOperationID($pageOperationID){
      $this->pageOperationID=$pageOperationID;
   }
   function getPageOperationID(){
      return $this->pageOperationID;
   }
   function setPageMetaID($pageMetaID){
      $this->pageMetaID=$pageMetaID;
   }
   function getPageMetaID(){
      return $this->pageMetaID;
   }
   function setPageContentID($pageContentID){
      $this->pageContentID=$pageContentID;
   }
   function getPageContentID(){
      return $this->pageContentID;
   }
   function insert(){
      global $dbConnection;
      $sql="INSERT INTO $this->tableName SET pageName='" . mysql_escape_string($this->pageName) . "' ,
pageOperationID='" . mysql_escape_string($this->pageOperationID) . "' ,
pageMetaID='" . mysql_escape_string($this->pageMetaID) . "' ,
pageContentID='" . mysql_escape_string($this->pageContentID) . "'";
      $dbConnection->query($sql);
      $this->pageID = $dbConnection->getInsertID();
   }
   function select(){
      global $dbConnection;
      $sql="SELECT * FROM $this->tableName WHERE pageID=".$this->pageID;
      if($dbConnection->query($sql))
      return $dbConnection->getResults();
   }
   function update(){
      global $dbConnection;
      $sql="UPDATE $this->tableName SET pageName='" . mysql_escape_string($this->pageName) . "',
pageOperationID='" . mysql_escape_string($this->pageOperationID) . "',
pageMetaID='" . mysql_escape_string($this->pageMetaID) . "',
pageContentID='" . mysql_escape_string($this->pageContentID) . "'
 WHERE pageID=" . $this->pageID;
      $dbConnection->query($sql);
   }
   function delete(){
      global $dbConnection;
      $sql="DELETE FROM $this->tableName WHERE pageID= " . $this->pageID;
      $dbConnection->query($sql);
   }
}?>