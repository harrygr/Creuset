

$('.tagSelect').select2({
   tags: true,
   tokenSeparators: [",", " "]
})
.on('select2:select', function (e) {
   if (e.params.data.new)
   {
       console.log('Ajax to add tag "' + e.params.data.text + '" to DB');
   }

});


$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#admin-content").toggleClass("toggled");
    $("#wrapper").toggleClass("toggled");
});

