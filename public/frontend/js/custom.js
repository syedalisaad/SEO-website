jQuery(".sp-slider").slick({
    dots: false,
    arrows: true,
    autoplay: false,
    infinite: 0,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 2
            }
        },
        {
            breakpoint: 601,
            settings: {
                slidesToShow: 1
            }
        }
    ]
});


jQuery(".pre-slider").slick({
    dots: true,
    arrows: true,
    draggable: true,
    autoplay: false, /* this is the new line */
    speed: 900,
    slidesToShow: 1,
    slidesToScroll: 1,
});

jQuery('.video_play_frame').on('click', function () {
    var video_box = jQuery(this);
    video_image_button(video_box);

});

function video_image_button(video_box) {
    if (video_box.find('.play_button_img').length) {
        if (video_box.find('iframe').length) {
            video_box.find('iframe')[0].src += '?autoplay=1&loop=100&mute=1&enablejsapi=1'
        }

        if (video_box.find('video').length) {
            video_box.find('video').get(0).play();
        }
        video_box.find('.pre-slide').removeClass('play_button_img')
    } else {
        video_box.find('.pre-slide').addClass('play_button_img')
        if (video_box.find('iframe').length) {
            let url_youtube = video_box.find('iframe')[0].src;
            video_box.find('iframe')[0].src = url_youtube.replaceAll('?autoplay=1&loop=100&mute=1&enablejsapi=1', '')
        }
    }
}

jQuery('video').bind('pause', function () {
    var video_box = jQuery(this).closest('.pre-slide');
    video_box.addClass('play_button_img')
});
jQuery('video').bind('play', function () {
    var video_box = jQuery(this).closest('.pre-slide');
    video_box.removeClass('play_button_img')
});


jQuery(".pre-slider").on("beforeChange", function (event, slick, prevSlide) {
    var prevSlideEl = jQuery(slick.$slides[prevSlide]);

    if (prevSlideEl.find('iframe').length) {
        let url_youtube = prevSlideEl.find('iframe')[0].src;
        prevSlideEl.find('iframe')[0].src = url_youtube.replaceAll('?autoplay=1&loop=100&mute=1&enablejsapi=1', '')
        // prevSlideEl.find('.pre-slide').addClass('play_button_img')
    }
    if (prevSlideEl.find('video').length) {
        prevSlideEl.find('video').get(0).pause();
        prevSlideEl.find('.pre-slide').addClass('play_button_img')
    }

});

jQuery('.announcement i').click(function () {
    jQuery('.announcement').addClass('none');
    localStorage.setItem("announcement_close", "close");
});

jQuery('.onlymobile .toggle i').click(function () {
    jQuery('header nav').toggleClass('menu-open-mobile');
});
if (localStorage.getItem("announcement_close") && localStorage.getItem("announcement_close")!=null ) {
    jQuery('.announcement').addClass('none');
}

jQuery('header nav .toggle-close i').click(function () {
    jQuery('header nav').removeClass('menu-open-mobile');
});


jQuery(function () {

    jQuery(".accordion-content:not(:first-of-type)").css("display", "none");

    jQuery(".js-accordion-title:first-of-type").addClass("open");

    jQuery(".js-accordion-title").click(function () {
        jQuery(".open").not(this).removeClass("open").next().slideUp(300);
        jQuery(this).toggleClass("open").next().slideToggle(300);
    });
});

jQuery(".listings ul li:not(:first-of-type) .boxes").css("display", "none");
jQuery(".listings ul li:first-of-type .boxes").css("display", "flex");
jQuery(".listings ul li:first-of-type h4").addClass('open');
jQuery(".listings ul li h4").click(function () {
    jQuery(this).toggleClass("open").next().slideToggle(300);
});
if (jQuery('.listinginnerbanner').length) {

    var stickySidebar = jQuery('.listinginnerbanner').offset().top;

    jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() > stickySidebar) {
            jQuery('.listinginnerbanner').addClass('innerfix');
        } else {
            jQuery('.listinginnerbanner').removeClass('innerfix');
        }
    });

}
$(document).on("click", ".share a", function (e) {
    $('#share-modal').modal('show');
})

$(document).on("click", ".filterbtn", function (e) {
    $('.mobile-visible').addClass('filter-open');
})

$(document).on("click", ".mobile-visible.filter-open .fa-times", function (e) {
    $('.mobile-visible').removeClass('filter-open');
})

$(document).on("click", ".shareModalLinks", function (e) {

    let channel = $(this).attr('data-channel');
    let title = $('meta[property=title]').attr('content');
    let desc = $('meta[property=description]').attr('content');
    let page_url = $('meta[property=url]').attr('content') || window.location.href;
    let image_url = $('meta[property=image]').attr('content');

    if (channel === 'facebook') {
        //window.open('https://www.facebook.com/sharer/sharer.php?u=' + page_url);
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + page_url + '&title=' + title + '&picture=' + image_url);
    } else if (channel === 'twitter') {
        window.open("https://twitter.com/intent/tweet/?text=" + encodeURIComponent(title)+  "&url=" + encodeURIComponent(page_url));
    } else if (channel === 'linkedin') {

        window.open("https://www.linkedin.com/shareArticle?mini=true&url=" + (page_url) );
    } else if (channel === 'copy') {
        navigator.clipboard.writeText(window.location.href).then(function () {
            console.log('URL Copied');
        }, function (err) {
            alert('Could not copy text: ', err);
        });
    }
});


