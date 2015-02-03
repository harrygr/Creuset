$(function()
{
    $('textarea[name=content]').pagedownBootstrap();
});

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});