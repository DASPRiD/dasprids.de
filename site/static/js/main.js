$(function(){
    $('a[data-encoded-url]').each(function(){
        $(this).attr('href', window.atob($(this).data('encoded-url')));
    });
});
