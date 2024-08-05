jQuery(document).ready(function($) {
    function initializeSlick() {
        if ($(window).width() < 768) {
            if (!$('.forecast-slider').hasClass('slick-initialized')) {
                $('.forecast-slider').slick({
                    dots: true,
                    infinite: false,
                    speed: 300,
                    slidesToShow: 3.2,
                    adaptiveHeight: true,
                    autoplay: true,
                    autoplaySpeed: 2000,
                });
            }
        } else {
            if ($('.forecast-slider').hasClass('slick-initialized')) {
                $('.forecast-slider').slick('unslick');
            }
        }
    }

    initializeSlick();

    // Reativar/desativar o Slick Slider ao redimensionar a janela
    $(window).on('resize', function() {
        initializeSlick();
    });
});
