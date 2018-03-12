$(document).ready(function(){
    /*console.log($(".ac_downloads section").length);
    if($(".ac_downloads section").length <= 1) {
        $("#autres > header").hide();
        $("#autres article").show();
    }*/
    $(".ac_downloads section header").click(function(){
        span = $(this).find('span');
        if(span.hasClass('collapse')) {
            span.removeClass('collapse').addClass('expand');
        } else {
            span.removeClass('expand').addClass('collapse');
        }
        $(this).parent().find('article').toggle();
    })
});