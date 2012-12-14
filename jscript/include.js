var elementBoxHTML = '';
var pageBoxHTML = '';
var moduleBoxHTML = '';
var dbTableBoxHTML = '';
var componentBoxHTML = '';
var glabalVarsBoxHTML = '';
var userManagementBoxHTML = '';

// Global JSON Objects
var modules;

$(document).ready(function()
{
   var $tabs = $('#workingPanel > ul').tabs({
      add: function(e, ui) {
         $tabs.tabs('select', '#' + ui.panel.id);
      }
   });
   addToStatusBar('Data Loading...');
   getJSONData('./php/module.php?action=getNames','',appendModuleNames);
   getJSONData('./php/dbtable.php?action=getNames','',appendDBTableNames);
   getJSONData('./php/page.php?action=getNames','',appendPageNames);

   //makeAJAXCall('./lib/views/element.html','', function(r) {elementBoxHTML = r;},'');
   makeAJAXCall('./lib/views/page.html',null, function(r) {
      pageBoxHTML = r;
   },null);
   makeAJAXCall('./lib/views/module.html',null, function(r) {
      moduleBoxHTML = r;
   },null);
   makeAJAXCall('./lib/views/dbtable.html',null, function(r) {
      dbTableBoxHTML = r;
   },null);
   makeAJAXCall('./lib/views/component.html',null, function(r) {
      componentBoxHTML = r;
   },null);
   //makeAJAXCall('./lib/views/globalVars.html','', function(r) {glabalVarsBoxHTML = r;},'');
   makeAJAXCall('./lib/views/userManagement.html',null, function(r) {
      userManagementBoxHTML = r;
   },null);
   makeAJAXCall('./lib/views/download.html',null, function(r) {
      downloadBoxHTML = r;
   },null);
   
   addToStatusBar('Loading Complete');
   
   //$("#div").bind( "click", showElementBox);
   $("#addPage").bind( "click", showPageBox);
   $("#addModule").bind( "click", showModuleBox);
   $("#addTable").bind( "click", showDBTableBox);
   //$("#addComponent").bind( "click", showComponentBox);
   //$("#globalVars").bind( "click", showGlobalVarsBox);
   $("#userManagement").bind( "click", showUserManagementBox);
   $("#download").bind( "click", showDownloadBox);

   $("#closeTab").bind('click',function(){
      var selectedIndex = $tabs.data('selected.tabs');
      if(selectedIndex != 0)
         $('#workingPanel > ul').tabs("remove",selectedIndex)
   });
   $('#resetProject').bind('click', null, function(){
      return confirm("Click OK to reset project data.");
   });
});