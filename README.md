# dom767-review-plugin

///////////////////////////////////////////////////////
To get review template in your post, Add this code inside your single page template

if (function_exists('get_review_form_wrap')){
	echo get_review_form_wrap(get_the_ID()); 
}
or
if (function_exists('dom767_review_form_wrap')){
	echo do_shortcode('[dom767_review_form_wrap post_id="'.get_the_ID().'"]'); 
}

////////////////////////////////////////////////////
get post total review count
if (function_exists('dom767_post_total_review')){
	echo dom767_post_total_review(get_the_ID()); 
}

//////////////////////////////////////////////////
display post total avarage rating 
dom767_post_total_rating($get_the_ID());

///////////////////////////////////////////////////
display post total avarage star rating
get_post_total_star_rating($get_the_ID());

////////////////////////////////////////////////////
display post single user star rating
get_single_user_post_star_rating_0($review_id, $user_id, $post_id);

///////////////////////////////////////////////////
display post single user star rating
get_single_user_post_star_rating($review_id);

//////////////////////////////////////////////////
current user reting
get_current_user_post_rating($post_id);

///////////////////////////////////////////////////

current user reting star
get_current_user_post_star_rating($post_id);

///////////////////////////////////////////////////
Has the user already given a review?
dom767_did_user_review($post_id);

//////////////////////////////////////////////////
is it comment or rely
is_comment_or_reply($parent_ID);

//////////////////////////////////////////////////
replied to user name
get_replied_to_user_name($parent_ID);

//////////////////////////////////////////////////
did user comment on review
is_user_comment_on_review($review_ID);

//////////////////////////////////////////////////
get review comment count
get_review_comment_count($review_ID);

//////////////////////////////////////////////////
get comment reply count
get_comment_reply_count($review_ID);

//////////////////////////////////////////////////
get review comment and reply count
get_review_CommentAndReply_count($review_ID);

//////////////////////////////////////////////////
get review reply
get_review_reply($post_id, $parent_ID);

//////////////////////////////////////////////////
get review comment
get_review_comments($post_id, $parent_ID);

/////////////////////////////////////////////////
get review data
get_review($post_id);

/////////////////////////////////////////////////
get review list template
review_list_template($post_id, $page_no);

/////////////////////////////////////////////////
get review form
get_review_form_wrap($post_id);




/////////////////////////////////////////////////////////
						ADMIN
/////////////////////////////////////////////////////////
admin panel bootstap table
bootstrapTableQuery();

////////////////////////////////////////////////////////
Post total review query for admin
get_total_review();

////////////////////////////////////////////////////////
Post total review comment query for admin
get_review_comment($review_ID);
