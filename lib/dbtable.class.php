<?php
//
//				name:			DBData
//
//				description:	Base class for any persistant object using the database
//								Handle to database is expected to be found ina global instance
//								of cassidyDB named $db.
//
include_once 'database.class.php';
class DBTable
{
   var $tableKey;
   var $tableName;
   var $insertID;

   function getFields($fieldsList, $conditionSQL = '', $orderBy = '', $start = '', $total = '')
   {
      global $dbConnection;
      $sql="SELECT " . implode(',', $fieldsList) . " FROM $this->tableName";
      if(!empty ($conditionSQL))
         $sql .= " WHERE " . $conditionSQL;

      if(!empty ($orderBy))
         $sql .= " ORDER BY " . $orderBy;

      if(!empty ($start) && empty ($total))
         $sql .= " LIMIT " . $start;

      else if(!empty ($start) && !empty ($total))
         $sql .= " LIMIT " . $start . "," . $total;

      if($dbConnection->query($sql))
         return $dbConnection->getResults();
      else
         $this->insertID = $dbConnection->insertID;
   }

   function getList($conditionSQL = '', $orderBy = '', $start = '', $total = '')
   {
      global $dbConnection;
      $sql="SELECT *  FROM $this->tableName";
      if($conditionSQL)
         $sql .= " WHERE " . $conditionSQL;
      if(!empty ($orderBy))
         $sql .= " ORDER BY " . $orderBy;

      if(!empty ($start) && empty ($total))
         $sql .= " LIMIT " . $start;

      else if(!empty ($start) && !empty ($total))
         $sql .= " LIMIT " . $start . "," . $total;

      if($dbConnection->query($sql))
         return $dbConnection->getResults();

   }
   function getInsertID()
   {
      return $this->insertID;
   }
} // end of class
?>