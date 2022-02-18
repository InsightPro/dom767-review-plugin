<?php


class Dom767_Review_Activator {

	
	public static function activate() {


	    global $wpdb;
	    $charset_collate = $wpdb->get_charset_collate();
	    $table_name = $wpdb->prefix . 'dom767_reviews';
	    $table_name2 = $wpdb->prefix . 'dom767_review_meta';

	    $sql = "CREATE TABLE $table_name (
	        `review_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`review_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			`review_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
			`review_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
			`review_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
			`review_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
			`review_date` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			`review_date_gmt` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			`review_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
			`review_rating` real NOT NULL DEFAULT 0,
			`review_karma` int(11) NOT NULL DEFAULT 0,
			`review_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
			`review_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
			`review_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comment',
			`review_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			`user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,

			PRIMARY KEY  (review_ID),
			KEY `review_post_ID` (`review_post_ID`),
			KEY `review_author_email` (`review_author_email`),
  			KEY `review_date_gmt` (`review_date_gmt`),
  			KEY `review_agent` (`review_agent`),
  			KEY `review_parent` (`review_parent`)
  			
	    ) $charset_collate;";

	    $sql2 = "CREATE TABLE $table_name2 (
	          `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			  `review_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			  PRIMARY KEY  (meta_id)
	    ) $charset_collate;";

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	    dbDelta( $sql );
	    dbDelta( $sql2 );

	}

	public function create_folder_on_uploads(){
		$upload = wp_upload_dir();
	    $upload_dir = $upload['basedir'];
	    $upload_dir = $upload_dir . '/dom767_review_uploads';
	    if (! is_dir($upload_dir)) {
	      mkdir( $upload_dir, 0755, true );
	    }
	}

}
