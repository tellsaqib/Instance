var downloadBoxHTML = '';

function showDownloadBox(e)
{
   
   var tabID = getNewTabID();
   var divElem = [{
      tagName:'div',
      id: tabID,
      innerHTML: downloadBoxHTML
   }];
   $('#workingPanel').appendDom(divElem);
   $('#workingPanel > ul').tabs('add', '#' + tabID, 'Download Code');

   //For Save
   $('#' + tabID + ' #downloadButton').bind('click',{
      tabID : tabID
   },download);

   // To show hide Nested Categories Checkbox on Categories Checkbox
   bindCheckedDependentView('#' + tabID + ' #selectedJavaScript','#' + tabID + ' #javaScriptFiles');
   bindCheckedDependentView('#' + tabID + ' #selectedCSS','#' + tabID + ' #cssFiles');
}

function download(e)
{
   var result = $('#' + e.data.tabID + ' #downloadForm').serialize();
   location.href = './php/downloadcode.php?' + result;  
}