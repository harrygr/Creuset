

//$('.tagSelect').select2({
//    tags: true,
//    tokenSeparators: [",", " "],
//    createTag: function(tag) {
//        return {id: tag.term, text: tag.term, new: true};
//    }
//}).on('select2:select', function (e) {
//    if (e.params.data.new)
//    {
//        console.log('Ajax to add tag "' + e.params.data.text + '" to DB');
//    }
//
//});


$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

