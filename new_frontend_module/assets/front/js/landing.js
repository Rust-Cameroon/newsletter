(function ($) {
    'use strict';

    //lucide icon
    lucide.createIcons();

    //mobile menu
    $("#mobile-menu").meanmenu({
        meanMenuContainer: ".mobile-menu",
        meanScreenWidth: "991",
        meanExpand: ['<i class="fa-regular fa-angle-right"></i>'],
    });

    // backtotop js
    var progressPath = document.querySelector(".backtotop-wrap path");

    if(progressPath != null){
        var pathLength = progressPath.getTotalLength();
        progressPath.style.transition = progressPath.style.WebkitTransition =
            "none";
        progressPath.style.strokeDasharray = pathLength + " " + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition =
            "stroke-dashoffset 10ms linear";

        var updateProgress = function () {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength) / height;
            progressPath.style.strokeDashoffset = progress;
        };
        updateProgress();
        $(window).scroll(updateProgress);
    }

    var offset = 150;
    var duration = 550;
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > offset) {
            $(".backtotop-wrap").addClass("active-progress");
        } else {
            $(".backtotop-wrap").removeClass("active-progress");
        }
    });

    $(".backtotop-wrap").on("click", function (event) {
        event.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, duration);
        return false;
    });

    // MagnificPopup image
    $(".popup-image").magnificPopup({
        type: "image",
        gallery: {
            enabled: true,
        },
    });

    // MagnificPopup video
    $(".popup-video").magnificPopup({
        type: "iframe",
    });

    // Testimonial active
    var testimonial = new Swiper(".testimonial-active", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        roundLengths: true,
        autoplay: {
            delay: 3000,
        },
        navigation: {
            nextEl: ".testimonial-button-prev",
            prevEl: ".testimonial-button-next",
        },
        breakpoints: {
            1200: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 2,
            },
            576: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            },
        },
    });

    var postboxSlider = new Swiper('.postbox__slider', {
		slidesPerView: 1,
        spaceBetween: 0,
		loop: true,
		autoplay: {
		  delay: 3000,
		},
		// Navigation arrows
		navigation: {
			nextEl: ".postbox-slider-button-next",
			prevEl: ".postbox-slider-button-prev",
		},
		breakpoints: {
			'1200': {
				slidesPerView: 1,
			},
			'992': {
				slidesPerView: 1,
			},
			'768': {
				slidesPerView: 1,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

})(jQuery);
