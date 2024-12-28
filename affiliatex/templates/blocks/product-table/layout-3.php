<div class="affx-pdt-table-single">
    <?php if($edImage): ?>
        <div class="affx-pdt-img-wrapper">
            <img src="<?php echo $imageUrl ?>" alt="<?php echo $imageAlt ?>">
        </div>
    <?php endif; ?>
    <div class="affx-pdt-content-wrap">
        <div class="affx-content-left">
            <?php if($edCounter): ?>
                <span class="affx-pdt-counter"><?php echo $counterText ?></span>
            <?php endif; ?>
            <?php if(!empty($ribbonText) && $edRibbon): ?>
                <span class="affx-pdt-ribbon"><?php echo $ribbonText ?></span>
            <?php endif; ?>
            <?php include 'partial/title.php' ?>
            <div class="affx-rating-wrap"><?php include 'partial/rating.php' ?></div>
            <?php include 'partial/price.php' ?>
            <div class="affx-pdt-desc"><?php include 'partial/features.php' ?></div>
        </div>
        <div class="affx-pdt-button-wrap">
            <div class="affx-btn-wrapper">
                <?php include 'partial/button1.php' ?>
                <?php include 'partial/button2.php' ?>
            </div>
        </div>
    </div>
</div>