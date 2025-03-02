<div <?php echo $wrapper_attributes ?>>
    <div class="affx-btn-inner">
        <?php if (isset($elementorLinkAttributes)): ?>
            <a <?php echo $elementorLinkAttributes; ?>>
                <?php echo $iconLeft ?>
                <span class="affiliatex-btn"><?php echo wp_kses_post($buttonLabel) ?></span>
                <?php echo $iconRight ?>
                <?php if($layoutStyle === 'layout-type-2' && $priceTagPosition): ?>
                    <span class="price-tag">
                        <?php echo wp_kses_post($productPrice) ?>
                    </span>
                <?php endif; ?>
            </a>
        <?php else: ?>
            <a href="<?php echo esc_url(do_shortcode($buttonURL)) ?>" 
               class="<?php echo esc_attr($classNames) ?>" 
               rel="<?php echo esc_attr($rel) ?>"
               <?php echo $target ?>
               <?php echo $download ? 'download' : ''; ?>
            >
                <?php echo $iconLeft ?>
                <span class="affiliatex-btn"><?php echo wp_kses_post($buttonLabel) ?></span>
                <?php echo $iconRight ?>
                <?php if($layoutStyle === 'layout-type-2' && $priceTagPosition): ?>
                    <span class="price-tag">
                        <?php echo wp_kses_post($productPrice) ?>
                    </span>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </div>
</div>