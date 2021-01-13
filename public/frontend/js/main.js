$(document).ready(function() {	
    $('.first').owlCarousel({
		    loop:true,
            margin: 30,
			nav:true,
            navText: ["<i class='fas fa-angle-left fa-4x'></i>","<i class='fas fa-angle-right fa-4x'></i>"],
			dots:false,
			autoplay:true,
            slideBy: 12,
        smartSpeed:1000,
            autoplaySpeed: 1000,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
    $('.category_slider').owlCarousel({
        loop:false,
        margin: 30,
        nav:true,
        navText: ["<i class='fas fa-angle-left fa-4x'></i>","<i class='fas fa-angle-right fa-4x'></i>"],
        dots:false,
        autoplay:true,
        slideBy: 12,
        smartSpeed:1000,
        autoplaySpeed: 2000,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:3
            }
        }
    });
    /*******owl*************/
new WOW().init();


});

function currentDiv(n) {
    showDivs(slideIndex = n);
}

function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    if (n > x.length) {slideIndex = 1}
    if (n < 1) {slideIndex = x.length}
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
    }
    x[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " w3-opacity-off";
}
/********* back to top ***********/
var btn = $('#button');

$(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
        btn.addClass('show');
    } else {
        btn.removeClass('show');
    }
});

btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, 1000);
    return false;
});
