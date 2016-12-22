var user = {
    authorization: function () {
        if( localStorage['user_hash'] == undefined ){
            $.ajax({
                url: '/user/get/hash',
                type: 'post',
                dataType: 'json',
                success: function (xhr) {
                    if( xhr.result ){
                        localStorage['user_hash'] = xhr.hash;
                    }
                }
            });
        }
    }    
};

$(document).ready(function () {
    //авторизуем пользователя на уровне браузера
    user.authorization();

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
            $this.on('click',function () {
                right_menu($this);
            });
        },100)
    };
    $('.category-title').on('click', function () {
        right_menu($(this));
    })
});