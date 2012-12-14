function appendPageNames(returned)
{
   var pageNameHTML = '';
   pages = returned;
   for(var obj in pages)
   {
      pageNameHTML += '<li>' + pages[obj].pageName + '</li>';
   }
   $('#pageNameUl').append(pageNameHTML);
}


function showPageBox()
{
   var tabID = getNewTabID();
   var divElem = [{
      tagName:'div',
      id: tabID,
      innerHTML: pageBoxHTML
   }];

   $('#workingPanel').appendDom(divElem);
   $('#workingPanel > ul').tabs('add', '#' + tabID, 'New Page');
   //setTimeout(myFunc, 3000);
   
   //function myFunc()
   //{
      var simpleTreeCollection;
      simpleTreeCollection = $('.simpleTree').simpleTree({
         autoclose: false,
         afterClick:function(node){
            alert("text-"+$('span:first',node).text());
         },
         afterDblClick:function(node){
            alert("text-"+$('span:first',node).text());
         },
         afterMove:function(destination, source, pos){
            alert("destination-"+destination.attr('id')+" source-"+source.attr('id')+" pos-"+pos);
         },
         animate:false
         //,docToFolderConvert:true
      });
      
 //  }
}