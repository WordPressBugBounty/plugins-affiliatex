<?php if($edRibbon): ?>
    <div class="affx-sp-ribbon<?php echo esc_attr($ribbonLayout) ?>">
        <div class="affx-sp-ribbon-title">
            <?php echo wp_kses_post($ribbonText) ?>
        </div>
    </div>
<?php endif; ?>