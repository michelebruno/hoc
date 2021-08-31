<?php

namespace HOC\Elementor;

use Elementor\{Controls_Manager,
     Group_Control_Image_Size,
    Group_Control_Text_Shadow,
    Group_Control_Typography,
    Repeater};

use Elementor\Core\Schemes\Typography ;

if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly.

}

/**
 * Class Controls
 * @package Turbo\Elementor
 * @property Widgets\Base|Skins\Base $parent
 */
class Controls
{
    const TAG_HTML_TITOLO = 'tag_html_titolo';

    public $parent;

    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Aggiunge un controllo della skin al genitore. Inserito solo per evitare errori.
     *
     * Register a single control to the allow the user to set/update skin data.
     *
     * @param string $id Control ID.
     * @param array $args Control arguments.
     *
     * @return bool True if skin added, False otherwise.
     */
    public function add_control($id, $args)
    {
        return $this->parent->add_control($id, $args);
    }

    protected function start_controls_section($a, $args)
    {
        $this->parent->start_controls_section($a, $args);
    }


    protected function _select($id, array $args)

    {
        $control_args = [
            'type' => Controls_Manager::SELECT, /*,
			'selectors' => [
					'{{WRAPPER}} .elementor-posts-container .elementor-post__thumbnail' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				'{{WRAPPER}}:after' => 'content: "{{SIZE}}"; position: absolute; color: transparent;',
				] ,
			'condition' => [
					$this->parent->get_control_id( 'thumbnail!' ) => 'none',
				$this->parent->get_control_id( 'masonry' ) => '',
			],  */

        ];
        $control_args = array_merge($control_args, $args);
        $this->parent->add_control(
            $id,
            $control_args
        );
    }

    public function sezione_tipografia($target = "text", $selector = "{{WRAPPER}} ")
    {

        $target_display = ucfirst($target);

        $this->parent->start_controls_section(
            "stile_$target",
            [
                'label' => __($target_display),
                'tab' => Controls_Manager::TAB_STYLE,
            ]

        );

        $this->parent->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => "{$target}_tipographys",
                'label' => __($target_display),
                'scheme' => Typography::TYPOGRAPHY_3,
                'selector' => $selector
            ]

        );

        $this->parent->add_control(
            $target . '_color',
            [
                'label' => __("$target_display color"),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector => 'color: {{VALUE}}' // ? è giusto?
                ]
            ]

        );


        $this->parent->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => "{$target}_text_shadow",
                'label' => __($target_display . ' Shadow'),
                'selector' => $selector,
            ]

        );
        $this->parent->end_controls_section();
    }

    public function posts_per_page()
    {

        $this->parent->add_control(
            'posts_per_page',
            [
                'label' => 'Post per pagina',
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 1
            ]

        );
    }

    public function colonne()
    {
        $this->parent->add_responsive_control(
            'colonne',
            [
                'label' => 'Colonne',
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 4,
                'default' => 1
            ]
        );
    }

    public function color(string $target, array $args = [])
    {
        $this->parent->add_control(
            $target,
            array_merge([
                'type' => Controls_Manager::COLOR,
                'label' => __(ucfirst($target))
            ], $args)
        );
    }

    public function dimensions(string $target, array $args = [])
    {

        $this->parent->add_responsive_control(
            $target,
            array_merge(
                [
                    'label' => __(ucfirst($target) . " position"),
                    'type' => Controls_Manager::DIMENSIONS
                ], $args
            )

        );
    }

    public function position(string $target)
    {

        $this->dimensions(
            $target,
            [
                'label' => __(ucfirst($target) . " position")
            ]
        );
    }

    public function switcher(string $target, array $args = [])
    {

        $this->parent->add_responsive_control(
            $target,
            array_merge(
                [
                    'type' => Controls_Manager::SWITCHER,
                    'label' => __(ucfirst($target))
                ],
                $args
            )

        );
    }

    public function image_size($target = "image")
    {

        $options = [];
        foreach (Group_Control_Image_Size::get_all_image_sizes() as $name => $size) {
            $options[$name] = ucfirst($name) . " (" . $size['width'] . "x" . $size['height'] . ")";
        }
        $this->_select(
            $target . "_size",
            [
                'options' => $options,
                'label' => __(ucfirst($target) . " sizes"),
                'default' => "medium"
            ]

        );
    }

    /**
     * image_ratio
     *
     * @param mixed $custom_args Tutte le impostazioni che si vogliono aggiungere ( selector, etc. )
     * @param float $default_ratio
     * @return void
     */
    public function image_ratio(array $custom_args = [], float $default_ratio = 1)
    {

        $control_args = [
            'label' => __('Image Ratio', 'elementor-pro'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => $default_ratio,
            ],
            'tablet_default' => [
                'size' => $default_ratio,
            ],
            'mobile_default' => [
                'size' => $default_ratio,
            ],
            'range' => [
                'px' => [
                    'min' => 0.1,
                    'max' => 2,
                    'step' => 0.01,
                ],
            ]/*,
			'selectors' => [
					'{{WRAPPER}} .elementor-posts-container .elementor-post__thumbnail' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				'{{WRAPPER}}:after' => 'content: "{{SIZE}}"; position: absolute; color: transparent;',
				] ,
			'condition' => [
					$this->parent->get_control_id( 'thumbnail!' ) => 'none',
				$this->parent->get_control_id( 'masonry' ) => '',
			],  */

        ];
        $this->parent->add_responsive_control(
            'item_ratio',
            array_merge($control_args, $custom_args)

        );
    }


    public function tag_html_titolo($id = self::TAG_HTML_TITOLO, array $custom_args = [], $defaultTitleTag = "h2")
    {

        $args = [
            'label' => 'Tag HTML titolo',
            'default' => $defaultTitleTag,
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
            ]
        ];

        $this->_select($id, array_merge($args, $custom_args));
    }

    /**
     * Sceglie se mostrare un custom field e con quale label.
     * @param string $field
     * @param array $args
     */
    public function showCustomField($field, array $args = [])
    {

        $readable_field_name = __(ucfirst(str_replace("_", " ", $field)));
        $default_label = array_key_exists('default_label', $args) ? $args["default_label"] : $readable_field_name . ": ";

        $this->parent->add_control(
            'show_' . $field,
            [
                'label' => 'Mostra ' . $readable_field_name,
                'label_on' => 'Sì',
                'label_off' => 'No',
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'separator' => 'before',
            ]
        );


        $this->parent->add_control(
            $field . '_label',
            [
                'label' => __('Label per ' . $readable_field_name),
                'type' => Controls_Manager::TEXT,
                'default' => $default_label,
                'condition' => [
                    "show_" . $field => "true"
                ]
            ]
        );
    }

    public function posizione_background(array $custom_args = null)
    {

        $control_args = [
            'label' => __('Background position', 'elementor-pro'),
            'default' => 'center center',
            'options' => [
                'left bottom' => "Sinistra Basso",
                'left center' => "Sinistra Centrale",
                'left top' => "Sinistra Sopra",
                'center bottom' => "Centrale Basso",
                'center center' => "Centrale Centrale",
                'center top' => "Centrale Sopra",
                'right bottom' => "Destra Basso",
                'right center' => "Destra Centrale",
                'right top' => "Destra Sopra",
            ] /*
			'condition' => [
					$this->parent->get_control_id( 'thumbnail!' ) => 'none',
				$this->parent->get_control_id( 'masonry' ) => '',
			],  */

        ];
        if ($custom_args) {
            $control_args = array_merge($control_args, $custom_args);
        }

        $this->_select('posizione_background', $control_args);
    }

    public function repeater() # Permette all'utente di aggiungere elementi
    {
        $repeater = new Repeater();

        $repeater->add_control(
            'list_title',
            [
                'label' => __('Title', 'plugin-domain'),
                'type' => Controls_Manager::TEXT,
                'default' => __('List Title', 'plugin-domain'),
                'label_block' => true,
            ]

        );

        $repeater->add_control(
            'list_content',
            [
                'label' => __('Content', 'plugin-domain'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('List Content', 'plugin-domain'),
                'show_label' => false,
            ]

        );

        $repeater->add_control(
            'list_color',
            [
                'label' => __('Color', 'plugin-domain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
                ],
            ]

        );

        $this->parent->add_control(
            'list',
            [
                'label' => __('Repeater List', 'plugin-domain'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => __('Title #1', 'plugin-domain'),
                        'list_content' => __('Item content. Click the edit button to change this text.', 'plugin-domain'),
                    ],
                    [
                        'list_title' => __('Title #2', 'plugin-domain'),
                        'list_content' => __('Item content. Click the edit button to change this text.', 'plugin-domain'),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]

        );
    }

    public function query()
    {

        # Post types

        $post_types = get_post_types(
            ['public' => true],
            'object'

        );
        foreach ($post_types as $k => $type) {
            $opt[$type->name] = $type->label;
        }

        unset($opt['attachment']);

        unset($opt['elementor_library']);

        /*
         * Categorie
         */

        $categories = get_terms('category');

        $cat_opt = [];

        foreach ($categories as $cat) {
            $cat_opt[$cat->term_id] = $cat->parent ? get_category($cat->parent)->name . ' > ' . $cat->name : $cat->name;
        }

        /*
         * Bologna come al cinema
         */

        $bologna = get_terms('bologna_cinema');

        $bcc_opt = [];


        /*
         * Tags
         */
        $tags = get_terms('post_tag');
        $tag_opt = array();
        foreach ($tags as $tag) {
            $tag_opt[$tag->term_id] = $tag->name;
        }
        $this->parent->start_controls_section(
            'query_section',
            [
                'label' => __('Query'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]

        );


        $this->parent->add_control(
            'post_types',
            [
                'label' => 'Sorgente',
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => $opt,
                'multiple' => true
            ]

        );

        /*

        * Tabs

        */
        $this->parent->start_controls_tabs(
            'include_exclude'

        );
        $this->parent->start_controls_tab(
            'include',
            [
                'label' => __('Include'),
            ]

        );


        /*
        $this->parent->add_control(
            'affini',
            [
                    'label' => 'Mostra in primis risultati affini alla pagina mostrata',
                'label_on' => 'Sì',
                'label_off' => 'No',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'separator' => 'before',
                ]

        );
 */


        $this->parent->add_control(
            'categories',
            [
                'label' => 'Categorie',
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => $cat_opt,
                'multiple' => true,
                'separator' => 'before',
                'condition' => [
                    /* 'affini!' => 'true' */],


            ]

        );
        $this->parent->add_control(
            'categories_and',
            [
                'label' => 'AND oppure OR?',
                'label_on' => 'AND',
                'label_off' => 'OR',
                'description' => "Se impostato su AND non verranno incluse le categorie figlie",
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'separator' => 'after',
                'condition' => [
                    /* 'affini!' => 'true' */],
            ]

        );
        $this->parent->add_control(
            'bologna_cinema',
            [
                'label' => 'Bologna come al cinema',
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => $bcc_opt,
                'multiple' => true,
                'separator' => 'before',
                'condition' => [
                    /* 'affini!' => 'true' */],
            ]

        );
        $this->parent->add_control(
            'bologna_and',
            [
                'label' => 'AND oppure OR?',
                'label_on' => 'AND',
                'label_off' => 'OR',
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'separator' => 'after',
                'condition' => [
                    /* 'affini!' => 'true' */],
            ]

        );


        $this->parent->add_control(
            'tags',
            [
                'label' => 'Tag',
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => $tag_opt,
                'multiple' => true,
                'separator' => 'before',
                'condition' => [
                    /* 'affini!' => 'true' */],
            ]

        );
        $this->parent->add_control(
            'tags_and',
            [
                'label' => 'AND oppure OR?',
                'label_on' => 'AND',
                'label_off' => 'OR',
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    /* 'affini!' => 'true' */],
            ]

        );
        $this->parent->end_controls_tab();
        $this->parent->start_controls_tab(
            'exclude',
            [
                'label' => __('Escludi'),
            ]

        );
        $this->parent->add_control(
            'categories_not',
            [
                'label' => 'Categorie',
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => $cat_opt,
                'multiple' => true,
                'separator' => 'before',
                'condition' => [
                    /* 'affini!' => 'true' */],
            ]

        );
        $this->parent->add_control(
            'tags_not',
            [
                'label' => 'Tag',
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => $tag_opt,
                'multiple' => true,
                'separator' => 'before',
                'condition' => [
                    /* 'affini!' => 'true' */],
            ]

        );
        $this->parent->end_controls_tab();
        $this->parent->end_controls_tabs();
        $this->parent->add_control(
            'order',
            [
                'label' => 'Ordina',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => 'ASC',
                    'DESC' => 'DESC',
                    "Rand" => "rand"
                ],
                'separator' => 'before',
                'condition' => [
                    /* 'affini!' => 'true' */],
            ]
        );
        $this->parent->add_control(
            'query_string',
            [
                'label' => 'WP_Query args',
                'description' => 'Verranno ignorate tutte le altre impostazioni di query. Leggi <a href="https://codex.wordpress.org/it:Riferimento_classi/WP_Query" target="_blank">qui</a> per più informazioni.',
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
                'placeholder' => 'cat=2,6,17,38',
                'condition' => [
                    /* 'affini!' => 'true' */]
            ]

        );


        $this->parent->end_controls_section();
    }
}
