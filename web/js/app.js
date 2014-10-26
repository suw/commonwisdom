$(function() {

    var options = {
        gfm: true,
        tables: true,
        breaks: true,
        pedantic: false,
        sanitize: true
    };

    var renderMarkdown = function() {
        $('#markdownContents').html(marked($('#fileContents').val(), options));
    };

    renderMarkdown();

    $('#fileContents').keyup(function() {
        renderMarkdown();
    })
});