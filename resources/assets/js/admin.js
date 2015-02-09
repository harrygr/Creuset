var $refreshSlugButton = $('.refresh-slug button');
var $postTitleInput = $('.post-form input[name=title]');
var $slugInput = $('.post-form input[name=slug]');

$(function()
{
    $('textarea[name=content]').pagedownBootstrap();
    if ( ! $slugInput.val() )
    {
        $refreshSlugButton.addClass('disabled');
    }
});

$postTitleInput.change(function()
{
    if ( ! $slugInput.val() )
    {
        $slugInput.val(sluggify($(this).val()));
    } else {
        $refreshSlugButton.removeClass('disabled');
    }
});

$refreshSlugButton.click(function()
{
    $slugInput.val(sluggify($postTitleInput.val()));
});

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

function sluggify(text)
{
    return text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-');
}