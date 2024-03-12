$(document).ready(function () {
    var slide = $('#caja');
    var siguiente = $('#btn_siguiente');
    var atras = $('#btn_atras');
    var interval;

    $('#caja .section_caja:last').insertBefore('#caja .section_caja:first');
    slide.css('margin-left', '-' + 100 + '%');

    function moverD() {
        slide.animate({
            marginLeft: '-' + 200 + '%'
        }, 2000, function () {
            $('#caja .section_caja:first').insertAfter('#caja .section_caja:last');
            slide.css('margin-left', '-' + 100 + '%');
        });
    }

    function moverI() {
        slide.animate({
            marginLeft: 0
        }, 2000, function () {
            $('#caja .section_caja:last').insertBefore('#caja .section_caja:first');
            slide.css('margin-left', '-' + 100 + '%');
        });
    }

    function autoplay() {
        interval = setInterval(function () {
            moverD();
        }, 3000);
        siguiente.on('click', function () {
            moverD();
            clearInterval(interval);
        });
        atras.on('click', function () {
            moverI();
            clearInterval(interval);
        });
    }

    autoplay();
});