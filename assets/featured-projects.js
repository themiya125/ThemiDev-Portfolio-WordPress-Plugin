jQuery(document).ready(function ($) {
    $('.featured-projects').owlCarousel({
        items: 3,
        loop: true,
        margin: 20,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: true,
        dots: false,
        autoplayHoverPause:true,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            1024: { items: 3 }
        }
    });
});
