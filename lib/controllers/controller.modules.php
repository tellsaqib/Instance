<?php
class moduleController
{
   static function save($obj)
   {
      $aModule = new Modules();
      $result = -1;
      
      $aModule->setModuleName($obj['moduleName']);
      if($obj['moduleCategories'])
         $aModule->setModuleCategories(1);
      if($obj['moduleNestedCategories'])
         $aModule->setModuleNestedCategories(1);
      if($obj['moduleTags'])
         $aModule->setModuleTags(1);
      if($obj['moduleComments'])
         $aModule->setModuleComments(1);
      if($obj['moduleNestedComments'])
         $aModule->setModuleNestedComments(1);
      if($obj['moduleRating'])
         $aModule->setModuleItemRating(1);
      if($obj['moduleStatistics'])
         $aModule->setModuleStatistics(1);

      if($obj['moduleID'])
      {
         $aModule->setModuleID($obj['moduleID']);
         $aModule->update();
         $moduleFields = moduleFieldController::getModuleFields($aModule->getModuleID());

         if(sizeof($moduleFields))
            foreach($moduleFields as $field)
            {
               $aField = new Modulefields();
               $aField->setModuleFieldID($field->moduleFieldID);
               $aField->delete();
               $result = '0';
            }
      }
      else
      {
         $aModule->insert();
         $result = $aModule->getModuleID();
      }

      $fieldsNames = $obj['moduleFieldName'];
      $fieldsInputs = $obj['moduleFieldInput'];
      $fieldsStores = $obj['moduleFieldStore'];
      $fieldsVisuals = $obj['moduleFieldVisual'];
      $fieldsShowInList = $obj['showInList'];
   
      for($loop=0,$len = sizeof($fieldsNames); $loop<$len; $loop++)
         moduleFieldController::save($aModule->getModuleID(),
            $fieldsNames[$loop],
            $fieldsInputs[$loop],
            $fieldsStores[$loop],
            $fieldsVisuals[$loop],
            $fieldsShowInList[$loop]);
         
      return $result;
   }

   static function getNamesList()
   {
      $fieldList = array('moduleID','moduleName');
      $namesList = new Modules();
      return $namesList->getFields($fieldList);
   }
   static function getModule($id)
   {
      $aModule = new Modules();
      $aModule->setModuleID($id);
      $modules = $aModule->select();
      return  $modules[0];
   }

   static function deleteModule($id)
   {
      $aModule = new Modules();
      $moduleFields = moduleFieldController::getModuleFields($id);
      if(sizeof($moduleFields))
      {
         foreach($moduleFields as $field)
         {
            $aField = new Modulefields();
            $aField->setModuleFieldID($field->moduleFieldID);
            $aField->delete();
         }
      }
      $aModule->setModuleID($id);
      $aModule->delete();
   }

   static function commitModule($data)
   {
      $moduleName = $data['moduleName'];
      $moduleOptions = $data;
      $return = array();

      $fieldsNames = $data['moduleFieldName'];
      $fieldsInputs = $data['moduleFieldInput'];
      $fieldsStores = $data['moduleFieldStore'];
      $fieldsVisuals = $data['moduleFieldVisual'];
      $showInList = $data['fieldInListSelect'];
     
      $tables = dbTableController::createDBTablesForModule($moduleName,$moduleOptions,$fieldsNames,$fieldsStores,$showInList);
      $pages = pageController::createPagesForModule( $moduleName,
                        $moduleOptions,
                        $fieldsNames,
                        $fieldsInputs,
                        $fieldsStores,
                        $fieldsVisuals,
                        $data);

      //Sending Page and Table Names back to User
      $return['pages'] = $pages;
      $return['tables'] = $tables;

      return $return;
   }
}