<?php
class pageController
{
   static function save($obj)
   {
      $result = -1;

      $aPage= new Pages();
      $aPage->setPageName($obj['pageName']);

      if(sizeof($obj['meta']))
      $aPage->setPageMetaID(pagePartController::save($obj['meta']));

      if(sizeof($obj['operation']))
      $aPage->setPageOperationID(pagePartController::save($obj['operation']));

      if(sizeof($obj['content']))
      $aPage->setPageContentID(pagePartController::save($obj['content']));

      if($obj['pageID'])
      {
         $aPage->setPageID($obj['pageID']);
         $aPage->update();
          /*

         $tableFields = dbTableFieldController::getDBTableFields($aPage->getDbTableID());
         if(sizeof($tableFields))
         {
            foreach($tableFields as $field)
            {
               $aField = new Dbtablefields();
               $aField->setDbTableFieldID($field->dbTableFieldID);
               $aField->delete();
            }
         }
           *
           */
         $result = 0;
      }
      else
      {
         $aPage->insert();
         $result = $aPage->getPageID();
      }
      /*

      $fieldNames = $data['dbTableFieldName'];
      $fieldTypes = $data['dbTableFieldType'];

      for($loop=0,$len = sizeof($fieldNames); $loop<$len; $loop++)
      {
         dbTableFieldController::save($aPage->getDbTableID(),$fieldNames[$loop],$fieldTypes[$loop]);
      }

      */
      return  $result;
   }

   static function getNamesList()
   {
      $fieldList = array();
      $fieldList[] = 'pageID';
      $fieldList[] = 'pageName';

      $pagesList = new Pages();
      $pageNames = $pagesList->getFields($fieldList);
      $returnStr = '';
      if($pageNames)
      {
         $returnStr =  json_encode($pageNames);
      }
      return $returnStr;
   }

   static function getAllPages()
   {
      $aPage = new Pages();
      return $aPage->getList();
   }

   static function createIndexPage()
   {
      $br = array('category' => 'br'); //br element
      $container = array('category'=>'div','properties'=>array('class'=>'container')); //Main Page Wrapper
      
      $modules = moduleController::getNamesList();
      $pageObject = array();
      $pageObject['pageName'] = 'index';

      $pageObject['meta']['parts'][] = array('category' => 'link', 'properties' =>
         array('href' => 'css/style.css', 'rel' => 'stylesheet', 'type' => 'text/css'));

      $includeNavigation = array('category' => 'literal', 'text' => '<?php include \'includes/navigation.php\'; ?>');
      $heading = array('category'=> 'h1','text'=>'Home Page');
      
      $container['parts'] = array($includeNavigation,$heading);
      $pageObject['content']['parts'] = array($container);
      
      return pageController::save($pageObject);
      
   }

   static function createPagesForModule( $moduleName,
      $moduleOptions,
      $fieldsNames,
      $fieldsInputs,
      $fieldsStores,
      $fieldsVisuals,
      $data)
   {
      //print_r($data);exit;
      $pages = array();
      $moduleSystemName = Util::getSystemName($moduleName);
     
      //Module Statistics page
      if($moduleOptions['moduleStatistics'] == 'on')
      {
         //$pages[] = $moduleSystemName . 'Statistics';
         $pageObject = array();

         $pageObject['pageName'] = $moduleSystemName . 'Statistics';
         //pageController::save($pageObject);
      }
      
      $br = array('category' => 'br'); //br element
      $includeNavigation = array('category' => 'literal', 'text' => '<?php include \'includes/navigation.php\'; ?>');
      $container = array('category'=>'div','properties'=>array('class'=>'container')); //Main Page Wrapper
      
      //Module Save Page

      $aForm = array();
      $aForm['properties'] = array('method' => 'post');
      $aForm['category'] = 'form';

      $fieldsLength = count($fieldsNames);

      $formParts = array();
      $formParts[] = array('category'=> 'a', 'text' => $moduleName . ' List',
                           'properties' => array('class'=>'blockLink last', 'href' => Util::getFileName('List ' . $moduleSystemName . '.php')));
      $formParts[] = array('category'=> 'h3', 'text' => 'Fill in the details and press save');

      //Hidden ID field
      $formItem = array();
      $formItem['category'] = 'input';
      $formItem['properties'] = array('type' => 'hidden' ,
                                      'name' => Util::lowerFirstChar($moduleSystemName. 'ID') ,
                                      'id' => Util::lowerFirstChar($moduleSystemName. 'ID'),
                                      'value' => '<?php echo $record->' . Util::lowerFirstChar($moduleSystemName. 'ID') . '; ?>'
                                     );
     $formParts[] = $formItem;

      $first = true;
      for($loop=0;$loop<$fieldsLength;$loop++)
      {
         $formItem = array();
         $formItem['properties'] = array('class' => 'formLabel');
         $formItem['category'] = 'label';
         $formItem['text'] = $fieldsNames[$loop];
         
         switch($fieldsInputs[$loop])
         {
            case 'Text':
               $formParts[] = $formItem;
               $formParts[] = $br;
               $formItem = array();
               $formItem['category'] = 'input';
               $formItem['properties'] = array('type' => 'text' ,
                                               'name' => Util::lowerFirstChar(Util::getSystemName($fieldsNames[$loop])) ,
                                               'id' => Util::lowerFirstChar(Util::getSystemName($fieldsNames[$loop])),
                                               'value' => '<?php echo $record->' . Util::lowerFirstChar(Util::getSystemName($fieldsNames[$loop])) . '; ?>'
                                              );
               if($first)
               {
                  $formItem['properties']['class'] = 'title';
                  $first = false;
               }
               else
                  $formItem['properties']['class'] = 'text';
               break;

            case 'HTMLEditor':
               $formParts[] = $formItem;
               $formParts[] = $br;
               $formItem = array();
               $formItem['category'] = 'textarea';
               $formItem['text'] = '<?php echo $record->' . Util::lowerFirstChar(Util::getSystemName($fieldsNames[$loop])) . '; ?>';
               $formItem['properties'] = array('cols' => '20' ,
                                               'rows' => '5',
                                               'name' => Util::lowerFirstChar(Util::getSystemName($fieldsNames[$loop])) ,
                                               'id' => Util::lowerFirstChar(Util::getSystemName($fieldsNames[$loop]))
                                              );
               break;
         }
         $formParts[] = $formItem;
         $formParts[] = $br;
      }
      $formParts[] = array('category' => 'input','properties' =>
         array('type' => 'submit', 'class'=> 'button', 'value' => 'Save', 'name' => 'action'));
      $aForm['parts'] = $formParts;

      $pageObject = array();
      $pageObject['pageName'] = 'Save ' . $moduleName;
      $pageObject['operation']['parts'][] =
      array('text' => "include 'lib/dbtable.class.php'; " . "\n" .
         "include 'lib/controllers/controller." . Util::getFileName($moduleSystemName) . ".php';" .  "\n" .
            "include 'lib/models/model." . Util::getFileName($moduleSystemName) . ".php';" .  "\n" .
            'if($_REQUEST[\'action\'] == \'Save\')' .  "\n" .
         $moduleSystemName  . 'Controller::save($_REQUEST);' . "\n" .
         'else if($_REQUEST[\'id\']) $record = ' . $moduleSystemName  . 'Controller::get' . $moduleSystemName . '($_REQUEST[\'id\']);'
      ////         'else if($_REQUEST[\'action\'] == \'vote\')' .  "\n" .
//         $moduleSystemName  . 'Controller::save($_REQUEST);'
                 );
      $pageObject['meta']['parts'][] = array('category' => 'title', 'text' => 'Save ' . $moduleName);
      $pageObject['meta']['parts'][] = array('category' => 'link', 'properties' =>
         array('href' => 'css/style.css', 'rel' => 'stylesheet', 'type' => 'text/css'));

      $container['parts'] = array($includeNavigation, $aForm);
      $pageObject['content']['parts'] = array($container);
      
      $id = pageController::save($pageObject);
      $pages[] = array('pageID' => $id, 'pageName' => $moduleSystemName . 'Save');

      //Module List Page

      $listCode .= '<a class="blockLink last" href="' . Util::getFileName('Save ' . $moduleSystemName . '.php') .'" >Add ' .$moduleName . '</a>';
      $documentReadyFunc = '';
      if($data['listingStyle'] == 'forumType')
      {
         $listCode .= '<?php if(sizeof($recordList))' . "\n" . ' foreach($recordList as $record){' . "\n";
         $listCode .= '?>' . "\n" . '<hr class="space" />';
         $listCode .= '<div class="span-10 prepend-1 colborder">' . "\n" . '<?php' . "\n";
         $first = true;
         foreach ($fieldsNames as $fieldName)
         {
            if(in_array($fieldName, $data['fieldInListSelect']))
               if($first)
               {
                  $listCode .= 'echo \'<h3>\' . $record->' . Util::lowerFirstChar(Util::getSystemName($fieldName)) . " . '</h3>';";
                  $first = false;
               }
               else
                  $listCode .= 'echo $record->' . Util::lowerFirstChar(Util::getSystemName($fieldName)) . " . '<br />';";
         }
         $listCode .= 'echo \'</div><div class="span-7 last">\';';
         $listCode .= 'echo \'<b>Averate Rating<b><br /><div id="avgRating\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'"></div>\';';
         $listCode .= 'echo \'<b>Your Rating<b><br /><div id="yourRating\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'"></div>\';';
         $listCode .= 'echo \'</div><br /> \';';
         if($data['separateDetailPage'] == 'on')
            $listCode .= 'echo \'<td><a class="blockLink distance" href="' . Util::getFileName('Detail ' . $moduleName) .
                        '.php?id=\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'" >View</a></td>\';';
         $listCode .= 'echo \'<a class="blockLink distance" href="' . Util::getFileName('Save ' . $moduleName) .
                        '.php?id=\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'" >Edit</a>\';';
         $listCode .= 'echo \'<a class="blockLink distance" href="' . Util::getFileName('List ' . $moduleName) .
                           '.php?action=delete&id=\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'" >Delete</a>\';';
         $listCode .= 'echo \'<hr class="space" />\';} ?>';
      }
      else if($data['listingStyle'] == 'table')
      {
         $listCode .= '<table class="distanceTable borderedTable"><thead>';
         foreach ($fieldsNames as $fieldName)
         if(in_array($fieldName, $data['fieldInListSelect']))
            $listCode .= '<th>' . $fieldName . '</th>';
         $listCode .= '<th>Average Rating</th>';
         $listCode .= '<th>Your Rating</th>';
         $listCode .= '<th colspan="3">Actions</th>';
         $listCode .= '</thead><tbody>';
         $listCode .= '<?php ' . "\n" . ' foreach($recordList as $record){';
         $listCode .= 'echo \'<tr>\';';
         foreach ($fieldsNames as $fieldName)
            if(in_array($fieldName, $data['fieldInListSelect']))
               $listCode .= 'echo ' . "'<td>' . " . '$record->' . Util::lowerFirstChar( Util::getSystemName( $fieldName )) . " . '</td>';";
         $listCode .= 'echo \'<td><div id="avgRating\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'"></div></td>\';';
         $listCode .= 'echo \'<td><div id="yourRating\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'"></div></td>\';';
         $listCode .= 'echo \'</div><br /> \';';
         if($data['separateDetailPage'] == 'on')
            $listCode .= 'echo \'<td><a class="blockLink distance" href="' . Util::getFileName('Detail ' . $moduleName) .
                        '.php?id=\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'" >View</a></td>\';';
         $listCode .= 'echo \'<td><a class="blockLink distance" href="' . Util::getFileName('Save ' . $moduleName) .
                        '.php?id=\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'" >Edit</a></td>\';';
         $listCode .= 'echo \'<td><a class="blockLink distance" href="' . Util::getFileName('List ' . $moduleName) .
                           '.php?action=delete&id=\' . $record->' . Util::lowerFirstChar($moduleSystemName) . 'ID . \'" >Delete</a></td>\';';
         $listCode .= 'echo \'</tr>\';} ?>';
         $listCode .= '</tbody></table>';
      }
      $pageObject = array();
      $pageObject['pageName'] = 'List ' . $moduleName;

      $pageObject['operation']['parts'][] =
      array('text' => "include 'lib/dbtable.class.php'; include 'lib/controllers/controller." . Util::getFileName($moduleSystemName) . ".php';" .
            "include 'lib/models/model." . Util::getFileName($moduleSystemName) . ".php';" .
            '$recordList = ' . $moduleSystemName  . 'Controller::getList();');

      $pageObject['meta']['parts'][] = array('category' => 'title', 'text' => $moduleName . ' List');
      $pageObject['meta']['parts'][] = array('category' => 'link', 'properties' =>
         array('href' => 'css/style.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
      
      $documentReadyFunc .= "\n" . '$().ready(function(){' . "\n" ;
      $documentReadyFunc .= '<?php foreach($recordList as $record){ ?>' . "\n";
      $documentReadyFunc .= '$(\'#avgRating<?php echo $record->' . Util::lowerFirstChar($moduleSystemName) .
                           'ID; ?>\').rater({value: 3 , enabled: false });' . "\n";
      $documentReadyFunc .= '$(\'#yourRating<?php echo $record->' . Util::lowerFirstChar($moduleSystemName) .
                     'ID; ?>\').rater({url:\'' . Util::getFileName('List ' . $moduleSystemName . '.php') .'\' ,mediapath:\'images/\'});' . "\n";
      $documentReadyFunc .= "\n" . '<?php }?>';
      $documentReadyFunc .= "\n" . '});';
      
      $pageObject['meta']['parts'][] = array('category' => 'script',
                                             'properties' => array('type' => 'text/javascript',
                                                                   'src' => 'jscript/jquery.js'),
                                             'text' => ' ' );
      $pageObject['meta']['parts'][] = array('category' => 'script',
                                             'properties' => array('type' => 'text/javascript',
                                                                   'src' => 'jscript/rater.js'),
                                             'text' => ' ' );
      
      $pageObject['meta']['parts'][] = array('category' => 'script',
                                             'properties' => array('type' => 'text/javascript'),
                                             'text' => $documentReadyFunc  );

      $container['parts'] = array($includeNavigation);
      $container['parts'][] = array('category'=> 'h3', 'text' => 'This is ' . $moduleName . 'List');
      $container['parts'][] = array('category' => 'literal','text' => $listCode);
      $pageObject['content']['parts'] = array($container);

      $id =pageController::save($pageObject);
      $pages[] = array('pageID' => $id, 'pageName' => $moduleSystemName . ' List');

      //Module Detal Page
      $listCode .= '<a class="blockLink last" href="' . Util::getFileName('Save ' . $moduleSystemName . '.php') .'" >Add ' .$moduleName . '</a>';
      $listCode .= '<a class="blockLink last" href="' . Util::getFileName('List ' . $moduleSystemName . '.php') .'" >'.$moduleName . ' List</a>';
      if($data['separateDetailPage'] == 'on')
      {
         $detailCode .= '<?php'. "\n";
         foreach ($fieldsNames as $fieldName)
         $detailCode .= 'echo \'<b>' . $fieldName . ': </b>\' . $record->' . Util::lowerFirstChar(Util::getSystemName($fieldName)) . " . '<br />';" . "\n";
         $detailCode .= '?>'. "\n";

         $pageObject = array();
         $pageObject['pageName'] = 'Detail ' . $moduleName;

         $pageObject['operation']['parts'][] =
         array('text' => "include 'lib/dbtable.class.php'; include 'lib/controllers/controller." . Util::getFileName($moduleSystemName) . ".php';" .
            "include 'lib/models/model." . Util::getFileName($moduleSystemName) . ".php';" .
            '$record = ' . $moduleSystemName  . 'Controller::get' . $moduleSystemName . '($_REQUEST[\'id\']);');

         $pageObject['meta']['parts'][] = array('category' => 'title', 'text' => $moduleName . ' Detail');
         $pageObject['meta']['parts'][] = array('category' => 'link', 'properties' =>
            array('href' => 'css/style.css', 'rel' => 'stylesheet', 'type' => 'text/css'));

         $container['parts'] = array($includeNavigation);
         $container['parts'][] = array('category'=> 'h3', 'text' => 'This is ' . $moduleName . 'Detail');
         $container['parts'][] = array('category' => 'literal','text' => $detailCode);
         $pageObject['content']['parts'] = array($container);


         $id =pageController::save($pageObject);
         $pages[] = array('pageID' => $id, 'pageName' => $moduleSystemName . ' Detail');
      }

      return $pages;
   }
}
?>