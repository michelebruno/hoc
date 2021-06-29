<?php

namespace HOC\Elementor\Skins;

use \Elementor\Skin_Base as Elementor_Skin_Base;

use Elementor\Widget_Base;
use HOC\Elementor\Controls;
use WP_Query;

if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly.

}

/**
 * @inheritDoc
 */
abstract class Base extends Elementor_Skin_Base
{

    public $query;

    public $controlli;

    /**
     * @var int
     */
    protected $displayed;

    protected $settings;


    public function __construct(Widget_Base $parent)
    {
        parent::__construct($parent);

        $this->controlli = new Controls($this);
    }

    public function is_parent_from_turbo()
    {
        return in_array("Turbo\Elementor\Widgets\Base", class_parents($this->parent));
    }

    /**
     * @return WP_Query|bool
     */
    public function query_posts()
    {
        if ($this->is_parent_from_turbo()) {
            return $this->query = $this->parent->query_posts();
        } elseif (in_array("ElementorPro\Modules\Posts\Widgets\Posts_Base", class_parents($this->parent))) {
            $this->parent->query_posts();
            return $this->query = $this->parent->get_query();
        } else die("Attenzione, il widget selezionato non ha una query.");
    }

    /**
     * Se non sono già state importate, prende le impostazioni per la visualizzazione.
     *
     * @param string $key
     * @return array
     */
    protected function get_settings_for_display(string $key = null)
    {
        return $this->parent->get_settings_for_display($key);
    }

    /**
     * Probabilmente basterebbe usare
     * @param $key
     * @return bool|string
     */
    protected function getSkinSetting($key)
    {
        return $this->parent->get_settings_for_display($this->get_control_id($key));
    }

    /**
     * Restituisce la classe col di bootstrap.
     *
     * N.B. è stata rimosso il breakpoint md da bootstrap per allinearlo a Elementor.
     *
     * @param int $value
     * @param string $target
     * @return string
     */
    private function _get_column_class($value, $target = null)
    {
        if ($target) {
            $target = "-" . $target;
        } else $target = "";

        switch ($value) {
            case '1':
                $col_class = "col{$target}-12 ";
                break;
            case '2':
                $col_class = "col{$target}-6 ";
                break;
            case '3':
                $col_class = "col{$target}-4 ";
                break;
            case '4':
                $col_class = "col{$target}-3 ";
                break;
            default:
                $col_class = false;
                break;
        }
        return $col_class;
    }

    /**
     * Prende le impostazioni dal controllo "colonne" in base al nome della skin.
     *
     * @return string
     */
    protected function get_classi_colonne()
    {
        $settings = $this->get_settings_for_display();

        $prefix = $this->get_id() . "_";

        if (array_key_exists('colonne', $settings)) {
            $colonne = $settings['colonne'];
        } elseif (array_key_exists($this->get_control_id('colonne'), $settings)) {
            $colonne = $settings[$this->get_control_id('colonne')];
        } else

            $colonne = null;

        if (array_key_exists('colonne_tablet', $settings)) {
            $colonne_tablet = $settings['colonne_tablet'];
        } elseif (array_key_exists($this->get_control_id('colonne_tablet'), $settings)) {
        } else $colonne_tablet = null;
        if (array_key_exists('colonne_mobile', $settings)) {
            $colonne_mobile = $settings['colonne_mobile'];
        } elseif (array_key_exists($this->get_control_id('colonne_mobile'), $settings)) {
        } else $colonne_mobile = null;
        $colonne_mobile = $settings[$this->get_control_id('colonne_mobile')];
        $colonne_tablet = $settings[$this->get_control_id('colonne_tablet')];
        /**
         * Riordina le colonne in mobile first per essere compatibile con Bootstrap Grid.
         */
        if ($colonne_mobile) {
            $col_class = $this->_get_column_class($colonne_mobile);
            if ($colonne_tablet) {
                $col_class .= $this->_get_column_class($colonne_tablet, 'md');
            }
            $col_class .= $this->_get_column_class($colonne, 'lg');
        } elseif ($colonne_tablet) {
            $col_class = $this->_get_column_class($colonne_tablet);
            $col_class .= $this->_get_column_class($colonne, 'lg');
        } else {
            $col_class = $this->_get_column_class($colonne);
        }

        return $col_class;
    }

    /**
     * For debugging purpose only.
     */
    public function log_settings()
    {
        echo '<script>console.log(JSON.parse(\'' . json_encode($this->parent->get_settings_for_display()) . '\'))</script>';
    }

}
