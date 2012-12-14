var userFieldHTML = '';
function showUserManagementBox()
{
   var tabID = getNewTabID();
   var divElem = [{
      tagName:'div',
      id: tabID,
      innerHTML: userManagementBoxHTML
   }];
   $('#workingPanel').appendDom(divElem);
   $('#workingPanel > ul').tabs('add', '#' + tabID, 'User Management');

   //For Save
   $('#' + tabID + ' #saveUserManagementButton').bind('click',{
      tabid : tabID
   },saveUserManagement);
   //For Adding New Field
   $('#' + tabID + ' #addUserField').bind('click',{
      tabid: tabID
   }, addUserField);

   //To Bind the delete a filed event on cross image click

   $("#" + tabID + ' #userManagementFieldsTable tbody td .deleteUserField').livequery('click',function (){
      if($("#" + tabID + ' #userManagementFieldsTable tbody td .deleteUserField').length > 1)
         $(this).parent().parent().fadeOut(700,function (){$(this).remove();});
      else
         alert("Atleast one field should remain intact.");
    return;
   });
   
   // To show hide Nested Categories Checkbox on Categories Checkbox
   bindCheckedDependentView('#enableUserManagement','#userManagementOptionDiv',true);
}

function addUserField(e)
{
 
   if(userFieldHTML == '')
      userFieldHTML = '<tr>' + $("#" + e.data.tabid + ' #userManagementFieldsTable tbody tr:first').html() + '</tr>';
   $("#" + e.data.tabid + ' #userManagementFieldsTable tbody').append(userFieldHTML);
}
function saveUserManagement()
{
   alert("save user management function is still to be implemented.")
}