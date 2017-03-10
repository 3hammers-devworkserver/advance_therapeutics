(function($) {
    function fullbannerheight() {
        var win = $(window).height();
        $('.full-banner, .banner-wrapper .slider-item').height(win);
    }
	function navBg(){
        var wH = $('.banner-wrapper, .inner-banner').height() - 100,
            top = $(window).scrollTop();

        if (top > wH) // height of float header
            $('.navbar-default').addClass('navbg');
        else
            $('.navbar-default').removeClass('navbg');
    }
    function bannerSlider(){
        $('.banner-wrapper .owl-carousel').owlCarousel({
            items:1,
            loop:false,
            margin:0,
            nav:true,
            autoplay: true,
            autoplayHoverPause: true,
            animateOut: 'slideOutUp',
            animateIn: 'slideInUp'
            
        });
    }
    function checkClick(){
        $(document).on('click','#check2',function(){
            if($(this).is(':checked')){
                $('.prescription-profile').find('input[type="text"]').show()
            }
            else{
                $('.prescription-profile').find('input[type="text"]').hide()

            }
        });
    }
    function scrollDown(){
        $('#down-scroll').on('click', function() {
               $('html, body').animate({
                scrollTop: $("#scroll-pos").offset().top - 80
            }, 1000);
        });
    }
    function adminSpace(){
        var adminH = $('#wpadminbar').height();
        if($('body').find('div#wpadminbar')){
            $('.navbar-fixed-top, .navmenu').css('top', adminH)
        }
    }

    function loginAddClass(){
        if ($('body').find(".inner-banner").length == 0) {
                //alert('inner banner not found');
                $('.navbar-fixed-top').addClass('navbg');
                $('.home .navbar-fixed-top').removeClass('navbg');

        

            }
    }
	$(document).ready(function() {
        fullbannerheight();
        bannerSlider();
        checkClick();
        scrollDown();
        adminSpace();
        loginAddClass();
        
          $('.flexslider').flexslider({
            animation: "slide",
            direction: "vertical",
            controlNav:true,
            touch:false
          });

        $(this).scrollTop(0);


       


        
    });

    $(window).resize(function() {
        fullbannerheight();
        loginAddClass();
    });
    $(window).scroll(function() {
      navBg();
    });
    $(window).load(function() {
      $(this).scrollTop(0);
    });

})(window.jQuery);