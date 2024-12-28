<div <?php echo $wrapper_attributes ?>>
    <div class="affx-single-product-wrapper<?php echo esc_attr($layoutClass) ?>">
        <div class="affx-sp-inner">
            <?php 
                switch($productLayout) {
                    case 'layoutOne':
                        include 'single-product/layout-1.php';
                        break;
                    case 'layoutTwo':
                        include 'single-product/layout-2.php';
                        break;
                    case 'layoutThree':
                        include 'single-product/layout-3.php';
                        break;
                }
            ?>
        </div>
    </div>
</div>