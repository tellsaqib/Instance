<?php
class partPropertyController
{
   static function save($propertyTitle,$propertyValue,$propertyPartID)
   {
      $aProperty = new Partproperties();
      $aProperty->setPropertyTitle($propertyTitle);
      $aProperty->setPropertyValue($propertyValue);
      $aProperty->setPropertyPartID($propertyPartID);
      $aProperty->insert();
      return $aProperty->getPropertyID();
   }

   static function getPagePartProperties($partID)
   {
      $aPagePartProperty = new Partproperties();
      return $aPagePartProperty->getList('propertyPartID = ' . $partID);
   }

}
?>