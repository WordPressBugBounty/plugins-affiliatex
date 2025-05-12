<?php if($productContentType === 'list'): ?>
    <?php echo $product['list']; ?>
<?php elseif($productContentType === 'paragraph'): ?>
    <p class="affiliatex-content"><?php echo wp_kses_post($product['features']) ?></p>
<?php endif; ?>