<?php


    namespace HOC\Elementor\Widgets;

    class News extends Base
    {
        public function get_name()
        {
            return 'hoc-news';
        }

        public function get_title()
        {
            return 'News';
        }

        public function get_icon()
        {
            return 'fa fa-math';
        }

        public function get_categories()
        {
            return ['general'];
        }


        protected function _register_controls()
        {
            $this->start_controls_section('controlli');


            $this->end_controls_section();

        }

        public function get_script_depends()
        {
            return ['hoc'];
        }

        public function get_style_depends()
        {
            return ['hoc'];
        }


        protected function render()
        {

            query_posts([
                'post_type' => 'post'
            ]);

            if (have_posts()) {
                the_post();
                ?>
                <div class="swiper hoc-news-swiper px-8 md:px-16">
                <div class="swiper-wrapper"><?php
                        while (have_posts()) {
                            the_post();
                            ?>
                            <div class="swiper-slide ">

                                <div class="
                                grid md:grid-cols-2 gap-6
                                m-4
                                rounded-lg overflow-hidden
                                shadow-lg">
                                    <div>
                                        <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', false, [
                                            "class" => "h-full w-full object-cover"
                                        ]); ?>
                                    </div>
                                    <div class="pb-4 lg:py-6 px-4 lg:pr-4">
                                        <h3 class="text-xl text-primary font-termina font-bold mb-4"><?php the_title() ?></h3>
                                         <p class="my-0">
                                            <a href="<?php the_permalink(); ?>" class="
                                            rounded-xl inline-block text-sm  text-center
                                            py-2 px-4 border-primary border-2 text-primary
                                        ">Leggi</a>
                                        </p>

                                    </div>
                                </div>

                            </div>
                            <?php
                        }

                    ?>
                </div>

                <div class="swiper-pagination"></div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                </div><?php
            }

            wp_reset_postdata();
            wp_reset_query();
        }

    }
