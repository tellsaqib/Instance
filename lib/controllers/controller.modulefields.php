<?php
class moduleFieldController
{
   static function save($moduleID,$name,$input,$store,$visual,$showInList,$id = null)
   {
      $aModuleField = new Modulefields();

      $aModuleField->moduleFieldID = $id;
      $aModuleField->moduleID = $moduleID;
      $aModuleField->moduleFieldName = $name;
      $aModuleField->moduleFieldInput = $input;
      $aModuleField->moduleFieldStore = $store;
      $aModuleField->moduleFieldVisual = $visual;
      $aModuleField->moduleFieldShowInList = $showInList;

      if(is_null($id))
         $aModuleField->insert();
      else
         $aModuleField->update();
   }
   static function getModuleFields($moduleID)
   {
      $moduleFields = new Modulefields();
      return $moduleFields->getList('moduleID = ' . $moduleID);
   }
}