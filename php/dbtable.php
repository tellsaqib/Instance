<?php
include '../lib/dbtable.class.php';

include '../lib/controllers/controller.dbtablefields.php';
include '../lib/controllers/controller.dbtables.php';

include '../lib/models/dbtables.class.php';
include '../lib/models/dbtablefields.class.php';

if($_REQUEST['action'] == 'save')
{
   $result = array();
   $result['result'] = dbTableController::save($_REQUEST);
   $result['tabID'] = $_REQUEST['tabID'];
   echo json_encode($result);
}
else if($_REQUEST['action'] == 'getNames')
echo json_encode(dbTableController::getNamesList());

else if($_REQUEST['action'] == 'getDBTable')
{
   $result = array();
   $result['dbTableSettings'] = dbTableController::getDBTable($_REQUEST['dbTableID']);
   $result['fields'] = dbTableFieldController::getDBTableFields($result->dbTableSettings->dbTableID);
   $result['tabID'] = $_REQUEST['tabID'];
   echo json_encode($result);   
}
else if($_REQUEST['action'] == 'deleteTable')
{
   $result = array();
   $result['result'] = dbTableController::deleteDBTable($_REQUEST['dbTableID']);
   $result['tabID'] = $_REQUEST['tabID'];
   $result['dbTableID'] = $_REQUEST['dbTableID'];

   echo json_encode($result);
}
?>