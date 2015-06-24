module.exports = (function() {
	console.log('plugin activated!');
	$('.navbar').click(function()
	{
		console.log('you clicked the navbar');
	});
	
})();