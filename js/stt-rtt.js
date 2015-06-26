jQuery(document).ready(function($) {
   $(window).scroll(function () {
    if ( $(this).scrollTop() > 500 )
    $(".rtt_button").fadeIn();
    else
    $(".rtt_button").fadeOut();
    });

    $(".rtt_button").click(function () {
    $("body,html").animate({ scrollTop: 0 }, 800 );
    return false;
    });
});