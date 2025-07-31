<?php
namespace AffiliateX\Helpers\Elementor;

use AffiliateX\Elementor\Widgets\ElementorBase;
use Elementor\Controls_Manager;

defined('ABSPATH') or exit;

/**
 * Helper Class to handle child Widgets as repeater field in Elementor
 * 
 * @package AffiliateX
 */
class RepeaterHelper {
    /**
     * Configuration contains prefix, label, index, default values and conditions
     *
     * @var array
     */
    protected $config = [];

    /**
     * Elementor Widget base to hook controls
     *
     * @var ElementorBase
     */
    protected $controller;

    /**
     * Repeater sections
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Repeater widgets contrusctor
     *
     * @param ElementorBase $controller
     * @param array $sections
     * @param array $config
     */
    public function __construct(ElementorBase $controller, array $sections, array $config = [])
    {
        $this->config = wp_parse_args($config, $this->config);
        $this->controller = $controller;
        $this->sections = $sections;
    }

    /**
     * Generates child repeater fields
     *
     * @return void
     */
    public function generate_fields()
    {
        foreach($this->sections as $section_id => $section){
            $this->controller->add_control(
                $section_id,
                [
                    'label' => $section['label'],
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before'
                ]
            );

            foreach($section['fields'] as $field_id => $field){
                $this->controller->add_control(
                    $field_id,
                    $field
                );
            }
        }
    }
}