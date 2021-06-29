<?php


namespace HOC\Elementor\Skins;

abstract class BaseLoop extends Base
{

    protected $ignorePostsWithNoThumbnail = true;

    public function render()
    {
        $query = $this->query_posts();

        /**
         * L'oggeto viene creato solo una volta, per cui è lo stesso per tutta la pagina.
         * Se non si resetta questa proprietà, sarà pari a 0 solo per il primo widget renderizzato nella pagina.
         */
        $this->displayed = 0;

        if (!$query->found_posts) {
            /**
             * Nessun risultato.
             */
            return;
        }

        $settings = $this->get_settings_for_display();

        $this->render_loop_header();

        // $this->log_settings();

        // It's the global `wp_query` it self. and the loop was started from the theme.
        // Cosa significa questo?

        if ($query->in_the_loop) {
            echo "in the loop";
            $this->current_permalink = get_permalink();
            $this->render_post();
        } else {
            if (defined('WP_DEBUG') && WP_DEBUG)
                echo "<!-- limit : {$this->getSkinSetting('posts_per_page')}; Post ritrovati: {$query->found_posts} -->";

            while ($query->have_posts() && $this->displayed < $settings["{$this->get_id()}_posts_per_page"]) {

                $query->the_post();

                $this->render_post();

            }

            echo "<!-- Fine del loop. -->";
        }
        wp_reset_postdata();

        $this->render_loop_footer();
    }

    protected function render_loop_header()
    {
        #var_dump($breakpoints = \Elementor\Core\Responsive\Responsive::get_breakpoints());
        //  array(6) { ["xs"]=> int(0) ["sm"]=> int(480) ["md"]=> int(576) ["lg"]=> int(769) ["xl"]=> int(1440) ["xxl"]=> int(1600) }

        echo "<div class=\"turbo-skin-{$this->get_id()}-loop row\">";


    }


    protected function render_loop_footer()
    {
        echo "</div><!-- .turbo-skin-{$this->get_id()}-loop.row -->";

    }

    abstract protected function render_post();
}
