<?php
namespace AffiliateX\Elementor;

use AffiliateX\Elementor\Controls\TextControl;
use AffiliateX\Elementor\Controls\TextAreaControl;

/**
 * Controls Manager Class.
 * 
 * This class is responsible for registering the custom controls for Elementor.
 * 
 * @package AffiliateX\Elementor
 * @since 1.0.0
 * @version 1.0.0
 */
class ControlsManager {
    /**
     * Text Control slug.
     * 
     * @var string
     */
    const TEXT = 'affiliatex_text';

    /**
     * Text Area Control slug.
     * 
     * @var string
     */
    const TEXTAREA = 'affiliatex_textarea';

    /**
     * Controls.
     * 
     * @var array
     */
    private $controls = [
        TextControl::class,
        TextAreaControl::class,
    ];

    /**
     * Constructor.
     * 
     * @since 1.0.0
     * @version 1.0.0
     */
    public function __construct() {
        add_action('elementor/controls/controls_registered', [$this, 'register_controls']);
    }

    /**
     * Register Custom Controls.
     * 
     * @param $controls_manager
     * @since 1.0.0
     * @version 1.0.0
     */
    public function register_controls($controls_manager){
        foreach( $this->controls as $control_class) {
            $control = new $control_class();
            $controls_manager->register_control($control->get_type(), $control);
        }
    }
}