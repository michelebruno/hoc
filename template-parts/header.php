<?php
    /**
     * The template for displaying header.
     *
     * @package HelloElementor
     */

    if (!defined('ABSPATH')) {
        exit; // Exit if accessed directly.
    }
    $site_name = get_bloginfo('name');
    $tagline = get_bloginfo('description', 'display');
    //    	'menu'                 => '',
    //		'container'            => 'div',
    //		'container_class'      => '',
    //		'container_id'         => '',
    //		'container_aria_label' => '',
    //		'menu_class'           => 'menu',
    //		'menu_id'              => '',
    //		'echo'                 => true,
    //		'fallback_cb'          => 'wp_page_menu',
    //		'before'               => '',
    //		'after'                => '',
    //		'link_before'          => '',
    //		'link_after'           => '',
    //		'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    //		'item_spacing'         => 'preserve',
    //		'depth'                => 0,
    //		'walker'               => '',
    //		'theme_location'       => '',
    //       Current: "bg-dark text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white"

    $menu_items = wp_get_nav_menu_items(wp_get_nav_menu_name('primary'));

?>


<nav class="shadow-lg sticky top-0 bg-white z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md !text-primary-dark focus:outline-none focus:ring-2 "
                        aria-controls="mobile-menu" aria-expanded="false" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <span class="sr-only">Open main menu</span>
                    <!--
                      Icon when menu is closed.

                      Heroicon name: outline/menu

                      Menu open: "hidden", Menu closed: "block"
                    -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <!--
                      Icon when menu is open.

                      Heroicon name: outline/x

                      Menu open: "block", Menu closed: "hidden"
                    -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0 flex items-center">
                    <a class="block" href="<?php echo get_home_url(); ?>">
                    <?php
                        $site_icon = get_option("site_icon");
                        $site_logo = get_option("site_logo");
                        if ($site_icon ) {
                           echo wp_get_attachment_image($site_icon, 'thumbnail', false, ['class' => "h-12 w-12 hidden md:block"]);
                           echo wp_get_attachment_image($site_logo, 'medium', false, ['class' => "h-12 w-24 block md:hidden object-contain"]);
                        } elseif ($site_name) {
?><span class="text-lg text-dark font-bold font-termina align-middle inline-block leading-0"><?php echo $site_name ; ?></span><?php

                        }
                    ?></a>
                </div>
            </div>
            <div class="flex space-x-2 items-center hidden sm:block">
                <?php

                    foreach ($menu_items as $menu_item) {

                        ?>
                        <a href="<?php echo $menu_item->url; ?>"
                           class=" hover:text-primary-dark active:text-primary px-3 py-2 rounded-md text-sm font-medium  <?php echo /** @global WP_Query $wp_query */ $wp_query->queried_object->ID == $menu_item->object_id ? 'underline' : '!no-underline' ?>"><?php echo $menu_item->title; ?></a>
                        <?php

                    }

                ?>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="hidden sm:hidden transition" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Current: "bg-dark text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

            <?php

                foreach ($menu_items as $menu_item) {

                    ?>
                    <a href="<?php echo $menu_item->url; ?>"
                       class="block px-3 py-2 rounded-md text-base font-medium <?php echo /** @global WP_Query $wp_query */ $wp_query->queried_object->ID == $menu_item->object_id ? 'underline' : '!no-underline' ?>"><?php echo $menu_item->title; ?></a>
                    <?php

                }

            ?>
        </div>
    </div>
</nav>
