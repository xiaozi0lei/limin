// JavaScript Document

$(function() {
$("body").bind('swiperight', function() {
  event.stopPropagation();
	return false;
}).bind('swipeleft', function() {
   event.stopPropagation();
	 return false;
});
}); 