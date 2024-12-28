<?php if($edRatings && $PricingType === 'picture'): ?>
    <div class="affx-sp-pricing-pic rating-align-<?php echo esc_attr($productStarRatingAlign) ?>">
        <?php echo $this->render_pb_stars($ratings, $productRatingColor, $ratingInactiveColor, $ratingStarSize) ?>
    </div>
<?php elseif($edRatings && $PricingType === 'number'): ?>
    <div class="affx-rating-box affx-rating-number">
        <span class="num"><?php echo wp_kses_post($numberRatings) ?></span>
        <span class="label"><?php echo wp_kses_post($ratingContent) ?></span>
    </div>
<?php endif; ?>