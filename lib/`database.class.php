<?php
  /*
      Class Database
      (c) Kancha
        kancha@flashmail.com

      Oct. 13, 2000

  */

class Database{

   // private instant variables
   var $dbConnectionID;
   var $queryID;
   var $record;
   var $insertID;

   var $host;
   var $database;
   var $user;
   var $password;

  /*
    constructor
    connect to datbase server and select specified database
  */
   function Database($host="localhost", $db="instance", $user="root", $pwd="")
   {
      $this->host = $host;
      $this->database = $db;
      $this->user = $user;
      $this->password = $pwd;
      $this->connect();
   }


  /*
    private method
    used internally to generate dbConnectionID
  */
   function connect()
   {
      $this->dbConnectionID = @mysql_pconnect($this->host, $this->user, $this->password);
      if(!$this->dbConnectionID)
      {
         echo(mysql_errno().":".mysql_error());
         exit;
      }
      else
      {
         $status = @mysql_select_db($this->database, $this->dbConnectionID);
         if(!$status){
            echo(mysql_errno().":".mysql_error());
            exit;
         }
      }
   }


   //  public methods

   function executeQuery($sql)
   {
      // connect to db incase connection id is not set
      if(empty($this->dbConnectionID))
      $this->connect();
      $this->queryID = @mysql_query($sql, $this->dbConnectionID);
      $this->insertID = mysql_insert_id($this->dbConnectionID);

      // handle error
      if(!$this->queryID){
         echo(mysql_errno().":".mysql_error());
         exit;
      }
   }

   function getInsertID()
   {
      return $this->insertID;
   }

   function setInsertID($id)
   {
      $this->insertID = $id;
   }
   function nextRecord(){
      $this->record = @mysql_fetch_array($this->queryID);
      $status = is_array($this->record);
      return($status);
   }

   function numRows(){
      $rows = @mysql_num_rows($this->queryID);
      return($rows);
   }

   // get record field value from the current record pointed by $record
   function getField($field)
   {
      return($this->record[$field]);
   }
}
//global $dbConnection;
//$dbConnection = new Database();
?>
