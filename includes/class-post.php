<?php

namespace HOC;

/**
 * Undocumented class
 */
class Post
{
    const POST_TYPES = [
        "BCC" => "bcc",
    ];

    const BCC = "bcc";
    const CATEGORIES = "category";
    const CATS = self::CATEGORIES;
    const TAGS = "tags";

    /**
     * @var \WP_Term[]|false|\WP_Error
     */
    public $tags;

    /**
     * @var \WP_Term[]|false|\WP_Error
     */
    public $category;

    /**
     * @var \WP_Term[]|false|\WP_Error
     */
    public $bcc;

    public $post;

    public function _construct(\WP_Post $post)
    {
        $this->post = $post;
    }

    public function has_categories()
    {
        return $this->has_terms(self::CATEGORIES);
    }

    /**
     * TODO rendere possibile $taxonomy come string[]
     *
     * @param string $taxonomy
     * @return boolean
     */
    public function has_terms(string $taxonomy)
    {
        if (is_null($this->$taxonomy)) {
            $this->get_terms($taxonomy);
        }

        if (is_array($this->$taxonomy)) {
            return (bool)$this->$taxonomy;
        } else {
            return false;
        }
    }

    public function get_categories(\Closure $callback = null, array $args = [])
    {
        return $this->get_terms(self::CATS, $callback, $args);
    }

    /**
     * Trova le tassonomie del post.
     *
     * @param string|string[] $taxonomy
     * @param \Closure $callback Da applicare su ciascun elemento trovato.
     * @param array $args
     * @return WP_Term[]|false|WP_Error
     */
    public function get_terms($taxonomy, \Closure $callback = null, array $args = [])
    {

        if (is_array($taxonomy)) {
            $array = [];
            foreach ($taxonomy as $t) {
                $array = array_merge($this->get_terms($t, $callback, $args));
            }

            return $array;
        }
        $post = $this->post;

        $args = shortcode_atts(array(
            'categorie_standard' => true,
            'solo_sottocategorie' => true, // Si possono inserire gli slug delle categorie da escludere separati da virgole senza spazi
        ), $args);

        $terms = $this->$taxonomy = get_the_terms($this->post, $taxonomy);

        if ($terms === false || is_wp_error($terms)) {
            return $terms;
        }

        if ($callback) {
            $terms = array_map($callback, $terms);
        }

        return $terms;
    }
}
