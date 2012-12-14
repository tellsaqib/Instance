<?php

include '../lib/createzipfile.php';
include '../lib/util.class.php';
include '../lib/dbtable.class.php';

include '../lib/controllers/controller.modulefields.php';
include '../lib/controllers/controller.modules.php';
include '../lib/controllers/controller.dbtables.php';
include '../lib/controllers/controller.dbtableFields.php';
include '../lib/controllers/controller.pages.php';
include '../lib/controllers/controller.pageparts.php';
include '../lib/controllers/controller.partproperties.php';

include '../lib/models/modules.class.php';
include '../lib/models/modulefields.class.php';
include '../lib/models/dbtables.class.php';
include '../lib/models/dbtablefields.class.php';
include '../lib/models/pages.class.php';
include '../lib/models/pageparts.class.php';
include '../lib/models/partproperties.class.php';

include '../lib/modelgenerator.class.php';
include '../lib/controllergenerator.class.php';
include '../lib/pagegenerator.class.php';

include '../lib/CodeBeautifier/index.php';

$downloadFilesPath = '../downloadfiles/';

$zipFile = new createZip();
createCSSFolder($zipFile);
createJScriptFolder($zipFile);
createImagesFolder($zipFile);

$zipFile->addDirectory("lib/");
$zipFile->addFile(file_get_contents($downloadFilesPath . 'lib/database.class.php'), "lib/database.class.php");
$zipFile->addFile(file_get_contents($downloadFilesPath . 'lib/dbtable.class.php'), "lib/dbtable.class.php");

//Creating Models and controllers for tables
$zipFile->addDirectory("lib/models");
$zipFile->addDirectory("lib/controllers");

$tables = dbTableController::getAllDBTables();
$sql = '';

foreach($tables as $table)
{
   //Get All Fields of the table
   $fields = dbTableFieldController::getDBTableFields($table->dbTableID);

   //Generate Model for the table and add to ZIP file
   $modelGenerator = new modelGenerator($table->dbTableName, $table->dbTableKeyField, $fields);
   $zipFile->addFile($modelGenerator->create(), 'lib/models/model.' . Util::getFileName($table->dbTableName) . '.php');

   //Generate Controller for the table and add to ZIP file
   $controllerGenerator = new controllerGenerator($table->dbTableName,$table->dbTableKeyField ,$fields);
   $zipFile->addFile($controllerGenerator->create(), 'lib/controllers/controller.' . Util::getFileName($table->dbTableName) . '.php');

   //Add Create Table SQL to the SQL contents
   $sql .= getTableSQL($table->dbTableName, $table->dbTableKeyField, $fields);
}
$zipFile->addFile($sql, 'sql.sql');

//creating pages
pageController::createIndexPage(); // Create Index Page
$pages = pageController::getAllPages();
foreach($pages as $page)
{
   $pageGenerator = new pageGenerator($page);
   $zipFile->addFile(beautifyCode($pageGenerator->create()), Util::getFileName($page->pageName) . '.php');
}

//Navigation Menu
$navigationContent = '<div id="navigation" >';
$modules = moduleController::getNamesList();
foreach($modules as $module)
   $navigationContent .= '<a href="' . Util::getFileName('List ' . $module->moduleName . '.php') . '">' .
                       $module->moduleName . '</a>' .  "\n";
$navigationContent .= '</div><h4 class="space" />';
$zipFile->addDirectory('includes/');
$zipFile->addFile($navigationContent, 'includes/navigation.php');

$fileName = "code.zip";
$fd = fopen ($fileName, "wb");
$out = fwrite ($fd, $zipFile->getZippedfile());
fclose ($fd);

$zipFile->forceDownload($fileName);
@unlink($fileName);

function getTableSQL($name,$id,$fields)
{   
   $str = 'CREATE TABLE `' . $name . '`' . "\n"."(";

   $str.='`' . Util::lowerFirstChar(Util::getSystemName($id)) .'` ' .'int (11) NOT NULL auto_increment , ';
   foreach($fields as $field)
	{
      $fieldName = Util::lowerFirstChar(Util::getSystemName($field->dbTableFieldName));
      
      if($field->dbTableFieldType == 'Number')
         $str.='`' . $fieldName .'` ' .'int (11) NOT NULL , ' . "\n";

      else if($field->dbTableFieldType == 'SmallText')
         $str.='`' . $fieldName .'` ' .'varchar (100) NOT NULL , '. "\n";

      else if($field->dbTableFieldType == 'BigText')
         $str.='`' . $fieldName .'` ' .'varchar (1000) NOT NULL , '. "\n";

      $str .= "\n";
	}
	$str .= 'PRIMARY KEY (`' . $id . '`)' . "\n";
   $str .= ')ENGINE=InnoDB  DEFAULT CHARSET=latin1;' . "\n";
   return $str;
}

function createCSSFolder(&$zipFile)
{
   $zipFile->addDirectory('css/');
   $files = array('reset','grid','typography', 'forms','elements','ie','dropdownmenu','rater');
   global $downloadFilesPath;

   $fileContents = '@charset "utf-8";' . "\n" . '/* CSS Document */';
   if($_REQUEST['CSSOption'] == 'all' || $_REQUEST['CSSOption'] == 'required')
   {  
      foreach($files as $file)
            $fileContents .= file_get_contents($downloadFilesPath . 'css/' . $file . '.css');

      //Add print.css
      $zipFile->addFile(file_get_contents($downloadFilesPath . 'css/print.css'), 'css/print.css' );
   }
   else
   {
      foreach($files as $file)
         if($_REQUEST[$file . 'CSS'] == 'on') // Only add Selected files
            $fileContents .= file_get_contents($downloadFilesPath . 'css/' . $file . '.css');

      if($_REQUEST['printCSS'] == 'on')//Add print.css if requested
         $zipFile->addFile(file_get_contents($downloadFilesPath . 'css/print.css'), 'css/print.css' );
   }

   //Send All css in single style.css file except print.css
   $zipFile->addFile($fileContents, 'css/style.css' );
}

function createJScriptFolder(&$zipFile)
{
   $zipFile->addDirectory('jscript/');
   $files = array('jquery','jquery.ui.core','util','rater');
   global $downloadFilesPath;

   if($_REQUEST['javaScriptOption'] == 'all' || $_REQUEST['javaScriptOption'] == 'required')
      foreach($files as $file)
         $zipFile->addFile(file_get_contents($downloadFilesPath . 'jscript/' . $file . '.js'), 'jscript/' . $file . '.js' );   
}
function createImagesFolder(&$zipFile)
{
   $zipFile->addDirectory('images/');
   $files = array('grid.png','star-matrix.gif','indicator.gif');
   global $downloadFilesPath;

   foreach($files as $file)
      $zipFile->addFile(file_get_contents($downloadFilesPath . 'images/' . $file ), 'images/' . $file );
}

?>