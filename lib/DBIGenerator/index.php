<?php
/*
 Class Generator UI

 ----------------------------------------------------------------------
 Modifications:
 I made some alterations in its generator Class package.
 - election of to be used Database.
 - generation of the class in different directories for each database.
 Marley Adriano de Souza Silva <marleyas@gmail.com>

 In this modification, you don't have to touch the configuration anymore to
 explicitly define the database name  the database would be retrived from the tables
 defined in your database server.

 Bug fix:
 - Resolve the 0 table database causing php to throw a foreach error for 0 element array
 John paul de guzman <jpdguzman@gmail.com>

 */
include 'configuration.php';
include 'dbtabaleinterfacegenerator.class.php';
$GLOBALS['dbConn'] = $dbConn;

$__tableListings = $dbConn->getTable();

$__dbListings = $dbConn->getDb();

// generate classes
if(isset($_POST['action']) && $_POST['action'] == "generate")
{
   // BUG FIX: for database with 0 tables found.
   if(count($__tableListings) > 0) {

      // retrived all registered tables
      $__tables = array_keys($__tableListings);
      // status report for display

      $statusReport = "";
      $tableFields = $dbConn->getTable();

      foreach($__tables as $tbl)
      {
         $options = array();
         // if the table is selected then perfrom generation of classes
         if(!empty($_POST[$tbl.'_ck']))
         {
            foreach ($tableFields[$tbl] as $field)
            {
               $options[$field] = $field;
            }
            $__generator = new DBTableInterfaceGenerator($tbl,$_POST[$tbl.'_sel'],'../models/',$options);
            $__generator->create();

            $statusReport .= "Class successfully generated: $tbl<br>";
         }
         $_POST['action'] = "";
      }
   }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>DB Class Generator : Project Startup Toolkit</title>
      <link href="style/default.css" rel="stylesheet" type="text/css" />
   </head>

   <body>

      <div align="center">
         <div id="maincontainer">
            <div><img src="images/left_top_sidebarshadow.jpg" width="566" height="77" /></div>
            <div align="center" style="width:566">
               <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                     <td width="21" rowspan="2"><img src="images/left_top_shadowtab.jpg" width="21" height="25" /></td>
                     <td width="73"><img src="images/top_.jpg" width="73" height="9" /></td>
                     <td width="206" rowspan="2"><img src="images/right_top_sidebarshadow.jpg" width="471" height="25" /></td>
                  </tr>
                  <tr>
                     <td><a href="index.setup.php"><img src="images/main_08.jpg" width="73" height="16" border="0" /></a></td>
                  </tr>
               </table>
            </div>
            <div id="contentcontainer" align="left">
               <div id="content">
                  <div class="head_1">Select Database to Use</div><br />
                  <form name="db_f" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post">
                     <div>Please Select the database you want to use
                        <select name="db_name" onchange="document.forms['db_f'].submit()">
                           <?php
                           foreach($__dbListings as $_index => $_dbName) {
                           $selected = '';
                           if($_dbName == $dbName){
                              $selected = 'selected';
                           }
                           echo "<option value=\"$_dbName\" $selected>$_dbName</option>\n";
                           }
                           ?>
                        </select>
                     </div>
                     <div class="head_1">Select Database tables to Generate</div><br />
                     <div>				    Pls Select all the tables you want to generate a Class.<br />
                        Specify the keys for retriving data (ei. Primary Key).
                     </div>
                     <div class="head_2" id="separator">Location of Generated Objects </div>
                     <div>Location specified can be an: <br>&nbsp;&nbsp;&nbsp;Absolute path (C:/path/to/your/app/objects/<?php echo($dbName); ?>) or
                        <br>&nbsp;&nbsp;&nbsp;Relative path
                        (/path/to/your/app/objects/<?php echo($dbName); ?>).  <br /><br /><b>Note: Don't forget to add (/) after the end of the location.</b>
                     </div>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                           <td width="21%" height="35">Path </td>
                           <td width="79%" height="35"><input name="_genField" type="text" class="input" id="_genField" value="objects/<?php echo($dbName); ?>/" /></td>
                        </tr>
                     </table>

                     <?php if(!empty($statusReport)) { ?>
                     <div id="action">
                        <div class="head_2">Action Commited: </div>
                        <?php echo $statusReport;?>
                     </div><br />
                     <?php
                     $statusReport = "";
                     } ?>

                     <div>
                        <div class="head_2" id="separator">Database Tables </div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                           <tr>
                              <td width="7%" height="31" class="base">&nbsp;</td>
                              <td width="59%" class="base">Database Table </td>
                              <td width="34%" class="base">Key Field  </td>
                           </tr>
                           <?php
                           // BUG FIX: for 0 table database
                           if(count($__tableListings) > 0) {
                           foreach($__tableListings as $_tbleName => $_fields) {
                              ?>
                           <tr>
                              <td height="25" align="center" class="base_c"><input type="checkbox" name="<?php echo $_tbleName."_ck" ?>" value="<?php echo $_tbleName; ?>" /></td>
                              <td height="25" class="base_c"><div class="table_name"><?php echo $_tbleName ?></div></td>
                              <td height="25" class="base_c">
                                 <select name="<?php echo $_tbleName."_sel" ?>">
                                    <?php foreach($_fields as $__f) {?>
                                    <option value="<?php echo $__f; ?>"><?php echo $__f; ?></option>
                                    <?php } ?>
                              </select>							</td>
                           </tr>
                           <?php 	    }
                        } ?>
                           <tr>
                              <td height="45" colspan="3" style="padding-left:10px;">

                                 <input type="submit" value="Generate Classes" />
                                 <input type="hidden" name="action" value="generate" />

                              </td>
                           </tr>

                        </table>

                     </div>
                  </form>
               </div>
               <img src="images/center_main_contentBg.jpg" />
            </div>
         </div>
      </div>
   </body>
</html>
