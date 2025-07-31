<?php
use AffiliateX\Helpers\AffiliateX_Helpers;
?>
<div <?php echo $wrapper_attributes ?>>
    <div class="affx-product-comparison-block-container affx-versus-block-container">
        <div class="affx-versus-table-wrap">
            <table class="affx-product-versus-table layout-1">
                <thead>
                    <tr>
                        <th class="data-label" style="width:<?php echo 92 / (count($productComparisonTable) + 1) ?>%;"></th>
                        <?php foreach( $productComparisonTable as $item): ?>
                            <th class="affx-product-col" style="width:<?php echo 92 / (count($productComparisonTable) + 1) ?>%;">
                                <?php if($pcRibbon && !empty($item['ribbonText'])): ?>
                                    <span class="affx-pc-ribbon"><?php echo wp_kses_post($item['ribbonText']) ?></span>
                                <?php endif; ?>
                                <div class="affx-versus-product">
                                    <?php if($pcImage): ?>
                                        <div class="affx-versus-product-img">
                                            <?php echo AffiliateX_Helpers::affiliatex_get_media_image_html($item['imageId'] ?? 0, $item['imageUrl'] ?? '', $item['imageAlt'] ?? ''); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="affx-product-content">
                                        <?php if($pcTitle): ?>
                                            <div class="affx-product-title-wrap">
                                                <<?php echo esc_attr($pcTitleTag) ?> class="affx-comparison-title" style="text-align: <?php echo esc_attr($pcTitleAlign) ?>;">
                                                    <?php echo wp_kses_post($item['title']) ?>
                                                </<?php echo esc_attr($pcTitleTag) ?>>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($pcPrice): ?>
                                            <div class="affx-price-wrap">
                                                <span class="affx-price"><?php echo wp_kses_post($item['price']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="affx-rating-wrap">
                                            <?php echo $pcRating ? $this->render_pc_stars($item['rating'], $starColor, $starInactiveColor) : '' ?>
                                        </div>
                                        <?php if($pcButton): ?>
                                            <div class="affx-btn-wrap">
                                                <a href="<?php echo esc_url(do_shortcode($item['buttonURL'])) ?>" class="affiliatex-button affx-winner-button <?php echo $pcButtonIcon ? 'icon-btn icon-' . esc_attr($buttonIconAlign) : '' ?>" <?php echo $item['rel'] . ' ' . $item['target'] . ' ' . $item['download'] ?>>
                                                    <?php if($pcButtonIcon && $buttonIconAlign === 'left'): ?>
                                                        <i class="button-icon <?php echo esc_attr($buttonIcon['value']) ?>"></i>
                                                    <?php endif; ?>
                                                    <?php echo wp_kses_post($item['button']) ?>
                                                    <?php if($pcButtonIcon && $buttonIconAlign === 'right'): ?>
                                                        <i class="button-icon <?php echo esc_attr($buttonIcon['value']) ?>"></i>
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($comparisonSpecs as $index => $item): ?>
                        <tr>
                            <?php foreach($productComparisonTable as $countIndex => $count): ?>
                                <?php if($countIndex === 0): ?>
                                    <td class="data-label">
                                        <?php echo wp_kses_post($item['title']) ?>
                                    </td>
                                    <td>
                                        <?php echo wp_kses_post($item['specs'][$countIndex] ?? '') ?>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <?php echo wp_kses_post($item['specs'][$countIndex] ?? '') ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
