<?php if($productContentType === 'list' && isset($product['list'])): ?>
    <?php echo $product['list']; ?>
<?php elseif($productContentType === 'paragraph'): ?>
    <p class="affiliatex-content"><?php echo wp_kses_post(is_array($product['features']) ? implode(' ', $product['features']) : $product['features']) ?></p>
<?php endif; ?>