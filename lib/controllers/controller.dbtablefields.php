<?php
class dbTableFieldController
{
   static function save($dbTableID,$fieldName,$fieldType,$showInList)
   {
      $aTableField = new Dbtablefields();
      $aTableField->dbTableFieldName = $fieldName;
      $aTableField->dbTableFieldType = $fieldType;
      $aTableField->dbTableID = $dbTableID;
      $aTableField->dbTableShowInList = $showInList;

      $aTableField->insert();
   }
   static function getDBTableFields($tableID)
   {
      $aTableField = new Dbtablefields();
      return $aTableField->getList('dbTableID = ' . $tableID);
   }
}