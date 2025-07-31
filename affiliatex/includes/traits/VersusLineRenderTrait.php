<?php
namespace AffiliateX\Traits;

use AffiliateX\Helpers\AffiliateX_Helpers;
use AffiliateX\Helpers\Elementor\WidgetHelper;

defined('ABSPATH') or exit;

trait VersusLineRenderTrait
{
    protected function get_slug(): string
    {
        return 'versus-line';
    }

    protected function get_fields(): array
    {
        return [
            'block_id'        => '',
            'versusTitleTag' => 'p',
            'vsLabel'        => 'VS',
            'versusTable'    => [],
            'boxShadow' => [
                'enable'   => false,
                'h_offset' => 0,
                'v_offset' => 5,
                'blur'     => 20,
                'spread'   => 0,
                'inset'    => false,
                'color'    => [
                    'color' => 'rgba(210,213,218,0.2)',
                ],
            ],
            'border' => [
                'width' => '0',
                'style' => 'solid',
                'color' => [
                    'color' => '#E6ECF7',
                ],
            ],
            'vsTextColor'     => '#000',
            'vsBgColor'       => '#E6ECF7',
            'contentColor'    => '#292929',
            'versusRowColor'  => '#F5F7FA',
            'bgType'          => 'solid',
            'bgColorSolid'    => '#FFFFFF',
            'bgColorGradient' => [
                'gradient' => 'linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%)',
            ],
        ];

    }

    public function render(): void
    {
        $attributes             = $this->get_settings_for_display();
        $attributes             = WidgetHelper::process_attributes($attributes);
        $attributes['block_id'] = $this->get_id();

        echo $this->render_template($attributes);
    }

    public function render_template(array $attributes, string $content = ''): string
    {
        $attributes = $this->parse_attributes($attributes);
        extract($attributes);

        if(self::IS_ELEMENTOR){
            // Elementor Context.

            $wrapper_attributes = sprintf(
                "id='affiliatex-versus-line-style-%s' class='affx-versus-line-block-container %s'",
                $block_id,
                isset($attributes['wrapper_class']) ? $attributes['wrapper_class'] : ''
            );
        } else{
            // Gutenberg Context.

            $wrapper_attributes = get_block_wrapper_attributes([
                'id'    => "affiliatex-versus-line-style-$block_id",
                'class' => "affx-versus-line-block-container " . (isset($attributes['wrapper_class']) ? $attributes['wrapper_class'] : '')
            ]);
        }

        $versusTitleTag = AffiliateX_Helpers::validate_tag($attributes['versusTitleTag'], 'p');

        ob_start();
        include $this->get_template_path();

        return ob_get_clean();
    }
}
