<?php if($edContent): ?>
    <div class="affx-single-product-content">
        <?php if($productContentType === 'list'): ?>
            <?php echo $list ?>
        <?php elseif($productContentType === 'paragraph'): ?>
            <p class="affiliatex-content"><?php echo wp_kses_post($productContent) ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>