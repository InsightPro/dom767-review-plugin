
<h1>Review Setting Options Page</h1>
<form method="post" action=" <?php echo admin_url('admin-post.php') ?>">
	<?php
		wp_nonce_field("dom767_review");

		$settingTypes = array('review-media','comment-media', 'review-edit', 'comment-edit', 'review-filter-oldest', 'review-filter-high-rating', 'review-filter-low-rating', 'review-aprove-when-submit', 'comment-aprove-when-submit');
		foreach ($settingTypes as $settingType) {
			$stringlabel = trim(str_replace("-"," ", $settingType));
			$stringlabel = strtoupper($stringlabel);

			$get_review_setting_options = get_option('dom767_review_seting_option_'.$settingType);
			
			?>

			<div id="dom767_review_seting_option_item" class="option-item ">
				<span class="tie-label"><?php echo $stringlabel ?></span>
				<input type="hidden" name="dom767_review_seting_option_<?php echo $settingType ?>" value="0">
				<input id="dom767_review_seting_option_<?php echo $settingType ?>" class="tie-js-switch" name="dom767_review_seting_option_<?php echo $settingType ?>" type="checkbox" value="1" <?php  echo ($get_review_setting_options == '1')? 'checked':'' ?> style="display: none" />
			</div>

		
		<?php
		}

	?>

	<input type="hidden" name="action" value="dom767ReviewAdminSettingPage">
	<?php 
		submit_button('Save') ;
	?>
</form>


<?php// require_once plugin_dir_path( __FILE__ ) . 'post_total_review_count_query.php'; ?>


