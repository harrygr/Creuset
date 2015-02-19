/**
 * larail.js
 *
 * Perform a DELETE or PUT request outside a form with a simple link
 * and some data-type attributes. For use with Laravel PHP framework.
 *
 * Step 1: For CSRF-Support you have to put in your <head> section:
 * <meta name="csrf-token" content="{{ csrf_token() }}">
 *
 * Step 2: Simply build a link like this:
 * <a href="posts/2" data-method="delete" rel="nofollow">
 *
 * or with confirmation like this:
 *
 * <a href="posts/2" data-method="delete" data-confirm="Are you sure?" rel="nofollow">
 *
 * The script will append a generated form to your HTML body and then submit it.
 * This version is a slightly modified version of Jeffrey Way's script laravel.js
 * https://gist.github.com/JeffreyWay/5112282
 */
jQuery(function () {

    var larail = {

        // Define the name of the hidden input field for method submission
        methodInputName: '_method',
        // Define the name of the hidden input field for token submission
        tokenInputName: '_token',
        // Define the name of the meta tag from where we can get the csrf-token
        metaNameToken: 'csrf-token',

        initialize: function()
        {
            $('a[data-method]').on('click', this.handleMethod);
        },

        handleMethod: function(e)
        {
            var link = $(this),
                httpMethod = link.data('method').toUpperCase(),
                confirmMessage = link.data('confirm'),
                form;

            // Exit out if there is no data-methods of PUT or DELETE.
            if ($.inArray(httpMethod, ['PUT', 'DELETE']) === -1)
            {
                return;
            }

            // Allow user to optionally provide data-confirm="Are you sure?"
            if (confirmMessage)
            {
                if ( ! confirm(confirmMessage))
                {
                    link.blur();
                    return false;
                }
            }

            e.preventDefault();

            form = larail.createForm(link);
            form.submit();
        },

        createForm: function(link)
        {
            var form = $('<form>',
                {
                    'method': 'POST',
                    'action': link.prop('href')
                });

            var token =	$('<input>',
                {
                    'type': 'hidden',
                    'name': larail.tokenInputName,
                    'value': $('meta[name=' + larail.metaNameToken + ']').prop('content')
                });

            var method = $('<input>',
                {
                    'type': 'hidden',
                    'name': larail.methodInputName,
                    'value': link.data('method')
                });

            return form.append(token, method).appendTo('body');
        }
    };

    larail.initialize();

});