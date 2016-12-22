$(document).ready(function () {
    $('audio.min').mediaelementplayer({
        audioWidth: 57,
        audioHeight: 57,
        startVolume: 1,
        enableAutosize: false,
        features: ['playpause']
    });
    $('.category-title').on('click', function () {
        $('.category-title').removeClass('active').next().slideUp();
        setTimeout(function () {
            if( !$(this).hasClass('active') ){
                $(this).addClass('active').next().slideDown();
            }
            else{
                $(this).removeClass('active').next().slideUp();
            }
        },50)
    })
});