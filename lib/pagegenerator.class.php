<?php
class pageGenerator
{
   var $pageID;
   var $pageName;
   var $pageOperationID ;
   var $pageMetaID;
   var $pageContentID;

   function pageGenerator($page)
   {
      $this->pageID = $page->pageID;
      $this->pageName = $page->pageName;
      $this->pageOperationID = $page->pageOperationID;
      $this->pageMetaID = $page->pageMetaID;
      $this->pageContentID = $page->pageContentID;
   }

   function create()
   {
      $Code = '<?php ' . "\n";
      if($this->pageOperationID)
      {

         $parts = pagePartController::getPagePartChildren($this->pageOperationID);
         if(sizeof($parts))
         foreach($parts as $part)
         {
            $startCode = '';
            $endCode = '';
            pageGenerator::createPHPCodeForPart($part,$startCode,$endCode);
            $Code .= $startCode . $endCode;
         }
      }

      $Code .= ' ?>'. "\n";

      $Code .= '<html>'. "\n";
      $Code .= '<head>'. "\n";

      if($this->pageMetaID)
      {
         $parts = pagePartController::getPagePartChildren($this->pageMetaID);
         if(sizeof($parts))
         foreach($parts as $part)
         {
            $startCode = '';
            $endCode = '';
            pageGenerator::createHTMLForPart($part,$startCode,$endCode);
            $Code .= $startCode . $endCode;
         }
      }

      $Code .= '</head>'. "\n";
      $Code .= '<body>'. "\n";

      if($this->pageContentID)
      {
         $parts = pagePartController::getPagePartChildren($this->pageContentID);
         if(sizeof($parts))
         foreach($parts as $part)
         {
            $startCode = '';
            $endCode = '';
            pageGenerator::createHTMLForPart($part,$startCode,$endCode);
            $Code .= $startCode . $endCode;
         }
      }

      $Code .= '</body>'. "\n";
      $Code .= '</html>'. "\n";
      return $Code;
   }

   static function createHTMLForPart($part,&$startCode,&$endCode)
   {
      $properties = partPropertyController::getPagePartProperties($part->pagePartID);
      $parts = pagePartController::getPagePartChildren($part->pagePartID);

      if($part->pagePartCategory == 'literal')
         $startCode .= $part->pagePartText;
      else
      {
         $startCode .= '<' . $part->pagePartCategory;

         if(sizeof($properties))
            foreach ($properties as $property)
               $startCode.= ' ' . $property->propertyTitle . '="' . $property->propertyValue . '"';


         if(!sizeof($parts) && empty($part->pagePartText) )
            $startCode .= ' />'. "\n";
         
         else
         {
            $startCode.= ' >' . $part->pagePartText ;
            if(sizeof($parts))
               $endCode = "\n" . '</' . $part->pagePartCategory . '>' . $endCode;
            else
               $startCode .= '</' . $part->pagePartCategory . '>'. "\n";
         }
      }

      if(sizeof($parts))
         foreach($parts as $part)
            pageGenerator::createHTMLForPart($part,$startCode,$endCode);

   }
   function createPHPCodeForPart($part,&$startCode,&$endCode)
   {
      $startCode .= $part->pagePartText;
   }
}
?>