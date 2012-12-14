var attributesList = ['width','height','align','valign'];
var stylesList = ['margin','line-height','float','padding'];
var globalVarSourcesList = ['language','database','configfile'];
var globalVarTypesList = ['type1','type2','type3'];
var tableFieldTypesList = ['Number','Short Text','Long Text'];
var componentTypesList = ['SideNavigtionMenu','Header','Footer'];
var tabNum = 1;
var contentLodingHTML = '<div>Content Loading ... </div>';

function makeAJAXCall(url,data,successFunc,errorFunc)
{
   jQuery.ajax({
      url: url,
      data:data,
      success: successFunc,
      error:errorFunc
   });
   /*
   error:function(a,b,c,d)
      {
         alert(a);
         alert(b);
         alert(c);
         alert(d);
       }
       */
}
function getJSONData(url,data,succesFunc)
{
   jQuery.getJSON(url, data, succesFunc)
}
//Called whenever a new tab is created
function getNewTabID()
{
   tabNum++;
   return ("tabNum" + tabNum);
}

function bindCheckedDependentView(master, slave)
{
   $(master).bind('change', function()
   {
      if(!this.checked)
      {
         $(slave).addClass('hide');
      }
         
      else
         $(slave).removeClass('hide');
   } );
}
function bindUnCheckedDependentView(master, slave)
{
   $(master).bind('change', function()
   {
      if(this.checked)
      {
         $(slave).addClass('hide');
      }

      else
         $(slave).removeClass('hide');
   } );
}
function addToStatusBar(content)
{
   var ulHTML = '';
   
   $('#statusMenuUl').html('<li>'+ $('#statusMenuButton').html() + '</li>' + $('#statusMenuUl').html());

   //Assign new content to button.
   $('#statusMenuButton').html(content);
   
}
//Finds all input fields in a DOM element using  recursive search and reset them
function resetFields(elem)
{
      $(elem).find(":input").each(function(){
            $(this).attr('checked',false);
            $(this).attr('value','');
            $(this).attr('selected',0);

         });
}
function evalJSON(src)
{
   return eval("(" + src + ")");
}
function isNumeric(text)
{
   var validChars = "0123456789.";
   var isNumber=true;
   var character;

   for (i = 0; i < text.length && isNumber == true; i++)
      {
      character = text.charAt(i);
      if (validChars.indexOf(character) == -1)
         {
            isNumber = false;
         }
      }
   return isNumber;
}