$(document).ready(function(){
    /*console.log($(".ac_downloads section").length);
    if($(".ac_downloads section").length <= 1) {
        $("#autres > header").hide();
        $("#autres article").show();
    }*/
    $(".ac_downloads section").click(function(){
        span = $(this).find('header > span');
        if($(this).find('header > span').hasClass('collapse')) {
            span.removeClass('collapse').addClass('expand');
        } else {
            span.removeClass('expand').addClass('collapse');
        }
        $(this).find('article').toggle();
    })
});