$("href=top").click(function() {
    $('html, body').animate({
        animate.scrollTop: $("#top-section").offset().top
    }, 2000);
});
$("#work").click(function() {
    $('html, body').animate({
        animate.scrollTop: $("#work-section").offset().top
    }, 2000);
});
$("#bottom").click(function() {
    $('html, body').animate({
        animate.scrollTop: $("#bottom-section").offset().top
    }, 2000);
});