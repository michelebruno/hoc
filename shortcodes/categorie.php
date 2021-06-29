<?php

function turbo_categorie_shortcode($atts)
{

    global $post;

    $args = shortcode_atts(array(
        'post_id' => $post,
        'separator' => ',',
        'append' => '',
        'prepend' => '',
        'bcc' => false,
        'categorie_standard' => true,
        'solo_sottocategorie' => true,
        'escludi' => false, // Si possono inserire gli slug delle categorie da escludere separati da virgole senza spazi
    ), $atts, 'turbo-categorie');

    $escludi = array(
        ''
    );

    if ($args['escludi']) {
        foreach (explode(',', $args['escludi']) as $add) {
            $escludi[] = $add;
        }
    }

    $terms = get_the_category($post->ID);

    if ($args['bcc']) {
        $terms = array_merge(get_the_terms($post->ID, 'bologna_cinema'), $terms);
    }

    $term_list = [];

    foreach ($terms as $k => $term) {
        if (array_key_exists($term->slug, $escludi) || ($args['solo_sottocategorie'] && !$term->parent)) {
            unset($terms[$k]);
        } else $term_list[] = $term->name;
    }

    $output = count($term_list) ? $args['prepend'] . join(", ", $term_list) . $args["append"] : "";

    return $output;
}

add_shortcode('turbo-categorie', 'turbo_categorie_shortcode');
