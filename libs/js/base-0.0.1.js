// when jquery is loaded
$(function(){
	// define variables
	var _window = $(window);
	var _body = $('body');
	// on load
	_window.load(function(){
		_body.addClass('loaded');
	});
});