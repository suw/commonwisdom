$(function() {

    var markedOptions = {
        gfm: true,
        tables: true,
        breaks: false,
        pedantic: false,
        sanitize: true
    };

    var renderMarkdown = function() {
        $("#markdownContents").html(marked($("#editor").val(), markedOptions));
    };

    $("#editor").keyup(function() {
        renderMarkdown();
    });


    /**
     * Init the app
     */

    renderMarkdown();
    $("#editor").autosize();
    $("#save-success").fadeOut(1500);

});