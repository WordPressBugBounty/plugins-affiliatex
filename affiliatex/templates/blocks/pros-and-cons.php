<div <?php echo $wrapper_attributes ?>>
    <div class="affx-pros-cons-inner-wrapper <?php echo esc_attr($layoutStyle) ?>">
        <div class="affx-pros-inner">
            <div class="pros-icon-title-wrap">
                <div class="affiliatex-block-pros">
                    <<?php echo wp_kses_post($titleTag1) ?> class="affiliatex-title affiliatex-icon <?php echo $prosIconStatus ? 'affiliatex-icon-' . $prosListIcon['name'] : '' ?>"><?php echo wp_kses_post($prosTitle) ?></<?php echo wp_kses_post($titleTag1) ?>>
                </div>
            </div>
            <div class="affiliatex-pros">
            <?php if($prosContentType === 'list'): ?>
                <<?php echo $prosListType == 'unordered' ? 'ul' : 'ol' ?> class="affiliatex-list <?php echo $prosUnorderedType === 'icon' ? 'icon affiliatex-icon affiliatex-icon-' . $prosIcon['name'] : 'bullet' ?>">
                    <?php foreach($prosListItems as $item): ?>
                        <li><span><?php echo wp_kses_post(affx_extract_child_items($item)) ?></span></li>
                    <?php endforeach; ?>
                </<?php echo $prosListType == 'unordered' ? 'ul' : 'ol' ?>>
            <?php else: ?>
                <p class="affiliatex-content"><?php echo $prosContent ?></p>
            <?php endif; ?>
            </div>
        </div>
        <div class="affx-cons-inner">
            <div class="cons-icon-title-wrap">
                <div class="affiliatex-block-cons">
                    <<?php echo wp_kses_post($titleTag1) ?> class="affiliatex-title affiliatex-icon <?php echo $consIconStatus ? 'affiliatex-icon-' . $consListIcon['name'] : '' ?>"><?php echo wp_kses_post($consTitle) ?></<?php echo wp_kses_post($titleTag1) ?>>
                </div>
            </div>
            <div class="affiliatex-cons">
            <?php if($consContentType === 'list'): ?>
                <<?php echo $consListType == 'unordered' ? 'ul' : 'ol' ?> class="affiliatex-list <?php echo $consUnorderedType === 'icon' ? 'icon affiliatex-icon affiliatex-icon-' . $consIcon['name'] : 'bullet' ?>">
                    <?php foreach($consListItems as $item): ?>
                        <li><span><?php echo wp_kses_post(affx_extract_child_items($item)) ?></span></li>
                    <?php endforeach; ?>
                </<?php echo $consListType == 'unordered' ? 'ul' : 'ol' ?>>
            <?php else: ?>
                <p class="affiliatex-content"><?php echo $consContent ?></p>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>