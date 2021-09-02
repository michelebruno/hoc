<?php
    if (!defined('ABSPATH')) exit();

    get_header();

    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <h1 class="text-primary text-2xl"><?php the_title() ?></h1>
            <div class="font-light">
                <?php the_content(); ?>
            </div>

        <?php
        endwhile;
    else :
        _e('Sorry, no posts matched your criteria.', 'textdomain');
    endif;

    get_footer();
