<?php
    if (!defined('ABSPATH')) exit();

    get_header(); ?>

    <div class="container mx-auto my-6  px-4 sm:px-6 lg:px-8"><?php

            if (have_posts()) :
                while (have_posts()) : the_post();
                    ?>
                    <h1 class="text-primary font-termina font-bold mt-10 !pb-10"><?php the_title() ?></h1>
                    <?php
                    if (is_single()) {
                        ?><p class="text-light"><?php the_date() ?></p><?php
                    } ?>
                    <div class="font-light flex">
                        <div class="w-3/4">
                            <?php the_content(); ?>
                        </div>
                    </div>

                <?php
                endwhile;
            else :
                _e('Sorry, no posts matched your criteria.', 'textdomain');
            endif;
        ?>
    </div>
<?php
    get_footer();
