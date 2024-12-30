<tr>
	<?php if($edImage): ?>
    <td class="affx-img-col">
        <div class="affx-pdt-img-container">
            <?php if(!empty($ribbonText) && $edRibbon): ?>
                <span class="affx-pdt-ribbon affx-ribbon-2"><?php echo $ribbonText ?></span>
            <?php endif; ?>
            <?php if($edCounter): ?>
                <span class="affx-pdt-counter"><?php echo $counterText ?></span>
            <?php endif; ?>
            <div class="affx-pdt-img-wrapper">
                <img src="<?php echo $imageUrl ?>" alt="<?php echo $imageAlt ?>">
            </div>
            <?php include 'partial/rating.php' ?>
        </div>
    </td>
    <?php endif; ?>
	<?php if($edProductName): ?>
        <td><?php include 'partial/title.php' ?></td>
    <?php endif; ?>
    <td><?php include 'partial/features.php' ?></td>
    <td class="affx-price-col">
        <?php include 'partial/price.php' ?>
        <div class="affx-btn-wrapper">
            <?php include 'partial/button1.php' ?>
            <?php include 'partial/button2.php' ?>
        </div>
    </td>
</tr>
