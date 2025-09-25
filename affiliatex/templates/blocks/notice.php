<div <?php echo $wrapper_attributes ?>>
	<div class="affx-notice-inner-wrapper <?php echo esc_attr($layoutStyle) ?>">
		<div class="affx-notice-inner">
			<<?php echo $titleTag1 ?> class="affiliatex-notice-title">
				<?php if ($edTitleIcon): ?>
					<i class="<?php echo esc_attr($noticeTitleIcon['value'] ?? '') ?>"></i>
				<?php endif; ?>
				<?php echo wp_kses_post($noticeTitle) ?>
			</<?php echo $titleTag1 ?>>
			<div class="affiliatex-notice-content">
				<div class="list-wrapper">
					<?php if ($noticeContentType === 'list' || $noticeContentType === 'amazon'): ?>
						<?php echo $list ?>
					<?php elseif ($noticeContentType === 'paragraph'): ?>
						<p class="affiliatex-content">
							<?php echo wp_kses_post($noticeContent) ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>