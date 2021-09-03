<?php
    if (!defined('ABSPATH')) exit();

    get_header(); ?>

    <div class="container mx-auto my-6  px-4 sm:px-6 lg:px-8"><?php

    if (have_posts()) :
    while (have_posts()) : the_post();
    ?>
    <h1 class="text-primary font-termina font-bold mt-10"><?php the_title() ?></h1>
    <div class="font-light">
        <?php the_content(); ?>
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
