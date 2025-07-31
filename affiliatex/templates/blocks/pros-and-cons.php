<div <?php echo $wrapper_attributes ?>>
	<div class="affx-pros-cons-inner-wrapper <?php echo esc_attr($inner_wrapper_classes) ?>">
		<div class="affx-pros-inner">
			<div class="pros-icon-title-wrap">
				<div class="affiliatex-block-pros">
					<?php if ($prosIconStatus): ?>
						<i class="<?php echo esc_attr($prosListIcon['value'] ?? '') ?>"></i>
					<?php endif; ?>
					<<?php echo wp_kses_post($titleTag1) ?> class="affiliatex-title"><?php echo wp_kses_post($prosTitle) ?></<?php echo wp_kses_post($titleTag1) ?>>
				</div>
			</div>
			<div class="affiliatex-pros">
				<?php if ($prosContentType === 'list' || $prosContentType === 'amazon'): ?>
					<?php echo $prosList ?>
				<?php else: ?>
					<p class="affiliatex-content"><?php echo $prosContent ?></p>
				<?php endif; ?>
			</div>
		</div>
		<div class="affx-cons-inner">
			<div class="cons-icon-title-wrap">
				<div class="affiliatex-block-cons">
					<?php if ($consIconStatus): ?>
						<i class="<?php echo esc_attr($consListIcon['value'] ?? '') ?>"></i>
					<?php endif; ?>
					<<?php echo wp_kses_post($titleTag1) ?> class="affiliatex-title"><?php echo wp_kses_post($consTitle) ?></<?php echo wp_kses_post($titleTag1) ?>>
				</div>
			</div>
			<div class="affiliatex-cons">
				<?php if ($consContentType === 'list' || $consContentType === 'amazon'): ?>
					<?php echo $consList ?>
				<?php else: ?>
					<p class="affiliatex-content"><?php echo $consContent ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>