<?php
    if (!defined('ABSPATH')) exit();

    get_header(); ?>

    <div class="container mx-auto my-4"><?php

    if (have_posts()) :
    while (have_posts()) : the_post();
    ?>
    <h1 class="text-primary font-bold"><?php the_title() ?></h1>
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
