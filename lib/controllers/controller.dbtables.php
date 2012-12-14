<?php
class dbTableController
{
   static function save($data)
   {
      $result = -1;
      $aTable = new Dbtables();
      $aTable->setDbTableName($data['dbTableName']);
      $aTable->setDbTableKeyField($data['keyFieldName']);
      if($data['dbTableID'])
      {
         $aTable->setDbTableID($data['dbTableID']);
         $aTable->update();
         $tableFields = dbTableFieldController::getDBTableFields($aTable->getDbTableID());
         if(sizeof($tableFields))
         {
            foreach($tableFields as $field)
            {
               $aField = new Dbtablefields();
               $aField->setDbTableFieldID($field->dbTableFieldID);
               $aField->delete();
            }
         }
         
         $result = 0;
      }
      else
      {
         $aTable->insert();
         $result = $aTable->getDbTableID();
      }
      $fieldNames = $data['dbTableFieldName'];
      $fieldTypes = $data['dbTableFieldType'];
      $showInList = $data['dbTableShowInList'];
      
      for($loop=0,$len = sizeof($fieldNames); $loop<$len; $loop++)
      {
         dbTableFieldController::save($aTable->getDbTableID(),$fieldNames[$loop],$fieldTypes[$loop],$showInList[$loop]);
      }
      
      return  $result;
   }

   static function getAllDBTables()
   {
      $aTable = new Dbtables();
      return $aTable->getList();
   }
   
   static function getDBTable($id)
   {
      $aTable = new Dbtables();
      $aTable->setDbTableID($id);
      $tables = $aTable->select();
      return  $tables[0];
   }
   static function getNamesList()
   {
      $fieldList = array('dbTableID', 'dbTableName');
      $namesList = new Dbtables();
      return $namesList->getFields($fieldList);
   }

   static function createDBTablesForModule($moduleName,$moduleOptions,$fieldsNames,$fieldsStores, $showInList)
   {
      $tables = array();
      $moduleSystemName = Util::getSystemName($moduleName);

      if($moduleOptions['moduleCategories'] == 'on') // Adding Categories table for the Module
      {
         $tableObject = array();
         $tableObject['dbTableName'] = $moduleSystemName . 'Categories';
         $tableObject['keyFieldName'] = 'categoryID';
         $tableObject['dbTableFieldName'] = array('categoryName');
         $tableObject['dbTableFieldType'] = array(1);

         if($moduleOptions['moduleNestedCategories'] == 'on')
         {
            $tableObject['dbTableFieldName'][] = 'categoryParentID';
            $tableObject['dbTableFieldType'][] = 0;
         }

         $id = dbTableController::save($tableObject);
		 $tables[] = array('dbTableID' => $id , 'dbTableName' => $moduleSystemName . 'Categories');
      }

      if($moduleOptions['moduleTags'] == 'on') //Adding Tags Table for the Module
      {
         $tableObject = array();
         $tableObject['dbTableName'] = $moduleSystemName . 'Tags';
         $tableObject['keyFieldName'] = 'tagID';
         $tableObject['dbTableFieldName'] = array('tagTitle');
         $tableObject['dbTableFieldType'] = array(1);

         $id = dbTableController::save($tableObject);
		 $tables[] = array('dbTableID' => $id , 'dbTableName' => $moduleSystemName . 'Tags');
      }

      if($moduleOptions['moduleComments'] == 'on')//Adding Comments Table for the Module
      {
         $tableObject = array();
         $tableObject['dbTableName'] = $moduleSystemName . 'Comments';
         $tableObject['keyFieldName'] = 'commentID';
         $tableObject['dbTableFieldName'] = array('commentName');
         $tableObject['dbTableFieldType'] = array(1);

         if($moduleOptions['moduleNestedComments'] == 'on')
         {
            $tableObject['dbTableFieldName'][] = 'commentParentID';
            $tableObject['dbTableFieldType'][] = 0;
         }

         $id = dbTableController::save($tableObject);
		 $tables[] = array('dbTableID' => $id , 'dbTableName' => $moduleSystemName . 'Comments');
      }

      if($moduleOptions['moduleItemRating'] == 'on')//Adding Item Rating Table for the Module
      {
//         print_r('item rating');
         $tableObject = array();
         $tableObject['dbTableName'] = $moduleSystemName . 'ItemRatings';
         $tableObject['keyFieldName'] = 'itemRatingID';
         $tableObject['dbTableFieldName'] = array('itemRatingValue','userIP','userID');
         $tableObject['dbTableFieldType'] = array(0,0,0);

         $id = dbTableController::save($tableObject);
		   $tables[] = array('dbTableID' => $id , 'dbTableName' => $moduleSystemName . 'ItemRatings');
      }
//      else print_r($moduleOptions);
//      exit;
      if($moduleOptions['moduleStatistics'] == 'on')//Adding Statistics Table for the Module
      {
         $tableObject = array();
         $tableObject['dbTableName'] = $moduleSystemName . 'Statistics';
         $tableObject['keyFieldName'] = 'statisticID';
         $tableObject['dbTableFieldName'] = array('statisticRefferer','statisticContentID');
         $tableObject['dbTableFieldType'] = array(0,0);

         $id = dbTableController::save($tableObject);
         $tables[] = array('dbTableID' => $id , 'dbTableName' => $moduleSystemName . 'Statistics');
      }

      //Adding Main Module Table
      $tableObject = array();
      $tableObject['dbTableName'] = $moduleSystemName;
      $tableObject['keyFieldName'] = $moduleSystemName . 'ID';
      $newArr = array();
      for($loop=0,$len = sizeof($fieldsNames); $loop<$len; $loop++)
      {
         $tableObject['dbTableFieldName'][$loop] = $fieldsNames[$loop];
         $tableObject['dbTableFieldType'][$loop] = $fieldsStores[$loop];
         
         if(in_array($fieldsNames[$loop], $showInList))
            $tableObject['dbTableShowInList'][$loop] = 1;
         else
            $tableObject['dbTableShowInList'][$loop] = 0;
      }
      $id = dbTableController::save($tableObject);
	  $tables[] = array('dbTableID' => $id , 'dbTableName' => $moduleSystemName);

      return $tables;
   }
   static function deleteDBTable($id)
   {
      $aTable = new Dbtables();
      $aTable->setDbTableID($id);

      $tableFields = dbTableFieldController::getDBTableFields($aTable->getDbTableID());
      if(sizeof($tableFields))
      {
         foreach($tableFields as $field)
         {
            $aField = new Dbtablefields();
            $aField->setDbTableFieldID($field->dbTableFieldID);
            $aField->delete();
         }
      }
      $aTable->delete();
   }
}