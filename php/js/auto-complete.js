$(function() {
 
$("#title").autocomplete({
source: "../search.php",
minLength: 2,
select: function(event, ui) {
var getUrl = ui.item.id;
if(getUrl != '#') {
location.href = getUrl;
}
},
 
html: true,
 
open: function(event, ui) {
$(".ui-autocomplete").css("z-index", 1000);
}
});
 
});
