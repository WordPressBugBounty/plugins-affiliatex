<div <?php echo $wrapper_attributes ?>>
    <div class="affx-notice-inner-wrapper <?php echo esc_attr($layoutStyle) ?>">
        <?php if($layoutStyle === 'layout-type-3'): ?>
            <span class="affiliatex-notice-icon affiliatex-icon afx-icon-before <?php echo esc_attr($titleIconClass) ?>"></span>
        <?php endif; ?>
        <div class="affx-notice-inner">
            <<?php echo $titleTag1 ?> class="affiliatex-notice-title affiliatex-icon afx-icon-before <?php echo esc_attr($titleIconClass) ?>" style="text-align: <?php echo esc_attr($titleAlignment) ?>;">
            <?php echo wp_kses_post($noticeTitle) ?>
            </<?php echo $titleTag1 ?>>
            <div class="affiliatex-notice-content">
                <div class="list-wrapper">
                    <?php if($noticeContentType === 'list'): ?>
                        <<?php echo $listTag ?> class="<?php echo esc_attr($listClass) ?>">
                            <?php foreach( $noticeListItems as $item ): ?>
                                <?php if(isset($item['props']) && is_array($item)): ?>
                                    <li><?php echo wp_kses_post(affx_extract_child_items($item)) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </<?php echo $listTag ?>>
                    <?php elseif($noticeContentType === 'paragraph'): ?>
                        <p class="affiliatex-content">
                            <?php echo wp_kses_post($noticeContent) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>