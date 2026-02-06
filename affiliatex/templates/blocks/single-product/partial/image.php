<?php if ( $edProductImage ) : ?>
<div class="affx-sp-img-wrapper <?php echo esc_attr( $imageVerticalAlignClass ?? '' ); ?> <?php echo esc_attr( $imageHorizontalAlignClass ?? '' ); ?>">
	<?php echo wp_kses_post( $productImage ); ?>
</div>
<?php endif; ?>
