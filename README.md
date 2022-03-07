# dom767-review-plugin

To get review template in your post, Add this code inside your single page template

<?php
functions

if (function_exists('get_review_form_wrap')){
	echo get_review_form_wrap(get_the_ID()); 
}

or
shortcode

if (function_exists('dom767_review_form_wrap')){
	echo do_shortcode('[dom767_review_form_wrap post_id="'.get_the_ID().'"]'); 
}


?>