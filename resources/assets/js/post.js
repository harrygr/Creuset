
$(function()
{
    // Markdown editing for the content area
   // $('textarea[name=content]').pagedownBootstrap();

    // activate the datepicker
    // $('.datetimepicker').datetimepicker({
    //     format: 'YYYY-MM-DD HH:mm:ss',
    //     icons: {
    //         time: 'fa fa-clock-o',
    //         date: 'fa fa-calendar',
    //         up: 'fa fa-chevron-up',
    //         down: 'fa fa-chevron-down',
    //         previous: 'fa fa-chevron-left',
    //         next: 'fa fa-chevron-right',
    //         today: 'fa fa-screenshot',
    //         clear: 'fa fa-trash'
    //     }
    // });

    // Generate slugs from the post title
    var $refreshSlugButton = $('.refresh-slug button');
    var $postTitleInput = $('.post-form input[name=title]');
    var $slugInput = $('.post-form input[name=slug]');

    // Disable the refresh button when the title is empty
    if ( ! $slugInput.val() )
    {
        $refreshSlugButton.addClass('disabled');
    }

    // Do it when the title is changed
    $postTitleInput.change(function()
    {
        // Only resluggify if the no slug already existed
        if ( ! $slugInput.val() )
        {
            $slugInput.val(sluggify($(this).val()));
        } else {
            $refreshSlugButton.removeClass('disabled');
        }
    });

    // Do it when manually triggered
    $refreshSlugButton.click(function()
    {
        $slugInput.val(sluggify($postTitleInput.val()));
    });
});


function sluggify(text)
{
    return text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-');
}