<?php if($productContentType === 'list'): ?>
    <<?php echo $contentListType == 'unordered' ? 'ul' : 'ol' ?> class="affx-unordered-list affiliatex-icon affiliatex-icon-<?php echo esc_attr($productIconList['name']) ?>">
        <?php if(!is_array($featuresList)): ?>
            <?php echo wp_kses_post($featuresList) ?>
        <?php else: ?>
            <?php foreach($featuresList as $item): ?>
                <?php if(is_array($item)): ?>
                    <li><?php echo wp_kses_post(affx_extract_child_items($item)) ?></li>
                <?php elseif(is_string($item)): ?>
                    <li><?php echo wp_kses_post($item) ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </<?php echo $contentListType == 'unordered' ? 'ul' : 'ol' ?>>
<?php elseif($productContentType === 'paragraph'): ?>
    <p class="affiliatex-content"><?php echo wp_kses_post($product['features']) ?></p>
<?php endif; ?>