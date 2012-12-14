function showGlobalVarsBox()
{
   var tabID = getNewTabID();
   var divElem = [{
      tagName:'div',
      id: tabID,
      innerHTML: $('#userManagement').html()
   }];
   $('#workingPanel').appendDom(divElem);
   $('#workingPanel > ul').tabs('add', '#' + tabID, 'New Table');
   //$('#userManagementBox').jqmShow();
   // To show hide Nested Categories Checkbox on Categories Checkbox
   bindCheckedDependentView('#enableUserManagement','#userManagementOptionDiv');
}