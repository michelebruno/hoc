import "./style.scss"
/* purgecss start ignore */
// import "swiper/css"
/* purgecss end ignore */
import Swiper, {Autoplay, Navigation, Pagination} from 'swiper'

function onDocReady() {
    const sw = new Swiper('.swiper.hoc-projects-swiper', {
        modules: [Autoplay, Navigation, Pagination],
        speed: 400,
        spaceBetween: 50,
        slidesPerView: 1,
        // loop: true,
        // freeMode: true,
        autoplay: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: true,
        breakpoints: {

            // when window width is >= 480px
            480: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            // when window width is >= 640px
            1024: {
                slidesPerView: 3,
                spaceBetween: 40
            },
        }
    })

    const news = new Swiper('.swiper.hoc-news-swiper', {
        modules: [Autoplay, Pagination],
        slidesPerView: 1,
        // loop: true,
        // freeMode: true,
        autoplay: true,
        navigation:  {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
    })

}

document.addEventListener('DOMContentLoaded', onDocReady, false);


