<?php
include '../lib/dbtable.class.php';
include '../lib/controllers/controller.pages.php';
include '../lib/models/pages.class.php';

if($_REQUEST['action'] == 'save')
{
   echo pageController::save($_REQUEST);
}
else if($_REQUEST['action'] == 'getNames')
   echo pageController::getNamesList();

?>