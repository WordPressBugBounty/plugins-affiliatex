<?php if($edContent): ?>
    <div class="affx-single-product-content">
        <?php if($productContentType === 'list'): ?>
            <<?php echo $ContentListType === 'unordered' ? 'ul' : 'ol' ?> class="affx-unordered-list affiliatex-icon affiliatex-icon-<?php echo esc_attr($productIconList['name']) ?>">
                <?php foreach($productContentList as $item): ?>
                    <li><?php echo wp_kses_post(affx_extract_child_items($item)) ?></li>
                <?php endforeach; ?>
            </<?php echo $ContentListType === 'unordered' ? 'ul' : 'ol' ?>>
        <?php elseif($productContentType === 'paragraph'): ?>
            <p class="affiliatex-content"><?php echo wp_kses_post($productContent) ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>