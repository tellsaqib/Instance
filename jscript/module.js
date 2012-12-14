var moduleTemplatesList = ['Blog','Forum','Shopping Cart','Directory'];
var moduleFieldHTML = '';

function saveModule(e)
{
   if($('#' + e.data.tabID + ' #saveModuleForm').validate().form()) //Validate
   {
      var result = $('#' + e.data.tabID + ' #saveModuleForm').serialize();
      addToStatusBar('Saving ' + $('#' + e.data.tabID + ' #saveModuleForm #moduleName').attr('value') + ' Module');
      makeAJAXCall('./php/module.php?action=save&tabID=' + e.data.tabID,result,moduleSaved,null);
   }
}
function moduleSaved(returned)
{
   returned = evalJSON(returned);
   if(isNumeric(returned.result))
   {
      $('#' + returned.tabID + ' #deleteModuleButton').removeClass('hide');
      $('#' + returned.tabID + ' #moduleID').attr('value',returned.result);

      //For deleting Module
      $('#' + returned.tabID + ' #deleteModuleButton').bind('click',{
         tabID:returned.tabID,
         moduleID:returned.result
      }, deleteModule);
         
      appendModuleNames({
         addedModule:{
            moduleID:returned.result,
            moduleName:$('#' + returned.tabID + ' #moduleName').attr('value')
         }
      });
   }
   else
      addToStatusBar(returned.result);
}
function addModuleField(e)
{
   if(moduleFieldHTML == '')
      moduleFieldHTML = '<tr style="display:none;">' + $("#" + e.data.tabID + ' #moduleFieldsTable tbody tr:first').html() + '</tr>';
   $("#" + e.data.tabID + ' #moduleFieldsTable tbody').append(moduleFieldHTML);
   $("#" + e.data.tabID + ' #moduleFieldsTable tbody tr:last').fadeIn(700);
}
function showModuleBox(e)
{  
   if(e.data != undefined)
      var tabName = e.target.innerHTML;
   else 
      var tabName = 'New Module';
   
   var tabID = getNewTabID();
   var divElem = [{
      tagName:'div',
      id: tabID,
      innerHTML: moduleBoxHTML
   }];
   $('#workingPanel').appendDom(divElem);
   $('#workingPanel > ul').tabs('add', '#' + tabID, tabName);
   
   if(e.data != undefined)
   {
      getJSONData('./php/module.php?action=getModule', {
         moduleID:e.target.id,
         tabID:tabID
      }, formatServerModule);
      //For delete button
      $('#' + tabID + ' #deleteModuleButton').removeClass('hide');
   }
   
   //For Save
   $('#' + tabID + ' #saveModuleButton').bind('click',{
      tabID : tabID
   },saveModule);

   //For Commiting Module
   $('#' + tabID + ' #commitModuleButton').bind('click',{
      tabID : tabID
   },commitModule);
   
   //For Adding New Field
   $('#' + tabID + ' #addModuleField').bind('click',{
      tabID: tabID
   }, addModuleField);

   //For Moduel Templates
   $('#' + tabID + ' #moduleTemplatesSelect').bind('change',{
      tabID: tabID
   }, customizeModule);
   
   //To Bind the delete a filed event on cross image click

   $("#" + tabID + ' #moduleFieldsTable tbody td .deleteModule').livequery('click',function (){
      if($("#" + tabID + ' #moduleFieldsTable tbody td .deleteModule').length > 1)
         $(this).parent().parent().fadeOut(1000,function (){
            $(this).remove();
         });
      else
         alert("Atleast one field should remain intact.");
      return;
   });

   // To show hide Nested Categories Checkbox on Categories Checkbox
   bindCheckedDependentView('#' + tabID + ' #moduleCategories','#' + tabID + ' #categriesOptionDiv',true);
   bindCheckedDependentView('#' + tabID + ' #moduleComments','#' + tabID + ' #commentsOptionDiv',true);
}
function deleteModule(e)
{
   makeAJAXCall('./php/module.php?action=deleteModule',e.data, moduleDeleted);
}
function moduleDeleted(data)
{
   data = evalJSON(data);
   addToStatusBar('Module Deleted');
   $('#moduleNameUl li[id=' + data.moduleID + ']').remove();
   
   $('#workingPanel > ul').tabs( "remove",
      $("#workingPanel ul li a").index( $('#workingPanel ul li a[href=#' + data.tabID + ']') ));
}
function formatServerModule(data)
{
   //For deleting Module
   $('#' + data.tabID + ' #deleteModuleButton').bind('click',{
      tabID:data.tabID,
      moduleID:data.moduleSettings.moduleID
   }, deleteModule);
   mapModuleSettings(data.tabID, data.moduleSettings, data.fields);
}
function appendModuleNames(returned)
{
   var moduleNameHTML = '';
   modules = returned;
   for(var obj in modules)
   {
      moduleNameHTML += '<li id="' + modules[obj].moduleID + '">' + modules[obj].moduleName + '</li>';
   }
   $('#moduleNameUl').append(moduleNameHTML);
   $("#moduleNameUl li:not(:first-child)").bind( "click",{
      getModule:true
   },showModuleBox);
}
function customizeModule(event)
{
   switch (this.selectedIndex)
   {
      case 1://Blog
         var options = {
            moduleName:'Blog',
            moduleCategories:true,
            moduleNestedCategories:true,
            moduleTags:true,
            moduleComments:true,
            moduleNestedComments:true,
            moduleItemRating:false,
            moduleStatistics:true
         };
         var valObject = new Array(5);
         valObject[0] = {
            moduleFieldName:'Title',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[1] = {
            moduleFieldName:'Author',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[2] = {
            moduleFieldName:'Content',
            moduleFieldInput:4,
            moduleFieldStore:2,
            moduleFieldVisual:2
         };
         valObject[3] = {
            moduleFieldName:'permaLink',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:0
         };
         valObject[4] = {
            moduleFieldName:'status',
            moduleFieldInput:1,
            moduleFieldStore:0,
            moduleFieldVisual:0
         };
         mapModuleSettings(event.data.tabID,options,valObject);
         break;//Blog end
         
      case 2: //Forum
         var options = {
            moduleName:'Forum',
            moduleCategories:true,
            moduleNestedCategories:true,
            moduleTags:true,
            moduleComments:true,
            moduleNestedComments:true,
            moduleItemRating:false,
            moduleStatistics:false
         };
         var valObject = new Array(3);
         valObject[0] = {
            moduleFieldName:'Title',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[1] = {
            moduleFieldName:'Author',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[2] = {
            moduleFieldName:'Content',
            moduleFieldInput:4,
            moduleFieldStore:2,
            moduleFieldVisual:2
         };
         mapModuleSettings(event.data.tabID,options,valObject);
         break; //Forum End
         
      case 3: //Shopping Cart
         var options = {
            moduleName:'Shopping Cart',
            moduleCategories:true,
            moduleNestedCategories:true,
            moduleTags:true,
            moduleComments:true,
            moduleNestedComments:true,
            moduleItemRating:true,
            moduleStatistics:true
         };
         var valObject = new Array(3);
         valObject[0] = {
            moduleFieldName:'Product Name',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[1] = {
            moduleFieldName:'Product Description',
            moduleFieldInput:4,
            moduleFieldStore:2,
            moduleFieldVisual:2
         };
         valObject[2] = {
            moduleFieldName:'Product Price',
            moduleFieldInput:0,
            moduleFieldStore:0,
            moduleFieldVisual:1
         };
         mapModuleSettings(event.data.tabID,options,valObject);
         break; //Shopping Cart End
         
      case 4: //Directory
         var options = {
            moduleName:'Directory',
            moduleCategories:true,
            moduleNestedCategories:true,
            moduleTags:true,
            moduleComments:true,
            moduleNestedComments:true,
            moduleItemRating:true,
            moduleStatistics:true
         };
         var valObject = new Array(5);
         valObject[0] = {
            moduleFieldName:'Title',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[1] = {
            moduleFieldName:'Author',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[2] = {
            moduleFieldName:'Content',
            moduleFieldInput:4,
            moduleFieldStore:2,
            moduleFieldVisual:2
         };
         valObject[3] = {
            moduleFieldName:'permaLink',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:0
         };
         valObject[4] = {
            moduleFieldName:'status',
            moduleFieldInput:1,
            moduleFieldStore:0,
            moduleFieldVisual:0
         };
         mapModuleSettings(event.data.tabID,options,valObject);
         break; //Directory End
         
      case 5: //Faqs
         var options = {
            moduleName:'Faqs',
            moduleCategories:false,
            moduleNestedCategories:false,
            moduleTags:false,
            moduleComments:false,
            moduleNestedComments:false,
            moduleItemRating:false,
            moduleStatistics:false
         };
         var valObject = new Array(2);
         valObject[0] = {
            moduleFieldName:'Question',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[1] = {
            moduleFieldName:'Answer',
            moduleFieldInput:0,
            moduleFieldStore:2,
            moduleFieldVisual:2
         };
         mapModuleSettings(event.data.tabID,options,valObject);
         break;  // Faqs End

      case 6: //Polls
         var options = {
            moduleName:'Poll',
            moduleCategories:false,
            moduleNestedCategories:false,
            moduleTags:false,
            moduleComments:false,
            moduleNestedComments:false,
            moduleItemRating:true, // item rating is used as Poll Answer
            moduleStatistics:false
         };
         var valObject = new Array(2);
         valObject[0] = {
            moduleFieldName:'Question',
            moduleFieldInput:0,
            moduleFieldStore:1,
            moduleFieldVisual:1
         };
         valObject[1] = {
            moduleFieldName:'Answer',
            moduleFieldInput:0,
            moduleFieldStore:2,
            moduleFieldVisual:2
         };
         mapModuleSettings(event.data.tabID,options,valObject);
         break;  // Polls End
   }
}

function mapModuleSettings(tabID,options,valObject)
{
   $('#' + tabID + ' #moduleName').attr('value',options.moduleName);
   $('#' + tabID + ' #moduleID').attr('value',options.moduleID);
   $('#' + tabID + ' #moduleCategories').attr('checked',options.moduleCategories);
   $('#' + tabID + ' #moduleCategories').change();

   $('#' + tabID + ' #moduleNestedCategories').attr('checked',options.moduleNestedCategories);
   $('#' + tabID + ' #moduleTags').attr('checked',options.moduleTags);
   $('#' + tabID + ' #moduleTags').attr('checked',options.moduleTags);

   $('#' + tabID + ' #moduleComments').attr('checked',options.moduleComments);
   $('#' + tabID + ' #moduleComments').change();

   $('#' + tabID + ' #moduleNestedComments').attr('checked',options.moduleNestedComments);
   $('#' + tabID + ' #moduleItemRating').attr('checked',options.moduleItemRating);
   $('#' + tabID + ' #moduleStatistics').attr('checked',options.moduleStatistics);

   $('#' + tabID + ' #moduleFieldsTable tbody tr').each(function(i){ 
      if(i != 0) $(this).remove();
   });

   for(loop=1; loop<valObject.length; loop++)
      $('#' + tabID + ' #addModuleField').click();

   var fieldNames = $('#' + tabID + ' input[name^=moduleFieldName]');
   var fieldInputs = $('#' + tabID + ' select[name^=moduleFieldInput]');
   var fieldStores = $('#' + tabID + ' select[name^=moduleFieldStore]');
   var fieldVisuals = $('#' + tabID + ' select[name^=moduleFieldVisual]');
   
   fieldNames.each(function(index){
      $(this).attr('value',valObject[index].moduleFieldName);
   });
   fieldInputs.each(function(index){
      $(this).attr('selectedIndex',valObject[index].moduleFieldInput);
   });
   fieldStores.each(function(index){
      $(this).attr('selectedIndex',valObject[index].moduleFieldStore);
   });
   fieldVisuals.each(function(index){
      $(this).attr('selectedIndex',valObject[index].moduleFieldVisual);
   });
}

function commitModule(e)
{
   if($('#' + e.data.tabID + ' #saveModuleForm').validate().form()) //Validate
   {
      var moduleFormData = $('#' + e.data.tabID + ' #saveModuleForm').serialize();

      var fieldsInListSelectHTML = '';
      $('#' + e.data.tabID + ' [name^=moduleFieldName]').each(
            function(index, obj)
            {
               var value = obj.value;
               fieldsInListSelectHTML += '<option value="' + value + '" >' + value + '</option>';
            });
            $('#fieldsInListSelect').html(fieldsInListSelectHTML);
      
      $("#commitModuleDialogue").dialog({
         width:700,
         height:300,
         modal: true,
         resize:false,
         drag:false,
         overlay: {
            opacity: 0.5,
            background: "#FFF4A6"
         },
         buttons: {
            "Continue": function(){
               var commitFormData = $('#commitModuleForm').serialize();
               continueModuleCommit(e.data.tabID, moduleFormData, commitFormData);
               $(this).dialog("close");
            },
            "Cancel": function() {
               $(this).dialog("close");
            }
         }
      });
      bindCheckedDependentView('#separateDetailPage','#detailPageOptionsDiv',true);
   }
}
function continueModuleCommit(tabID,moduleFormData,commitFormData)
{
   addToStatusBar($('#' + tabID + ' #saveModuleForm #moduleName').attr('value') + ' Module is being processed...');
   makeAJAXCall('./php/module.php?action=commit&tabID=' + tabID, moduleFormData + '&' + commitFormData, moduleCommitted);
}

function moduleCommitted(returned)
{
   var returned = evalJSON(returned);
   var pages =  returned.pages;
   var tables = returned.tables;
   var tabID = returned.tabID;
   
   appendPageNames(pages);
   appendDBTableNames(tables);
   
   for(var loop in pages)
   {
      $('#' + tabID + ' #commitPapesUl').append('<li>' + pages[loop].pageName + '</li>');   
   }
   for(var loop in tables)
   {
      $('#' + tabID + ' #commitTablesUl').append('<li>' + tables[loop].dbTableName + '</li>');
   }

   addToStatusBar('Module Committed.');
   $('#' + tabID + ' #commitResultsDiv').fadeIn(700);
}