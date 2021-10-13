import "./style.scss"
/* purgecss start ignore */
// import "swiper/css"
/* purgecss end ignore */
import Swiper, {Autoplay, Navigation, Pagination} from 'swiper'

function onDocReady() {
    const sw = new Swiper('.swiper.hoc-projects-swiper', {
        modules: [Autoplay, Navigation, Pagination],
        speed: 800,
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
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
    })

    const filterButtons = document.querySelectorAll('[data-filter]');

    const projects = document.querySelectorAll('[data-project]')

    const activeClasses = ['!bg-primary', '!text-white']

    filterButtons.forEach(i => {
        i.addEventListener('click', e => {
            if (e.target.dataset.active) {
                projects.forEach(i => i.classList.remove('hidden'))

                filterButtons.forEach(i => {
                    i.removeAttribute('data-active')
                    i.classList.remove(...activeClasses)

                })
                return;
            }


            let filter = e.target.dataset.filter
            filterButtons.forEach(i => {
                if (i.dataset.filter === filter) {
                    i.dataset.active = "true"
                    i.classList.add(...activeClasses)
                } else {
                    i.removeAttribute('data-active')
                    i.classList.remove(...activeClasses)

                }
            })

            projects.forEach(i => {
                if (i.dataset[filter]) {
                    i.classList.remove('hidden')
                } else i.classList.add('hidden')
            })

        })
    })
}

document.addEventListener('DOMContentLoaded', onDocReady, false);


