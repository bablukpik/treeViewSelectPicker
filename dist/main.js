// select using tree view
var arr = '<?php echo !empty($treeView) ? $treeView : "[]"; ?>';
var obj = JSON.parse(arr);
console.log(obj);

var options = {
title : '<span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>',
data: obj,
maxHeight: 300,
checkHandler: function(element,checked){
let selectedOpt = [];
$.each(($("#firstDropDownTree").GetSelected()), function (key, val) {
selectedOpt.push($(val).attr("data-id"));
});
$(".selectpicker").val(selectedOpt).change();
},
closedArrow: '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
openedArrow: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>',
multiSelect: true,
selectChildren: true,
};

$("#firstDropDownTree").DropDownTree(options);
// end select using tree view
