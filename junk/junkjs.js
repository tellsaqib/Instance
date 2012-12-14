var attrDiv = [{
            tagName:'div',
            id:'attrDiv',
            innerHTML:'<strong>Attributes</strong><a href="javascript:" id="addAttr" >Add Another</a>'
        } ];
        //  var addAttributeAnchor = [{tagName:'a', href:'javascript:', id:'addAttr', align:'left', innerHTML:'Add another'}];
        // attrDiv[0].childNodes.push([addAttributeAnchor]);
        $('#jqmFormDiv').appendDom(attrDiv);

        var styleDiv = [{
            tagName:'div',
            id:'styleDiv',
            innerHTML:'<strong>Styles</strong><a href="javascript:" id="addStyle" >Add Another</a>'
        } ];
        // var addStyleAnchor = [{tagName:'a',id:'addstyle',href:'javascript:', align:'left', innerHTML:'Add another'}];
        // styleDiv[0].childNodes = addStyleAnchor;
        $('#jqmFormDiv').appendDom(styleDiv);

        $('#jqmFormDiv').appendDom([{
            tagName:'label',
            id:'add',
            className:'button',
            innerHTML :'Add'
        }]);

  // showaddpagebox

var nameLabel= [{
        tagName:'label',
        innerHTML:'Page Name',
        childNodes: []
    }];
    var nameText = [{
        tagName:'input',
        type:'text',
        name:'name'
    }];
    nameLabel[0].childNodes = nameText;
    $('#jqmFormDiv').appendDom(nameLabel);

    var templateHeading = [{
        tagName:'h4',
        innerHTML:'Page Templates'
    }];
    $('#jqmFormDiv').appendDom(templateHeading);

    //showNewModuleBox





