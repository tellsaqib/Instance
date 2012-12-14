<?php
include '../lib/dbtable.class.php';
include '../lib/util.class.php';

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

if($_REQUEST['action'] == 'save')
{
   $result = array();
   $result['result']= moduleController::save($_REQUEST);
   $result['tabID'] = $_REQUEST['tabID'];
   echo json_encode($result);
}
else if($_REQUEST['action'] == 'getNames')
   echo json_encode(moduleController::getNamesList());

else if($_REQUEST['action'] == 'getModule')
{
   $result = array();
   $result['moduleSettings'] = moduleController::getModule($_REQUEST['moduleID']);
   $result['fields']= moduleFieldController::getModuleFields($result['moduleSettings']->moduleID);
   $result['tabID']= $_REQUEST['tabID'];
   echo json_encode($result);   
}
else if($_REQUEST['action'] == 'deleteModule')
{
   $result = array();
   $result['result'] = moduleController::deleteModule($_REQUEST['moduleID']);
   $result['tabID'] = $_REQUEST['tabID'];
   $result['moduleID'] = $_REQUEST['moduleID'];
   
   echo json_encode($result);
}
else if($_REQUEST['action'] == 'commit')
{
   $id = moduleController::save($_REQUEST);

   if(!$_REQUEST['moduleID']) // IF new module
      $_REQUEST['moduleID'] = $id;
      
   $return =  moduleController::commitModule($_REQUEST);
   
   $return['tabID'] = $_REQUEST['tabID'];
   echo json_encode($return);
}
?>