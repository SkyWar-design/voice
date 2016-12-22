$(document).ready(function () {
    $('audio.min').mediaelementplayer({
        audioWidth: 57,
        audioHeight: 57,
        startVolume: 1,
        enableAutosize: false,
        features: ['playpause']
    });
    var right_menu = function ($this) {
        $this.unbind('click');
        if( !$this.hasClass('active') ){
            $this.addClass('active').next().slideDown(100);
        }
        else{
            $this.removeClass('active').next().slideUp(100);
        }
        setTimeout(function () {
            $this.on('click',right_menu($this));
        },100)
    };
    $('.category-title').on('click', function () {
        right_menu($(this));
    })
});