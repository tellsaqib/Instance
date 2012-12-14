var dbTableFieldHTML = '';
function showDBTableBox(e)
{
   if(e.data != undefined)
      var tabName = e.target.innerHTML;
   else 
      var tabName = 'New Table';
   
   var tabID = getNewTabID();
   var divElem = [{
      tagName:'div',
      id: tabID,
      innerHTML: dbTableBoxHTML
   }];
   
   $('#workingPanel').appendDom(divElem);
   $('#workingPanel > ul').tabs('add', '#' + tabID, tabName);

   if(e.data != undefined)
   {
      getJSONData('./php/dbtable.php?action=getDBTable', {dbTableID:e.target.id,tabID:tabID}, formatServerDBTable);
      $('#' + tabID + ' #deleteDBTableButton').removeClass('hide');
   }
   
   //For Saving Table
   $('#' + tabID + ' #saveTableButton').bind('click',{
      tabID : tabID
   },saveTable);

   //For changing key field name value
   $('#' + tabID + ' #dbTableName').change(function (){
      $('#' + tabID + ' #keyFieldName').attr('value',$(this).attr('value') + 'ID');
      return true;
      });

   //For Adding New Field
   $('#' + tabID + ' #addDBTableField').bind('click',{
      tabID: tabID
   }, addDBTableField);

   //To Bind the delete a field event on cross image click
   $("#" + tabID + ' #dbTableFieldsTable tbody td .deleteField').livequery('click',function (){
      if($("#" + tabID + ' #dbTableFieldsTable tbody td .deleteField').length > 1)
         $(this).parent().parent().fadeOut(700,function(){
            $(this).remove();
         });
      else
         alert("Atleast one field should remain intact.");
      return;
   });
}
function deleteDBTable(e)
{
   //alert(e.data.moduleID);
   makeAJAXCall('./php/dbtable.php?action=deleteTable',e.data, dbTableDeleted);
}
function dbTableDeleted(data)
{
   data = evalJSON(data);
   addToStatusBar('Table Deleted');
   $('#dbTableNameUl li[id=' + data.dbTableID + ']').remove();

   $('#workingPanel > ul').tabs( "remove",
      $("#workingPanel ul li a").index( $('#workingPanel ul li a[href=#' + data.tabID + ']') ));
}
function formatServerDBTable(data)
{
   //For deleting Module
   //alert($('#' + data.tabID + ' #deleteDBTableButton').length);
   $('#' + data.tabID + ' #deleteDBTableButton').bind('click',{
      tabID:data.tabID,
      dbTableID:data.dbTableSettings.dbTableID
   }, deleteDBTable);
   mapDBTableSettings(data.tabID, data.dbTableSettings, data.fields);
}

function appendDBTableNames(returned)
{
   var dbTableNameHTML = '';
   tables = returned;
   for(var obj in tables)
   {
      dbTableNameHTML += '<li id="' + tables[obj].dbTableID + '">' + tables[obj].dbTableName + '</li>';
   }
   $('#dbTableNameUl').append(dbTableNameHTML);
   $("#dbTableNameUl li:not(:first-child)").bind( "click",{getDBTable:true},showDBTableBox);
}
function addDBTableField(e)
{
   if(dbTableFieldHTML== '')
      dbTableFieldHTML = '<tr style="display:none;">' + $("#" + e.data.tabID + ' #dbTableFieldsTable tbody tr:first').html() + '</tr>';
   $("#" + e.data.tabID + ' #dbTableFieldsTable tbody').append(dbTableFieldHTML);
   $("#" + e.data.tabID + ' #dbTableFieldsTable tbody tr:last').fadeIn(700);
}

function saveTable(e)
{
   if($('#' + e.data.tabID + ' #saveDBTableForm').validate().form()) //Validate
   {
      var result = $('#' + e.data.tabID + ' #saveDBTableForm').serialize();
      addToStatusBar('Saving ' + $('#' + e.data.tabID + ' #saveDBTableForm #dbTableName').attr('value') + ' Table');
      makeAJAXCall('./php/dbtable.php?action=save&tabID=' + e.data.tabID,result,tableSaved,'');
   }
}
function tableSaved(returned)
{
   returned = evalJSON(returned);
   if(isNumeric(returned.result))
   {
      $('#' + returned.tabID + ' #deleteDBTableButton').removeClass('hide');
      $('#' + returned.tabID + ' #dbTableID').attr('value',returned.result);
      //For deleting Table
      $('#' + returned.tabID + ' #deleteDBTableButton').bind('click',{
         tabID:returned.tabID,
         dbTableID:returned.result
         }, deleteDBTable);
      appendDBTableNames({addedTable:{dbTableID:returned.result,dbTableName:$('#' + returned.tabID + ' #dbTableName').attr('value')}});
   }
   else
      addToStatusBar(returned.result);
}
function mapDBTableSettings(tabID,options,valObject)
{
   $('#' + tabID + ' #dbTableName').attr('value',options.dbTableName);
   $('#' + tabID + ' #dbTableID').attr('value',options.dbTableID);
   $('#' + tabID + ' #keyFieldName').attr('value',options.keyFieldName);
   //alert(options.keyFieldName);

   $('#' + tabID + ' #moduleFieldsTable tbody tr').each(function(i){
      if(i != 0) $(this).remove();
   });

   for(loop=1; loop<valObject.length; loop++)
      $('#' + tabID + ' #addDBTableField').click();

   var fieldNames = $('#' + tabID + ' input[name^=dbTableFieldName]');
   var fieldTypes = $('#' + tabID + ' select[name^=dbTableFieldInput]');

   fieldNames.each(function(index){
      $(this).attr('value',valObject[index].dbTableFieldName);
   });
   fieldTypes.each(function(index){
      $(this).attr('selectedIndex',valObject[index].dbTableFieldType);
   });
}