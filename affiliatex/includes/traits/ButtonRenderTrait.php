<?php
namespace AffiliateX\Traits;

trait ButtonRenderTrait {
    /**
     * Generate button class names based on attributes
     */
    protected function get_button_classes($attributes) {
        $classNames = [
            'affiliatex-button',
            'btn-align-' . ($attributes['buttonAlignment'] ?? 'flex-start'),
            'btn-is-' . ($attributes['buttonSize'] ?? 'medium'),
            $attributes['buttonWidth'] === 'fixed' ? 'btn-is-fixed' : '',
            $attributes['buttonWidth'] === 'full' ? 'btn-is-fullw' : '',
            $attributes['buttonWidth'] === 'flexible' ? 'btn-is-flex-' . $attributes['buttonSize'] : '',
            $attributes['layoutStyle'] === 'layout-type-2' && $attributes['priceTagPosition'] === 'tagBtnleft' ? 'left-price-tag' : '',
            $attributes['layoutStyle'] === 'layout-type-2' && $attributes['priceTagPosition'] === 'tagBtnright' ? 'right-price-tag' : '',
            $attributes['edButtonIcon'] && $attributes['iconPosition'] === 'axBtnright' ? 'icon-right' : 'icon-left'
        ];
        
        return array_filter($classNames);
    }

    /**
     * Prepare attributes for template
     */
    protected function prepare_template_attributes($attributes) {
        // Create wrapper attributes differently based on context
        if (isset($attributes['elementorLinkAttributes'])) {
            // Elementor context
            $wrapper_attributes = sprintf(
                'class="affx-btn-wrapper" id="affiliatex-blocks-style-%s"',
                esc_attr($attributes['block_id'])
            );
        } else {
            // Gutenberg context
            $wrapper_attributes = get_block_wrapper_attributes([
                'class' => 'affx-btn-wrapper',
                'id' => "affiliatex-blocks-style-{$attributes['block_id']}"
            ]);

            // Prepare Gutenberg-specific attributes
            $rel = ['noopener'];
            if (!empty($attributes['btnRelNoFollow'])) $rel[] = 'nofollow';
            if (!empty($attributes['btnRelSponsored'])) $rel[] = 'sponsored';
            $attributes['rel'] = implode(' ', $rel);
            
            $attributes['target'] = !empty($attributes['openInNewTab']) ? ' target="_blank"' : '';
            $attributes['download'] = !empty($attributes['btnDownload']);
            $attributes['classNames'] = implode(' ', $this->get_button_classes($attributes));
        }

        // Prepare icon HTML
        $attributes['iconLeft'] = !empty($attributes['edButtonIcon']) && $attributes['iconPosition'] === 'axBtnleft' 
            ? '<i class="button-icon ' . esc_attr($attributes['ButtonIcon']['value']) . '"></i>' 
            : '';
            
        $attributes['iconRight'] = !empty($attributes['edButtonIcon']) && $attributes['iconPosition'] === 'axBtnright' 
            ? '<i class="button-icon ' . esc_attr($attributes['ButtonIcon']['value']) . '"></i>' 
            : '';

        return array_merge(['wrapper_attributes' => $wrapper_attributes], $attributes);
    }

    /**
     * Render button using template
     */
    protected function render_button($attributes) {
        $template_attributes = $this->prepare_template_attributes($attributes);
        extract($template_attributes);
        
        ob_start();
        include AFFILIATEX_PLUGIN_DIR . '/templates/blocks/buttons.php';
        return ob_get_clean();
    }
} 