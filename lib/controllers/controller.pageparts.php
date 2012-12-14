<?php
class pagePartController
{
   static function save($obj,$parentID = 0)
   {
      $aPagePart = new Pageparts();
      if($parentID)
         $aPagePart->setPagePartParentID($parentID);
         
      $aPagePart->setPagePartCategory($obj['category']);
      $aPagePart->setPagePartText($obj['text']);
      $aPagePart->insert();

      if(sizeof($obj['properties']))
         foreach($obj['properties'] as $key => $value)
            partPropertyController::save($key, $value, $aPagePart->getPagePartID());
         
      if(sizeof($obj['parts']))
         foreach($obj['parts'] as $part)
            pagePartController::save($part, $aPagePart->getPagePartID());
            
      return $aPagePart->getPagePartID();
   }

   static function getPagePartChildren($partID)
   {
      $aPagePart = new Pageparts();
      return $aPagePart->getList('pagePartParentID = ' . $partID);
   }
}
?>