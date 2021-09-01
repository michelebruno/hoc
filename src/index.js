import "./style.css"
/* purgecss start ignore */
// import "swiper/css"
/* purgecss end ignore */
import Swiper, {Autoplay, Pagination} from 'swiper'

function onDocReady() {
    const sw = new Swiper('.swiper.hoc-projects-swiper', {
        modules: [Autoplay, Pagination],
        speed: 400,
        spaceBetween: 50,
        slidesPerView: 1,
        // loop: true,
        // freeMode: true,
        autoplay: true,
        pagination: {
            el: ".swiper-pagination",
        },
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

}

document.addEventListener('DOMContentLoaded', onDocReady, false);
