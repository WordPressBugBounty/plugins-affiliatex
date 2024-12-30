<div <?php echo $wrapper_attributes ?>>
    <div class="<?php echo esc_attr($layoutClass) ?> <?php echo esc_attr($ctaAlignment) ?> <?php echo esc_attr($columnReverseClass) ?> <?php echo esc_attr($bgClass) ?>">
        <div class="content-wrapper">
            <div class="content-wrap">
                <<?php echo esc_attr($ctaTitleTag) ?> class="affliatex-cta-title">
                    <?php echo wp_kses_post($ctaTitle) ?>
                </<?php echo esc_attr($ctaTitleTag) ?>>
                <?php if(!empty($ctaContent)): ?>
                    <p class="affliatex-cta-content"><?php echo wp_kses_post($ctaContent) ?></p>
                <?php endif; ?>
            </div>
            <?php if($edButtons): ?>
	            <div class="button-wrapper cta-btn-<?php echo esc_attr($ctaButtonAlignment) ?>">
	                <?php echo $content ?>
	            </div>
            <?php endif; ?>
        </div>
        <?php if($ctaLayout === 'layoutTwo'): ?>
            <div class="image-wrapper"></div>
        <?php endif; ?>
    </div>
</div>
