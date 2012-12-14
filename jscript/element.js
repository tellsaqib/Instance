function showElementBox()
{
   var tabID = getNewTabID();
   var divElem = [{
      tagName:'div',
      id: tabID,
      innerHTML: $('#addElementBox').html()
   }];
   $('#workingPanel').appendDom(divElem);
   $('#workingPanel > ul').tabs('add', '#' + tabID, 'New Element');

   addAttributeField('#attrDiv');
   addStyleField('#styleDiv');
   //$('#addElementBox').jqmShow();

   $('#addAtr').click(function(){
      addAttributeField('#attrDiv');
   });
   $('#addStyle').click(function(){
      addStyleField('#styleDiv');
   });
//$("#add").bind( "click", addElementToPage);
}
function addAttributeField(elemID)
{
   var attrBR = [{
      tagName : 'br',
      className: 'marginTop'
   }];
   var attrSelect = [{
      tagName: 'select',
      id:'attrName',
      childNodes : []
   }];

   for(var i in attributesList)
      attrSelect[0].childNodes.push({
         tagName:'option',
         value:attributesList[i],
         innerHTML: attributesList[i]
      });
   var attrText = [{
      tagName:'input',
      type:'text',
      name:'attrVal'
   }];

   $(elemID).appendDom(attrBR);
   $(elemID).appendDom(attrSelect);
   $(elemID).appendDom(attrText);

}

function addStyleField(elemID) {

   var styleBR = [{
      tagName : 'br',
      className: 'marginTop'
   }];
   var styleSelect = [{
      tagName: 'select',
      id:'styleName',
      childNodes : []
   }];
   for(var i in stylesList)
      styleSelect[0].childNodes.push({
         tagName:'option',
         value:stylesList[i],
         innerHTML: stylesList[i]
      });
   var styleText = [{
      tagName:'input',
      type:'text',
      name:'styleVal'
   }];

   $(elemID).appendDom(styleBR);
   $(elemID).appendDom(styleSelect);
   $(elemID).appendDom(styleText);
}
function createHTML()
{
   names = $("input[name:attrName]");
   values = $("input[name:attrVal]");

   names.each(function(){
      alert(this.value);
   });
   values.each(function(){
      alert(this.value);
   });

   html = '<div ';
   for(loop=0; loop < values.length ; loop++)
   {
      html  += names[loop].value + '="' + values[loop].value + '" ';
   }
   html += '></div>';

   alert(html);
   return html;
}