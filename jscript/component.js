function showComponentBox()
{
   var tabID = getNewTabID();
   var divElem = [{
      tagName:'div',
      id: tabID,
      innerHTML: $('#addComponentBox').html()
   }];
   $('#workingPanel').appendDom(divElem);
   $('#workingPanel > ul').tabs('add', '#' + tabID, 'New Component');
// $('#addComponentBox').jqmShow();
}
