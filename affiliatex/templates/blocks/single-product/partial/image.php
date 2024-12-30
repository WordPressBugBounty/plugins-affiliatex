<?php if($edProductImage): ?>
<div class="affx-sp-img-wrapper">
    <?php if($isSiteStripe): ?>
        <?php echo wp_kses_post($productImageSiteStripe) ?>
    <?php else: ?>
        <img src="<?php echo esc_url(do_shortcode($ImageURL)) ?>" />
    <?php endif; ?>
</div>
<?php endif; ?>
