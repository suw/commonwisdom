$(function() {

    var options = {
        gfm: true,
        tables: true,
        breaks: false,
        pedantic: false,
        sanitize: true
    };

    var renderMarkdown = function() {
        $('#markdownContents').html(marked($('#fileContents').val(), options));
    };


    $('#fileContents').keyup(function() {
        renderMarkdown();
    });

    // Init
    renderMarkdown();
});