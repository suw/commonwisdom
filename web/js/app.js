$(function() {

    var markedOptions = {
        gfm: true,
        tables: true,
        breaks: false,
        pedantic: false,
        sanitize: true
    };

    var renderMarkdown = function() {
        $("#markdown-contents").html(marked($("#editor").val(), markedOptions));
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