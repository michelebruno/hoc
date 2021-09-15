<?php
    if (!defined('ABSPATH')) exit();

    get_header(); ?>

    <article class="container mx-auto my-6  px-4 sm:px-6 lg:px-8"><?php

            if (have_posts()) :
                while (have_posts()) : the_post();
                    ?>
                    <h1 class="text-primary font-termina font-bold mt-10 !pb-10 lg:mt-16"><?php the_title() ?></h1>
                    <?php
                    if (is_single()) {
                        ?><p class="text-light"><?php the_date() ?></p><?php
                    } ?>
                    <div class="font-light flex">
                        <div class="md:w-9/12 2xl:w-7/12">
                            <?php the_content(); ?>
                        </div>
                    </div>

                <?php
                endwhile;
            else :
                _e('Sorry, no posts matched your criteria.', 'textdomain');
            endif;
        ?>
    </article>
<?php
    get_footer();
