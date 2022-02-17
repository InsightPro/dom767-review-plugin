<?php


///////////////////////////////////////////////////////////////////////////////////////

function dom767_post_total_review($post_id){
  global $wpdb, $post;
  $post_id = ($post_id != '')? $post_id : get_the_ID();
  
  $review_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0');

  $total_review = count($review_query);
  //$total_rating = round($total_rating, 2);

  return $total_review;
}

///////////////////////////////////////////////////////////////////////////////////////


function dom767_did_user_review($post_id){
  global $wpdb, $post;
  if (is_user_logged_in()) {
    $user_id = get_current_user_id();
  }
  $post_id = ($post_id != '')? $post_id : get_the_ID();
  
  $review_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0 AND user_id = '.$user_id.' AND review_type = "review"');

  $total_review = count($review_query);

  $did_user_review = 0;

  if ($total_review > 0) {
    $did_user_review = 1;
  }else{
    $did_user_review = 0;
  }

  return $did_user_review;
}


///////////////////////////////////////////////////////////////////////////////////
////////////////////////// current user reting  ///////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function get_current_user_post_rating($post_id){

  global $wpdb, $post;
  $post_id = ($post_id != '')? $post_id : get_the_ID();
  $user_id = get_current_user_id();

  $rating_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0 AND user_id = '.$user_id.' AND review_type = "review"');

  $rating_val = (float)$rating_query[0]->review_rating;
  $rating_val = number_format($rating_val , 1);/// convert to decimal number.
  $rating_stars = $rating_val * 20 .'%';
  return $rating_val;
}


///////////////////////////////////////////////////////////////////////////////////
////////////////////////// current user reting star ///////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function get_current_user_post_star_rating($post_id){

  global $wpdb, $post;
  $post_id = ($post_id != '')? $post_id : get_the_ID();
  $user_id = get_current_user_id();

  $rating_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0 AND user_id = '.$user_id.' AND review_type = "review"');

  $rating_val = (float)$rating_query[0]->review_rating;
  $rating_val = number_format($rating_val , 1);/// convert to decimal number.
  $rating_stars = $rating_val * 20 .'%';

  ?>
  <div class="reviewer-rating">
    <div class="starRatingContainer" style="width:80px; max-width:80px; height:16px;">
        <div class="ratingSystem" data-rating="2.3" data-step="0.5" style="width: 80px; height: 16px; background-size: 16px; background-image: url(&quot; <?php echo plugin_dir_url( __FILE__ ); ?>assets/public/image/backgroundStar.png &quot;); background-repeat: repeat-x; min-width: 8px; max-width: 80px;">
            <div class="emptyStarRating" style="background-size: 16px; background-image: url(&quot; <?php echo plugin_dir_url( __FILE__ ); ?>assets/public/image/star.png &quot;); background-repeat: repeat-x; width: <?php echo $rating_stars ?>; height: 16px;">
            </div>
        </div> 
    </div>
  </div>
  <?php
  return;
}


///////////////////////////////////////////////////////////////////////////////////
////////////////////// display post single user star rating////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function get_single_user_post_star_rating($review_id, $user_id, $post_id){

  global $wpdb, $post;
  $post_id = ($post_id != '')? $post_id : get_the_ID();
  $user_id = ($user_id != '')? $user_id : get_current_user_id();

  $rating_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_ID ='.$review_id.' AND review_parent = 0 AND user_id = '.$user_id.' AND review_type = "review"');

  $rating_val = (float)$rating_query[0]->review_rating;
  $rating_val = number_format($rating_val , 1);/// convert to decimal number.
  $rating_stars = $rating_val * 20 .'%';

  ?>
  <div class="reviewer-rating">
    <div class="starRatingContainer" style="width:80px; max-width:80px; height:16px;">
        <div class="ratingSystem" data-rating="2.3" data-step="0.5" style="width: 80px; height: 16px; background-size: 16px; background-image: url(&quot; <?php echo plugin_dir_url( __FILE__ ); ?>assets/public/image/backgroundStar.png &quot;); background-repeat: repeat-x; min-width: 8px; max-width: 80px;">
            <div class="emptyStarRating" style="background-size: 16px; background-image: url(&quot; <?php echo plugin_dir_url( __FILE__ ); ?>assets/public/image/star.png &quot;); background-repeat: repeat-x; width: <?php echo $rating_stars ?>; height: 16px;">
            </div>
        </div> 
    </div>
  </div>
  <?php
  return;
}



///////////////////////////////////////////////////////////////////////////////////
//////////////////////////// display post total rating ////////////////////////////
///////////////////////////////////////////////////////////////////////////////////


function dom767_post_total_rating($post_id){
  global $wpdb, $post;
  $post_id = ($post_id != '')? $post_id : get_the_ID();

  $rating_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0');

  $sum = 0;
  foreach ($rating_query as  $rating) {
    $rating_val = (float)$rating->review_rating;
    $sum = $sum + $rating_val;
  }
  $total_rating = count($rating_query) != 0 ? $sum / count($rating_query): 0;
  $total_rating = round($total_rating, 2);

  return $total_rating;
}



///////////////////////////////////////////////////////////////////////////////////
///////////////////////// display post total star rating //////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function get_post_total_star_rating($post_id){
  global $wpdb, $post;
  $post_id = ($post_id != '')? $post_id : get_the_ID();

  $rating_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0  AND review_type = "review"');

  $sum = 0;
  foreach ($rating_query as  $rating) {
    $rating_val = (float)$rating->review_rating;
    $sum = $sum + $rating_val;
  }

  $total_rating = count($rating_query) != 0 ? $sum / count($rating_query): 0;
  $total_rating = round($total_rating, 2);
  //var_dump($total_rating);
  $rating_stars = $total_rating * 20 .'%';

  ?>
  <div class="reviewer-rating">
    <div class="starRatingContainer" style="width:125px; max-width:125px; height:25px;">
        <div class="ratingSystem" data-rating="2.3" data-step="0.5" style="width: 125px; height: 25px; background-size: 25px; background-image: url(&quot; <?php echo plugin_dir_url( __FILE__ ); ?>assets/public/image/backgroundStar.png &quot;); background-repeat: repeat-x; min-width: 25px; max-width: 125px;">
            <div class="emptyStarRating" id="postTotalEmptyStarRating" style="background-size: 25px; background-image: url(&quot; <?php echo plugin_dir_url( __FILE__ ); ?>assets/public/image/star.png &quot;); background-repeat: repeat-x; width: <?php echo $rating_stars ?>; height: 25px;">
            </div>
        </div> 
    </div>
  </div>
  <?php
  return;
}




////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// get review reply  form ////////////////////////////
////////////////////////////////////////////////////////////////////////////////////


function get_reply_form_wrap($post_id, $parent_id) {

    $post_id = ($post_id != '')? $post_id: get_the_ID();
    $total_review     = dom767_post_total_review($post_id);
    $did_user_review  = dom767_did_user_review($post_id);
    ?>
    <div class="review-reply-form-wrap">

      <?php 
      if (is_user_logged_in()) { ?>
        <form id="dom767_review_reply_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="dom767_review_reply_form">
            <div class="reply-form-element">
              <input type="hidden" name="review_post_id" id="review_post_id" value="<?php echo $post_id  ?>" >
              <input type="hidden" name="review_parent_id" id="review_parent_id" value="<?php echo $parent_id  ?>" >
              <label class="hide" for="review">Message</label>
              <textarea id="review_text_area" class="review-input-fields" placeholder="Write your reply" name="review" cols="40" rows="10"></textarea>
            </div>

            <input name="submit" class="form-submit-button"  type="submit" id="dom767-reply-submit" value="submit">
            <button type="button" class="btn reply_form_close_btn" id="reply_form_close_btn">close</button>

        </form>
      <?php
      }/// end if did user review
      ?>
    </div>
    <?php
  return;

}


///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// is it comment or rely ////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function is_comment_or_reply($parent_ID){
  global $wpdb, $post;
  $reply_query = $wpdb->get_results('SELECT review_karma FROM wp_dom767_reviews WHERE review_ID ='.$parent_ID.' ORDER BY review_ID DESC');
  $replied_to = $reply_query[0]->review_karma;
  if ($replied_to == 0) {
    $comment_type = 'comment';
  }else{
    $comment_type = 'reply';
  }
  return $comment_type;
}

///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// replied to user name//////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function get_replied_to_user_name($parent_ID){
  global $wpdb, $post;
  $reply_query = $wpdb->get_results('SELECT review_author FROM wp_dom767_reviews WHERE review_ID ='.$parent_ID.' ORDER BY review_ID DESC');
  $replied_to = $reply_query[0]->review_author;
  return $replied_to;
}


///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// get review reply /////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function get_review_reply($post_id, $parent_ID){
  global $wpdb, $post;
  $current_user_id = get_current_user_id();
  $post_id = ($post_id != '')? $post_id : get_the_ID();
  $reply_query = $wpdb->get_results('SELECT * FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent ='.$parent_ID.' ORDER BY review_ID DESC');
  //var_dump($reply_query);
  foreach ($reply_query as $query_data) {
    $review_ID            = $query_data->review_ID;
    $review_post_ID       = $query_data->review_post_ID;
    $review_author        = $query_data->review_author;
    $review_author_email  = $query_data->review_author_email;
    $review_author_url    = $query_data->review_author_url;
    $review_author_IP     = $query_data->review_author_IP;
    $review_date          = $query_data->review_date;
    $review_date_gmt      = $query_data->review_date_gmt;
    $review_content       = $query_data->review_content;
    $review_rating        = $query_data->review_rating;
    $review_karma         = $query_data->review_karma;
    $review_approved      = $query_data->review_approved;
    $review_agent         = $query_data->review_agent;
    $review_type          = $query_data->review_type;
    $review_parent        = $query_data->review_parent;
    $user_id              = $query_data->user_id;
    $karma                = $review_karma;
    $commentType          = is_comment_or_reply($review_parent);
    $reply_to_user_name   = get_replied_to_user_name($review_parent);


    //////////////////////// review meta query ///////////////////////////////
    $vote_query = $wpdb->get_results('SELECT * FROM wp_dom767_review_meta WHERE review_id ='.$review_ID.' AND meta_key = "dom_review_vote" ORDER BY review_ID DESC');

    $total_like = 0;
    $total_dislike = 0;
    $did_user_vote = 'false';
    if ($vote_query) {
      foreach ($vote_query as $vote_object) {
        $vote_arr = json_decode($vote_object->meta_value);
        $current_user = get_current_user_id();
        if ($vote_arr->user == $current_user) {
          $meta_id = $vote_object->meta_id;
          $did_user_vote = 'true';
          $user_vote_val = $vote_arr->vote;
        }
        if ($vote_arr->vote == "like") {
          $total_like ++;
        }
        if ($vote_arr->vote == "dislike") {
          $total_dislike ++;
        }
      }///end foreach
    }///end if

    /////////////////////////////////////////////////////////////////////////
    
    ?>

    <div class="review_card reply-single-info">
      <div class="single-rev-avater">
        <div class="reviewer-avater">
          <?php echo get_avatar( $user_id ); ?>
        </div>
      </div>
      <div class="reviewer-single-info-data">
        <div class="display-inline-block">
          <div class="reviewer-name">
            <p class="reviewer-fullname">
              <strong><?php echo $review_author ?></strong>
              <?php echo ($commentType == 'reply')? ' <i class="fa fa-caret-right"></i> '.$reply_to_user_name : '';?>
            </p>
          </div>
          <?php //echo get_single_user_post_star_rating($review_ID,$user_id, $review_post_ID) ?>
          
        </div>
        <div class="review_date_div">
          <p class="review-date-text"> <?php echo $review_date ?></p>
        </div>
        <div class="review-content-div">
          <div class="review-content">
            <p class="review-content-text"><?php echo $review_content ?></p>
          </div>
        </div>
        <ul class="list-inline d-sm-flex my-0">
          <li class="list-inline-item g-mr-20">
            <span class="dom767_review_like_dislike" id="review_like_button_<?php echo $review_ID ?>" data-value="like" data-did_vote="<?php echo $did_user_vote ?>" data-vote_val="<?php echo $user_vote_val ?>" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
              <i class="fa fa-thumbs-up"></i>
              <bdi><?php echo $total_like ?></bdi>
            </span>
          </li>
          <li class="list-inline-item g-mr-20">
            <span class="dom767_review_like_dislike" id="review_dislike_button_<?php echo $review_ID ?>" data-value="dislike" data-did_vote="<?php echo $did_user_vote ?>" data-vote_val="<?php echo $user_vote_val ?>" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
              <i class="fa fa-thumbs-down"></i>
              <bdi><?php echo $total_dislike ?></bdi>
            </span>
          </li>
          <li class="list-inline-item ml-auto">
            <span class="dom767_review_reply_button" id="dom767_review_reply_button" data-parent_ID="<?php echo $review_ID ?>" data-karma="<?php echo $karma ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
              <i class="fa fa-reply"></i>
              Reply
            </span>
          </li>
          <?php if ($user_id == $current_user_id  ): ?>
          <li class="list-inline-item ml-auto">
            <span class="dom767_review_edit_button" id="dom767_review_edit_button" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
              <i class="fa fa-edit"></i>
              Edit
            </span>
          </li>
          <?php endif ?>
        </ul>
      </div>
    </div>
    <div style="margin-left: 50px">
    <?php echo get_review_reply($post_id, $review_ID); ?>
    </div>
    <?php

  }///end foreach

  return;
}

///////////////////////////////////////////////////////////////////////////////////
////////////////////////////// get review reply count /////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
function get_review_reply_count($post_id, $review_ID){
  global $wpdb, $post;
  $post_id = ($post_id != '')? $post_id : get_the_ID();
  $review_query = $wpdb->get_results('SELECT * FROM wp_dom767_reviews WHERE review_karma = '.$review_ID.' ORDER BY review_ID DESC');
  $reply_count = count($review_query);
  return $reply_count;
}



///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// get review //////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
function get_review($post_id){
  global $wpdb, $post;
  $post_id = ($post_id != '')? $post_id : get_the_ID();

  $review_query = $wpdb->get_results('SELECT * FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0 ORDER BY review_ID DESC');

  $review_query_arr = array();

  foreach ($review_query as $query_data) {

    $fav_query_data_arr[]  = array(
      'review_ID'           => $query_data->review_ID,
      'review_post_ID'      => $query_data->review_post_ID,
      'review_author'       => $query_data->review_author,
      'review_author_email' => $query_data->review_author_email,
      'review_author_url'   => $query_data->review_author_url,
      'review_author_IP'    => $query_data->review_author_IP,
      'review_date'         => $query_data->review_date,
      'review_date_gmt'     => $query_data->review_date_gmt,
      'review_content'      => $query_data->review_content,
      'review_rating'       => $query_data->review_rating,
      'review_karma'        => $query_data->review_karma,
      'review_approved'     => $query_data->review_approved,
      'review_agent'        => $query_data->review_agent,
      'review_type'         => $query_data->review_type,
      'review_parent'       => $query_data->review_parent,
      'user_id'             => $query_data->user_id,
    );

  }////end foreach


  return $fav_query_data_arr;
}

///////////////////////////////////////////////////////////////////////////////////
//////////////////////////// post review list template ////////////////////////////
///////////////////////////////////////////////////////////////////////////////////


function review_list_template($post_id){

  global $wpdb, $post;

  $post_id          = ($post_id != '') ? $post_id : get_the_ID();
  $current_user_id  = get_current_user_id();
  $upload_dir       = wp_upload_dir();// Upload directory
  $upload_location  = $upload_dir['basedir'] .'/dom767_review_uploads/';
  $upload_url       = $upload_dir['baseurl'] .'/dom767_review_uploads/';

  //$review_query0 = $wpdb->get_results('SELECT * FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0 ORDER BY review_ID DESC');

  $review_query = get_review($post_id);

  if ($review_query) {
    $limit          = 5;
    $total_item     = count($review_query);
    $total_pages    = ceil($total_item/$limit);
    $review_query   = array_slice( $review_query, 0, $limit ); 
    ?>
    <div class="review_list_wrap">
      <div class="row">
        <div class="col-md-6">
          <h4>
            This Post has a Total <?php echo $total_item ?> <?php echo ($total_item > 1)? 'Reviews': 'Review'; ?>
          </h4>
          <div class="review_list_card">
            <div class="reviewer-single-info-cont">
            <?php
            foreach ($review_query as $query_data) {

              $review_ID            = $query_data['review_ID'];
              $review_post_ID       = $query_data['review_post_ID'];
              $review_author        = $query_data['review_author'];
              $review_author_email  = $query_data['review_author_email'];
              $review_author_url    = $query_data['review_author_url'];
              $review_author_IP     = $query_data['review_author_IP'];
              $review_date          = $query_data['review_date'];
              $review_date_gmt      = $query_data['review_date_gmt'];
              $review_content       = $query_data['review_content'];
              $review_rating        = $query_data['review_rating'];
              $review_karma         = $query_data['review_karma'];
              $review_approved      = $query_data['review_approved'];
              $review_agent         = $query_data['review_agent'];
              $review_type          = $query_data['review_type'];
              $review_parent        = $query_data['review_parent'];
              $user_id              = $query_data['user_id'];
              $karma                = ($review_parent == 0)? $review_ID : $review_karma;

              //////////////////////// review meta query ///////////////////////////////

              $media_query = $wpdb->get_results('SELECT meta_value FROM wp_dom767_review_meta WHERE review_id ='.$review_ID.' AND meta_key = "dom767_review_uploads" ORDER BY review_ID DESC');

              $media_name_array = $media_query[0]->meta_value;
              $media_name_array  = explode(",",$media_name_array);///string to array
              //var_dump($media_query);

              $vote_query = $wpdb->get_results('SELECT * FROM wp_dom767_review_meta WHERE review_id ='.$review_ID.' AND meta_key = "dom_review_vote" ORDER BY review_ID DESC');
              
              $total_like = 0;
              $total_dislike = 0;
              $did_user_vote = 'false';
              if ($vote_query) {
                foreach ($vote_query as $vote_object) {
                  $vote_arr = json_decode($vote_object->meta_value);
                  $current_user = get_current_user_id();
                  if ($vote_arr->user == $current_user) {
                    $meta_id = $vote_object->meta_id;
                    $did_user_vote = 'true';
                    $user_vote_val = $vote_arr->vote;
                  }
                  if ($vote_arr->vote == "like") {
                    $total_like ++;
                  }
                  if ($vote_arr->vote == "dislike") {
                    $total_dislike ++;
                  }
                }///end foreach
              }///end if

              /////////////////////////////////////////////////////////////////////////
              ?>

              <?php if ($review_parent == 0): ?>
                <div class="review_card reviewer-single-info">
                  <div class="single-rev-avater">
                    <div class="reviewer-avater">
                      <?php echo get_avatar( $user_id ); ?>
                    </div>
                  </div>
                  <div class="reviewer-single-info-data">
                    <div class="display-inline-block">
                      <div class="reviewer-name">
                        <p class="reviewer-fullname">
                          <strong><?php echo $review_author ?></strong>
                        </p>
                      </div>
                      <?php echo get_single_user_post_star_rating($review_ID, $user_id, $review_post_ID) ?>
                      
                    </div>
                    <div class="review_date_div">
                      <p class="review-date-text"> <?php echo $review_date ?></p>
                    </div>
                    <div class="review-content-div">
                      <div class="review-content">
                        <p class="review-content-text"><?php echo $review_content ?></p>
                      </div>
                    </div>
                    <?php if ($media_query): ?>
                      <?php foreach ($media_name_array as $media_name): ?>
                        <img src="<?php echo $upload_url.$media_name ?>" alt="" style="height: 100px; width: 100px;" >
                      <?php endforeach ?>
                    <?php endif ?>
                    <ul class="list-inline d-sm-flex my-0">
                      <li class="list-inline-item g-mr-20">
                        <span class="dom767_review_like_dislike" id="review_like_button_<?php echo $review_ID ?>" data-value="like" data-did_vote="<?php echo $did_user_vote ?>" data-vote_val="<?php echo $user_vote_val ?>" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                          <i class="fa fa-thumbs-up"></i>
                          <bdi><?php echo $total_like ?></bdi>
                        </span>
                      </li>
                      <li class="list-inline-item g-mr-20">
                        <span class="dom767_review_like_dislike" id="review_dislike_button_<?php echo $review_ID ?>" data-value="dislike" data-did_vote="<?php echo $did_user_vote ?>" data-vote_val="<?php echo $user_vote_val ?>" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                          <i class="fa fa-thumbs-down"></i>
                          <bdi><?php echo $total_dislike ?></bdi>
                        </span>
                      </li>
                      <li class="list-inline-item ml-auto">
                        <span class="dom767_review_reply_button" id="dom767_review_reply_button" data-parent_ID="<?php echo $review_ID ?>" data-karma="<?php echo $karma ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                          <i class="far fa-comment-alt"></i>
                          Comment
                        </span>
                      </li>
                      <?php if ($user_id == $current_user_id  ): ?>
                      <li class="list-inline-item ml-auto">
                        <span class="dom767_review_edit_button" id="dom767_review_edit_button" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                          <i class="fa fa-edit"></i>
                          Edit
                        </span>
                      </li>
                      <?php endif ?>
                      <li class="list-inline-item1 ml-auto" style="float: right;">
                        <span class="dom767_review_comment_count" id="dom767_review_comment_count" data-parent_ID="<?php echo $review_ID ?>" data-karma="<?php echo $karma ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                          <i class="far fa-comment-dots"></i>
                          <?php echo get_review_reply_count($post_id, $review_ID) ?>
                        </span>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="dom767_review_reply_main_wrap" id="review_reply_main_wrap_<?php echo $review_ID?>" style="margin-left: 50px">
                <?php echo get_review_reply($post_id, $review_ID); ?>
                </div>
              <?php endif ?><!-- end if review parent = 0 -->

              <?php
            }///end foreach
            ?>
            </div>
            <?php if ($total_pages > 1): ?>
              <button type="button" class="btn dom767-load-more-review btn-success" data-post-id="<?php echo $post_id ?>" data-total-page="<?php echo $total_pages ?>" data-current-page="1" >Load More</button>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  return;
}



////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// get review form ///////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////


function get_review_form_wrap($post_id) {

  $post_id = ($post_id != '')? $post_id : get_the_ID();
  $total_review     = dom767_post_total_review($post_id);
  $did_user_review  = dom767_did_user_review($post_id);
	?>
  <div class="review-form-and-list-wrap" >
  	<div class="review-form-wrap">
      <h2 class="review-wrapper-heading">Review </h2>
      <div class="row">
          <div class="col-md-6">
              <div class="card">
                  <div class="card-body text-center">
                    <h4 class="rating-heading">
                      <span id="total_review_count" ><?php echo $total_review ?></span> 
                      <span id="total_review_text" >
                        <?php echo ($total_review > 1)? 'Reviews' : 'Review'; ?>
                      </span> 
                    </h4> 
                    <h4>and</h4>
                    <div class="dom767_total_rating_text">
                      <h4><span class="dom767_total_rating_val"><?php echo dom767_post_total_rating($post_id) ?> </span> rating</h4>
                    </div>
                    <div class="dom767_post_total_ratimg_star">
                      <?php echo get_post_total_star_rating($post_id) ?>
                    </div>
                  </div>
              </div>
          </div>
      </div>
        <?php if ($did_user_review != 0 &&  is_user_logged_in()): ?>
          <div class="did_user_review_text">
            <h4 class="did_user_review_text_h4"> You have already reviewed this post <?php echo get_current_user_post_rating($post_id) ?> Rating</h4>
          </div>
        <?php endif ?>
      <?php 
      if (is_user_logged_in() && $did_user_review == 0) { ?>
        <div class="dom767_review_form_wrap">
          <div class="dom767_review_and_rating_wrap">
            <form id="dom767_review_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="dom767_review_form">
              <div class="review-form-element card">
                <h4 class="live_a_review_text_h4"> Leave a Review </h4>
                <input type="hidden" name="review_post_id" id="review_post_id" value="<?php echo $post_id  ?>" >
              	<label class="hide" for="review">Message</label>
              	<textarea id="review_text_area" class="review-input-fields" placeholder="Write your Review" name="review" cols="40" rows="10"></textarea>
                <div class="review_form_rating_star_wrap"> 
                  <h4 class="rating-heading">Rate us</h4>
                  <fieldset class="dom767-rating"> 
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label class="full" for="star5" title="Awesome - 5 stars"></label> 

                    <input type="radio" id="star4half" name="rating" value="4.5" />
                    <label class="half" for="star4half" title="VERY GOOD - 4.5 stars"></label> 

                    <input type="radio" id="star4" name="rating" value="4" /><label class="full" for="star4" title="VERY GOOD - 4 stars"></label> 

                    <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="OK - 3.5 stars"></label> 

                    <input type="radio" id="star3" name="rating" value="3" /><label class="full" for="star3" title="OK - 3 stars"></label> 

                    <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="BAD - 2.5 stars"></label> 

                    <input type="radio" id="star2" name="rating" value="2" /><label class="full" for="star2" title="BAD - 2 stars"></label> 

                    <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="BAD - 1.5 stars"></label> 

                    <input type="radio" id="star1" name="rating" value="1" /><label class="full" for="star1" title="VERY BAD - 1 star"></label> 

                    <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="VERY BAD - 0.5 stars"></label> 
                  </fieldset>
                  <div class="dom767_myratings_wraps" style="display: none">
                    <h4 class="rating-heading">Your Rating Value is : </h4>
                    <span class="dom767_myratings">00</span>
                  </div>

                  <div class="media_form_show_hide_btn">
                     <i class="fas fa-image"></i>
                  </div>
                </div>

              </div>
              <input name="submit" class="form-submit-button"  type="submit" id="dom767-submit-review" value="submit" style="display: none">
            </form>
          </div>
          <div class="dom767_review_media_upload_wrap">
            <form id="dom767_review_image_formId" method="post" enctype="multipart/form-data" autocomplete="off" >
              <input type="file" name="file[]" id="dom767_review_file" multiple />
              <h2 class="drag_and_drop_text">Drag your images here or click in this area.</h2>
              <input name="security" value="<?php echo wp_create_nonce("uploadingFile"); ?>" type="hidden">
              <input name="action" value="review_upload_file_callback" type="hidden"/>
              <input name="submit" value="upload" type="submit" id="dom767-submit-img" style="display: none" />
              <h4>Image Type png, jpeg, jpg only</h4>
            </form>
            <div class="dom767_show_upload_img">
            </div>
            <div class="review_media_upload_loading_img">
              <img src="<?php echo DOM767_RIV_ASSETS_PUBLIC_DIR ?>/image/llF5iyg.gif" alt="" style=" " >
              <p>Media is Uploading...</p>
            </div>
          </div>
          <div class="dom767_review_form_submit_btn_wrap">
            <button type="button" class="btn btn-success" id="dom767_review_form_submit_btn">Leave Your Review</button>
          </div>
        </div>
      <?php
      }/// end if did user review
      ?>

    </div> 

    <div class="review_list_wrap_main" id="review_list_wrap_main" >
      <?php echo review_list_template($post_id); ?>
    </div>
  </div>

  <?php
  return;

}


/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// review form submit by ajax ///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_dom767_review_form_submit', 'dom767_review_form_submit' );
add_action( 'wp_ajax_nopriv_dom767_review_form_submit', 'dom767_review_form_submit' );

function dom767_review_form_submit() {

  ob_start();
  global $wpdb , $post;

  $form_datas   = isset( $_POST['form_data'] ) ? $_POST['form_data'] : '';///get form data
  $post_id      = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';///get post id
  $post_id      = (int)$post_id;
  $user_id      = get_current_user_id(); /// loged in user ID

  $form_data_arr = array();
  foreach ($form_datas as $form_data) {
    $form_data_arr[$form_data['name']] = $form_data['value'];
  }

  //echo $post_id;

  if($form_data_arr) {
    if(empty($form_data_arr['review'])) {
      echo "<h1>Write your review</h1>";
    }elseif(empty($form_data_arr['rating'])){
      echo "<h1>Rate your review</h1>";
    }else {

      if (isset($_SERVER['HTTP_CLIENT_IP'])){
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      }else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])){
          $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
      }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      }else if(isset($_SERVER['HTTP_FORWARDED'])){
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
      }else if(isset($_SERVER['REMOTE_ADDR'])){
          $ipaddress = $_SERVER['REMOTE_ADDR'];
      }else{
          $ipaddress = 'UNKNOWN';
      }

      $current_user = wp_get_current_user();
      $display_name = $current_user->display_name;
      $user_email   = $current_user->user_email ;
      $user_url     = $current_user->user_url ;

      $lastid = $wpdb->get_results('SELECT review_ID FROM wp_dom767_reviews ORDER BY review_ID DESC LIMIT 1');
      $lastid = ($lastid)? $lastid[0]->review_ID : 0 ;
      $lastid = $lastid + 1;

      $data=array(
        'review_ID'           => $lastid, 
        'review_post_ID'      => $post_id,
        'review_author'       => $display_name, 
        'review_author_email' => $user_email,
        'review_author_url'   => $user_url, 
        'review_author_IP'    => $ipaddress, 
        'review_date'         => date("y-m-d h:i:s"), 
        'review_date_gmt'     => date("y-m-d h:i:s"), 
        'review_content'      => $form_data_arr['review'], 
        'review_karma'        => 0, 
        'review_rating'       => $form_data_arr['rating'], 
        'review_approved'     => 1, 
        'review_agent'        => $_SERVER['HTTP_USER_AGENT'], 
        'review_type'         => 'review',
        'review_parent'       => 0, 
        'user_id'             => get_current_user_id() 
      );

      $tablename = $wpdb->prefix.'dom767_reviews';
      if ($wpdb->insert( $tablename, $data)) {

        $lastid = $wpdb->insert_id;///insert id
        $uploaded_review_image = isset( $_COOKIE['uploaded_review_image'] ) ? $_COOKIE['uploaded_review_image'] : '';
        //$uploaded_review_image  = explode(",",$uploaded_review_image);///string to array
        if ($uploaded_review_image != '') {
          $data=array(
            'review_id'   => $lastid,
            'meta_key'    => 'dom767_review_uploads', 
            'meta_value'  => $uploaded_review_image,
          );
          $tablename = $wpdb->prefix.'dom767_review_meta';
          $wpdb->insert( $tablename, $data);
        }//end if has img cookie

      }///end if insert
    }
  }///end if

  /////////////////////////////////////////////////////////////////////////////

  echo review_list_template($post_id);

  /////////////////////////////////////////////////////////////////////////////



  $review_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0');
  $total_review = count($review_query);

  $sum = 0;
  foreach ($review_query as  $rating) {
    $rating_val = (float)$rating->review_rating;
    $sum = $sum + $rating_val;
  }
  $total_rating = count($review_query) != 0 ? $sum / count($review_query): 0;
  $total_rating = round($total_rating, 2);

  //wp_reset_query();
  $output = array();
  $output['data'] = ob_get_clean();
  $output['total_review']  = $total_review;
  $output['total_rating']  = $total_rating;
  //$output['total_pages'] = $total_pages;
  echo json_encode($output);
  wp_die();

}
/******************************************END*****************************************/


/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// review reply form open by ajax //////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
/////////// we are not using this functions becouse of ajax loading time ////////////////

add_action( 'wp_ajax_dom767_reply_form_open', 'dom767_reply_form_open' );
add_action( 'wp_ajax_nopriv_dom767_reply_form_open', 'dom767_reply_form_open' );

function dom767_reply_form_open() {

  ob_start();
  global $wpdb , $post;

  $post_id      = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';///get post id
  $review_ID    = isset( $_POST['review_id'] ) ? $_POST['review_id'] : '';///get form data
  $post_id      = (int)$post_id;
  $review_ID    = (int)$review_id;
  $user_id      = get_current_user_id(); /// loged in user ID

  echo get_reply_form_wrap($post_id, $review_ID);

  //wp_reset_query();
  $output = array();
  $output['data'] = ob_get_clean();
  //$output['total_review']  = $total_review;
  //$output['total_rating']  = $total_rating;
  //$output['total_pages'] = $total_pages;
  echo json_encode($output);
  wp_die();

}
/******************************************END*****************************************/



/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// edit form submit by ajax ///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_dom767_edit_form_submit', 'dom767_edit_form_submit' );
add_action( 'wp_ajax_nopriv_dom767_edit_form_submit', 'dom767_edit_form_submit' );

function dom767_edit_form_submit() {

  ob_start();
  global $wpdb , $post;

  $form_datas   = isset( $_POST['form_data'] ) ? $_POST['form_data'] : '';///get form data
  $post_id      = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';///get post id
  $post_id      = (int)$post_id;
  $user_id      = get_current_user_id(); /// loged in user ID

  $form_data_arr = array();
  foreach ($form_datas as $form_data) {
    $form_data_arr[$form_data['name']] = $form_data['value'];
  }
  //print_r($form_data_arr);
  $edit_review_id = (int)$form_data_arr['edit_review_id'];
  

  if($form_data_arr) {
    if(empty($form_data_arr['review'])) {
      echo "<h1>Write your review</h1>";
    }else {

      if (isset($_SERVER['HTTP_CLIENT_IP'])){
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      }else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])){
          $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
      }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      }else if(isset($_SERVER['HTTP_FORWARDED'])){
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
      }else if(isset($_SERVER['REMOTE_ADDR'])){
          $ipaddress = $_SERVER['REMOTE_ADDR'];
      }else{
          $ipaddress = 'UNKNOWN';
      }


      $data=array( 
        'review_author_IP'    => $ipaddress, 
        'review_date'         => date("y-m-d h:i:s"), 
        'review_date_gmt'     => date("y-m-d h:i:s"), 
        'review_content'      => $form_data_arr['review'], 
        'review_agent'        => $_SERVER['HTTP_USER_AGENT'], 
      );

      $where = array('review_ID' => $edit_review_id );
      $tablename = $wpdb->prefix.'dom767_reviews';
      $wpdb->update( $tablename, $data, $where);
     //wp_redirect( get_permalink(), 303 );
    }
  }///end if

  /////////////////////////////////////////////////////////////////////////////

  echo review_list_template($post_id);

  /////////////////////////////////////////////////////////////////////////////


  //wp_reset_query();
  $output = array();
  $output['data'] = ob_get_clean();
  echo json_encode($output);
  wp_die();

}
/******************************************END*****************************************/



/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// reply form submit by ajax ///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_dom767_reply_form_submit', 'dom767_reply_form_submit' );
add_action( 'wp_ajax_nopriv_dom767_reply_form_submit', 'dom767_reply_form_submit' );

function dom767_reply_form_submit() {

  ob_start();
  global $wpdb , $post;

  $form_datas   = isset( $_POST['form_data'] ) ? $_POST['form_data'] : '';///get form data
  $post_id      = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';///get post id
  $post_id      = (int)$post_id;
  $user_id      = get_current_user_id(); /// loged in user ID

  $form_data_arr = array();
  foreach ($form_datas as $form_data) {
    $form_data_arr[$form_data['name']] = $form_data['value'];
  }
  //print_r($form_data_arr);
  $parent_id            = (int)$form_data_arr['review_parent_id'];
  $karma                = (int)$form_data_arr['review_karma'];
  $commentType          = is_comment_or_reply($parent_id);
  $reply_to_user_name   = get_replied_to_user_name($parent_id);
  

  if($form_data_arr) {
    if(empty($form_data_arr['review'])) {
      echo "<h1>Write your review</h1>";
    }else {

      if (isset($_SERVER['HTTP_CLIENT_IP'])){
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      }else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])){
          $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
      }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      }else if(isset($_SERVER['HTTP_FORWARDED'])){
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
      }else if(isset($_SERVER['REMOTE_ADDR'])){
          $ipaddress = $_SERVER['REMOTE_ADDR'];
      }else{
          $ipaddress = 'UNKNOWN';
      }

      $current_user = wp_get_current_user();
      $display_name = $current_user->display_name;
      $user_email  = $current_user->user_email ;
      $user_url   = $current_user->user_url ;

      $lastid     = $wpdb->get_results('SELECT review_ID FROM wp_dom767_reviews ORDER BY review_ID DESC LIMIT 1');
      $lastid = ($lastid)? $lastid[0]->review_ID : 0 ;
      $lastid = $lastid + 1;

      $data=array(
        'review_ID'           => $lastid, 
        'review_post_ID'      => $post_id,
        'review_author'       => $display_name, 
        'review_author_email' => $user_email,
        'review_author_url'   => $user_url, 
        'review_author_IP'    => $ipaddress, 
        'review_date'         => date("y-m-d h:i:s"), 
        'review_date_gmt'     => date("y-m-d h:i:s"), 
        'review_content'      => $form_data_arr['review'], 
        'review_karma'        => $karma, 
        'review_rating'       => 0, 
        'review_approved'     => 1, 
        'review_agent'        => $_SERVER['HTTP_USER_AGENT'], 
        'review_type'         => $commentType,
        'review_parent'       => $parent_id, 
        'user_id'             => get_current_user_id() 
      );

      //echo $display_name;
      //print_r($data);
      $tablename = $wpdb->prefix.'dom767_reviews';
      $wpdb->insert( $tablename, $data);
     //wp_redirect( get_permalink(), 303 );
    }
  }///end if

  /////////////////////////////////////////////////////////////////////////////

  echo review_list_template($post_id);

  /////////////////////////////////////////////////////////////////////////////
  $review_query = $wpdb->get_results('SELECT review_rating FROM wp_dom767_reviews WHERE review_post_ID ='.$post_id.' AND review_parent = 0');
  $total_review = count($review_query);

  $sum = 0;
  foreach ($review_query as  $rating) {
    $rating_val = (float)$rating->review_rating;
    $sum = $sum + $rating_val;
  }
  $total_rating = count($review_query) != 0 ? $sum / count($review_query): 0;
  $total_rating = round($total_rating, 2);

  //wp_reset_query();
  $output = array();
  $output['data'] = ob_get_clean();
  $output['total_review']  = $total_review;
  $output['total_rating']  = $total_rating;
  //$output['total_pages'] = $total_pages;
  echo json_encode($output);
  wp_die();

}
/******************************************END*****************************************/


/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// review vote like by ajax ////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_dom767_review_vote_like', 'dom767_review_vote_like' );
add_action( 'wp_ajax_nopriv_dom767_review_vote_like', 'dom767_review_vote_like' );

function dom767_review_vote_like() {

  ob_start();
  global $wpdb , $post;

  $vote_val     = isset( $_POST['vote_val'] ) ? $_POST['vote_val'] : '';
  $database     = isset( $_POST['database'] ) ? $_POST['database'] : '';
  $review_id    = isset( $_POST['review_id'] ) ? $_POST['review_id'] : '';
  $review_ID    = (int)$review_id;
  $user_id      = get_current_user_id(); /// loged in user ID


  //////////////////////// review meta query ///////////////////////////////

  $vote_query = $wpdb->get_results('SELECT * FROM wp_dom767_review_meta WHERE review_id ='.$review_ID.' AND meta_key = "dom_review_vote" ORDER BY review_ID DESC');

  $did_user_vote = 'false';
  if ($vote_query) {
    foreach ($vote_query as $vote_object) {
      $vote_arr = json_decode($vote_object->meta_value);

      if ($vote_arr->user == $user_id) {
        $meta_id = $vote_object->meta_id; ///meta id where user data is save
        $did_user_vote = 'true';
      }

    }///end foreach
  }///end if

  $vote_array   = array( 'vote' => $vote_val, 'user' => $user_id);
  $vote_json    = json_encode($vote_array);

  $data=array(
    'review_id'   => $review_ID,
    'meta_key'    => 'dom_review_vote', 
    'meta_value'  => $vote_json,
  );

  if ($database == 'insert') {

    $tablename = $wpdb->prefix.'dom767_review_meta';
    $wpdb->insert( $tablename, $data);

  }elseif($database == 'update'){

    $where = array('meta_id' => $meta_id );
    $tablename = $wpdb->prefix.'dom767_review_meta';
    $wpdb->update( $tablename, $data, $where );

  }elseif ($database == 'delete') {

    $where = array('meta_id' => $meta_id );
    $tablename = $wpdb->prefix.'dom767_review_meta';
    $wpdb->delete($tablename, $where);
    
  }
  


  /////////////////////////////////////////////////////////////////////////


  //wp_reset_query();
  $output = array();
  $output['data'] = ob_get_clean();
  //$output['total_review']  = $total_review;
  //$output['total_rating']  = $total_rating;
  //$output['total_pages'] = $total_pages;
  echo json_encode($output);
  wp_die();

}
/******************************************END*****************************************/


/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// review file upload by ajax ///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

// create hook for file uploading
add_action('wp_ajax_nopriv_review_upload_file_callback', 'dom767_review_upload_file_callback');
add_action( 'wp_ajax_review_upload_file_callback', 'dom767_review_upload_file_callback' );

function dom767_review_upload_file_callback(){

  ob_start();
  global $wpdb , $post;

  $lastid = $wpdb->get_results('SELECT review_ID FROM wp_dom767_reviews ORDER BY review_ID DESC LIMIT 1');




  $lastid           = ($lastid)? $lastid[0]->review_ID : 0 ;
  $lastid           = $lastid + 1;
  $user_id          = get_current_user_id();
  $countfiles       = count($_FILES["file"]["name"]);// Count total files
  $upload           = wp_upload_dir();// Upload directory
  $upload_location  = $upload['basedir'] .'/dom767_review_uploads/';
  $upload_url       = $upload['baseurl'] .'/dom767_review_uploads/';
  $files_path_arr   = array();// To store uploaded files path
  $files_path_url   = array();// To store uploaded files url
  $file_name_arr    = array();// To store uploaded files name
  $extension_arr    = array();// array for all file check extension true or false
  $all_file_name    = array();// To store selected all files name


  $ex_uploaded = isset( $_COOKIE['uploaded_review_image'] ) ? $_COOKIE['uploaded_review_image'] : NULL;
  if ($ex_uploaded) {
    $ex_img_arr  = explode(",",$ex_uploaded);///string to array
    $ex_uploaded_arr  = explode(",",$ex_uploaded);///string to array
    end($ex_uploaded_arr);
    $last_key       = key($ex_uploaded_arr); 
    //echo "last key = ". $last_key;
  }


  // Loop all files
  $i = 1;
  for($index = 0;$index < $countfiles;$index++){

    if(isset($_FILES["file"]["name"][$index]) && $_FILES["file"]["name"][$index] != ''){
        
      $filename = $_FILES["file"]["name"][$index];// File name
      $roa_name = $filename;// File name
      $filename = preg_replace('/\s+/', '-', $filename);
      $filename = preg_replace('/[^A-Za-z0-9.\-]/', '', $filename);


      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));// Get extension
      $valid_ext = array("png","jpeg","jpg");// Valid image extension

      $start = ($ex_uploaded)? $last_key + $i : $index;
      $temp = explode(".", $_FILES["file"]["name"][$index]);
      $filename = $lastid.'_'.$start. '.' . end($temp);
      $extension = 'false';

      //var_dump($filename);

      if(in_array($ext, $valid_ext)){// Check extension
        $extension = 'true';
        $path = $upload_location.$filename;// File path
        $url = $upload_url.$filename;


         // Upload file
        if(move_uploaded_file($_FILES["file"]["tmp_name"][$index],$path)){
          $files_path_arr[] = $path;
          $files_path_url[] = $url;
          $file_name_arr[]  = $filename;
        }
      }else{
        $extension = 'false';
      }///end if extension wrong

      $extension_arr[] = $extension;
      $all_file_name[] = $roa_name;
    }
    $i ++;
  }///end for loop


  if ($ex_uploaded_arr) {
    foreach ($ex_uploaded_arr as $value_name) {
      $file_name_arr[]  = $value_name;
      $files_path_url[] = $upload_url.$value_name;
      $files_path_arr[] = $upload_location.$value_name;
      $extension_arr[]  = 'true';
      $all_file_name[]  = $value_name;
    }
  }
  //var_dump($file_name_arr);

  ?>
  <div class="review_upload_file_wrap">
  <?php
  foreach ($files_path_url as $key => $file_url) {
    ?>
    <div class="review_uploaded_file_single">
      <div class="review_uploaded_file_overlay">
        <span class="uploaded_file_delete_icon" data-path="<?php echo $files_path_arr[$key] ?>" data-image-name="<?php echo $file_name_arr[$key] ?>">
          <img src="<?php echo DOM767_RIV_ASSETS_PUBLIC_DIR.'/image/llF5iyg.gif' ?>" alt="" style="display: none ; width: 30px; height: 30px" >
          <i class="fas fa-trash-alt"></i>
        </span>
      </div>
      <img src="<?php echo $file_url ?>" alt="" style=" height: 100px; width: 100px; ">
    </div>
    <?php
  }
  ?>
  </div>
  <?php


  foreach ($all_file_name as $key => $value) {
    if ($extension_arr[$key] == 'false') {
      $exten = strtolower(pathinfo($value, PATHINFO_EXTENSION));// Get extension
      $atart_text = $value. " file was not uploaded, because we don't accept '.".$exten . "' file";
      ?>
      <div class="dom767-file-exte-alert-danger" role="alert">
        <span class="file-exte-alert-danger-text">
          <strong><?php echo $value ?> </strong> file was not uploaded, because we don't accept <strong><?php echo '".'.$exten .'"'?> </strong> file.
        </span>
        <i class="far fa-times-circle review_alert_close"></i>
      </div>
      <?php
    }//end if
  }
  //$file_name_arr = json_encode($file_name_arr);

  //wp_reset_query();
  $output = array();
  $output['data'] = ob_get_clean();
  $output['file_name_arr'] = $file_name_arr;
  echo json_encode($output);
  wp_die();

}
/******************************************END*****************************************/



/////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// on reload remove uploaded img by ajax /////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

// create hook for file uploading
add_action('wp_ajax_nopriv_onload_remove_uploaded_img', 'dom767_onload_remove_uploaded_img');
add_action( 'wp_ajax_onload_remove_uploaded_img', 'dom767_onload_remove_uploaded_img' );

function dom767_onload_remove_uploaded_img(){

  ob_start();
  
  global $wpdb , $post;
  $upload           = wp_upload_dir();// Upload directory
  $upload_location  = $upload['basedir'] .'/dom767_review_uploads/';
  $upload_url       = $upload['baseurl'] .'/dom767_review_uploads/';

  $uploaded_image_name = isset( $_COOKIE['uploaded_review_image'] ) ? $_COOKIE['uploaded_review_image'] : '';
  $uploaded_image_name  = explode(",",$uploaded_image_name);///string to array

  foreach ($uploaded_image_name as $image_name) {
    $file_to_delete = $upload_location.$image_name;
    unlink($file_to_delete);
  }


  //$file_name_arr = json_encode($file_name_arr);

  //wp_reset_query();
  $output = array();
  $output['data'] = ob_get_clean();
  echo json_encode($output);
  wp_die();

}
/******************************************END*****************************************/


/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// remove review extra file by ajax ///////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

// create hook for file uploading
add_action('wp_ajax_nopriv_review_extra_file_remove', 'dom767_review_extra_file_remove');
add_action( 'wp_ajax_review_extra_file_remove', 'dom767_review_extra_file_remove' );

function dom767_review_extra_file_remove(){
  ob_start();
  $path = isset( $_POST['path'] ) ? $_POST['path'] : '';
  $img_name = isset( $_POST['img_name'] ) ? $_POST['img_name'] : '';
  $new_name_arr = array();

  if (unlink($path)) {
    $uploaded_review_image = isset( $_COOKIE['uploaded_review_image'] ) ? $_COOKIE['uploaded_review_image'] : '';
    $name_array  = explode(",",$uploaded_review_image);///string to array

    foreach ($name_array as $value) {
      if ($value != $img_name) {
        $new_name_arr[] = $value;
      }
    }

  }else{
  }
  //unlink($path);
  //$new_name_arr = json_encode($new_name_arr);
  //var_dump($new_name_arr);

  $output = array();
  $output['data'] = ob_get_clean();
  $output['new_name_arr'] = $new_name_arr;
  echo json_encode($output);
  wp_die();
  
}
/******************************************END*****************************************/

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// review load more by ajax ////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////


add_action('wp_ajax_nopriv_review_load_more', 'dom767_review_load_more');
add_action( 'wp_ajax_review_load_more', 'dom767_review_load_more' );

function dom767_review_load_more(){
  ob_start();
  global $wpdb, $post;

  $current_user_id = get_current_user_id();
  $upload_dir      = wp_upload_dir();// Upload directory
  $upload_location = $upload_dir['basedir'] .'/dom767_review_uploads/';
  $upload_url      = $upload_dir['baseurl'] .'/dom767_review_uploads/';
  $post_id         = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';
  $post_id         = (int)$post_id;
  $total_page      = isset( $_POST['total_page'] ) ? $_POST['total_page'] : 1;
  $page            = isset( $_POST['page'] ) ? $_POST['page'] : 1;
  $review_query    = get_review($post_id);


  if ($review_query) {

    $limit          = 5;
    $total_item     = count($review_query);
    $total_pages    = ceil($total_item/$limit); 
    $current_page   = $page;
    $current_page   = ( $total_item > 0 ) ? min( $total_pages, $current_page ) : 1;
    $start          = (int)$current_page * $limit - $limit;
    $review_query   = array_slice( $review_query, $start, $limit ); 

    foreach ($review_query as $query_data) {

      $review_ID            = $query_data['review_ID'];
      $review_post_ID       = $query_data['review_post_ID'];
      $review_author        = $query_data['review_author'];
      $review_author_email  = $query_data['review_author_email'];
      $review_author_url    = $query_data['review_author_url'];
      $review_author_IP     = $query_data['review_author_IP'];
      $review_date          = $query_data['review_date'];
      $review_date_gmt      = $query_data['review_date_gmt'];
      $review_content       = $query_data['review_content'];
      $review_rating        = $query_data['review_rating'];
      $review_karma         = $query_data['review_karma'];
      $review_approved      = $query_data['review_approved'];
      $review_agent         = $query_data['review_agent'];
      $review_type          = $query_data['review_type'];
      $review_parent        = $query_data['review_parent'];
      $user_id              = $query_data['user_id'];
      $karma                = ($review_parent == 0)? $review_ID : $review_karma;

      //////////////////////// review meta query ///////////////////////////////

      $media_query = $wpdb->get_results('SELECT meta_value FROM wp_dom767_review_meta WHERE review_id ='.$review_ID.' AND meta_key = "dom767_review_uploads" ORDER BY review_ID DESC');

      $media_name_array = $media_query[0]->meta_value;
      $media_name_array  = explode(",",$media_name_array);///string to array

      $vote_query = $wpdb->get_results('SELECT * FROM wp_dom767_review_meta WHERE review_id ='.$review_ID.' AND meta_key = "dom_review_vote" ORDER BY review_ID DESC');
      
      $total_like = 0;
      $total_dislike = 0;
      $did_user_vote = 'false';
      if ($vote_query) {
        foreach ($vote_query as $vote_object) {
          $vote_arr = json_decode($vote_object->meta_value);
          $current_user = get_current_user_id();
          if ($vote_arr->user == $current_user) {
            $meta_id = $vote_object->meta_id;
            $did_user_vote = 'true';
            $user_vote_val = $vote_arr->vote;
          }
          if ($vote_arr->vote == "like") {
            $total_like ++;
          }
          if ($vote_arr->vote == "dislike") {
            $total_dislike ++;
          }
        }///end foreach
      }///end if
      /////////////////////////////////////////////////////////////////////////
      ?>

      <?php if ($review_parent == 0): ?>
        <div class="review_card reviewer-single-info">
          <div class="single-rev-avater">
            <div class="reviewer-avater">
              <?php echo get_avatar( $user_id ); ?>
            </div>
          </div>
          <div class="reviewer-single-info-data">
            <div class="display-inline-block">
              <div class="reviewer-name">
                <p class="reviewer-fullname"><?php echo $review_author ?></p>
              </div>
              <?php echo get_single_user_post_star_rating($review_ID, $user_id, $review_post_ID) ?>
              
            </div>
            <div class="review_date_div">
              <p class="review-date-text"> <?php echo $review_date ?></p>
            </div>
            <div class="review-content-div">
              <div class="review-content">
                <p class="review-content-text"><?php echo $review_content ?></p>
              </div>
            </div>
            <?php if ($media_query): ?>
              <?php foreach ($media_name_array as $media_name): ?>
                <img src="<?php echo $upload_url.$media_name ?>" alt="" style="height: 100px; width: 100px;" >
              <?php endforeach ?>
            <?php endif ?>
            <ul class="list-inline d-sm-flex my-0">
              <li class="list-inline-item g-mr-20">
                <span class="dom767_review_like_dislike" id="review_like_button_<?php echo $review_ID ?>" data-value="like" data-did_vote="<?php echo $did_user_vote ?>" data-vote_val="<?php echo $user_vote_val ?>" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                  <i class="fa fa-thumbs-up"></i>
                  <bdi><?php echo $total_like ?></bdi>
                </span>
              </li>
              <li class="list-inline-item g-mr-20">
                <span class="dom767_review_like_dislike" id="review_dislike_button_<?php echo $review_ID ?>" data-value="dislike" data-did_vote="<?php echo $did_user_vote ?>" data-vote_val="<?php echo $user_vote_val ?>" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                  <i class="fa fa-thumbs-down"></i>
                  <bdi><?php echo $total_dislike ?></bdi>
                </span>
              </li>
              <li class="list-inline-item ml-auto">
                <span class="dom767_review_reply_button" id="dom767_review_reply_button" data-parent_ID="<?php echo $review_ID ?>" data-karma="<?php echo $karma ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                  <i class="fa fa-reply"></i>
                  Reply
                </span>
              </li>
              <?php if ($user_id == $current_user_id  ): ?>
              <li class="list-inline-item ml-auto">
                <span class="dom767_review_edit_button" id="dom767_review_edit_button" data-review_ID="<?php echo $review_ID ?>" data-post_id="<?php echo $post_id ?>" data-user_id="<?php echo get_current_user_id() ?>" >
                  <i class="fa fa-edit"></i>
                  Edit
                </span>
              </li>
              <?php endif ?>
            </ul>
          </div>
        </div>
        <?php
        $reply_count = get_review_reply_count($post_id, $review_ID);
        ?>
        <div class="dom767_review_reply_main_wrap" id="review_reply_main_wrap_<?php echo $review_ID?>" style="margin-left: 50px">
        <?php echo get_review_reply($post_id, $review_ID); ?>
        </div>
      <?php endif ?><!-- end if review parent = 0 -->

      <?php
    }///end foreach
  }///end if



  $output = array();
  $output['data'] = ob_get_clean();
  //$output['new_name_arr'] = $new_name_arr;
  echo json_encode($output);
  wp_die();
  
}
/******************************************END*****************************************/