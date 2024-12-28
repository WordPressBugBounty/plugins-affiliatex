<div class="affx-sp-content <?php echo esc_attr($imageAlign) ?> <?php echo esc_attr($imageClass) ?>">
    <?php include 'partial/ribbon.php' ?>
    <?php include 'partial/image.php' ?>
    <div class="affx-sp-content-wrapper">
        <div class="title-wrapper affx-<?php echo esc_attr($ratingClass) ?> <?php echo esc_attr($productRatingNumberClass) ?>">
            <div class="affx-title-left">
                <?php include 'partial/title.php' ?>
                <?php include 'partial/subtitle.php' ?>
            </div>
            <?php include 'partial/rating.php' ?>
        </div>
        <?php include 'partial/price.php' ?>
        <div class="affx-single-product-content">
            <?php include 'partial/content.php' ?>
        </div>
        <?php include 'partial/button.php' ?>
    </div>
</div>