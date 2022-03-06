<?php


function admin_review_order_desc($a, $b) {
    if ($a['review_date'] == $b['review_date']) return 0;
    return ($a['review_date'] > $b['review_date']) ? -1 : 1;
}
////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// Post total review query for admin //////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function get_total_review(){
    global $wpdb;

    $review_query = $wpdb->get_results('SELECT * FROM wp_dom767_reviews WHERE review_parent = 0 ORDER BY review_ID DESC');

    $review_query_arr = array();

    foreach ($review_query as $query_data) {

      $review_query_data_arr[]  = array(
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


    return $review_query_data_arr;
}


////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// Post total review query for admin //////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function get_review_comment($review_ID){
    global $wpdb;

    $review_query = $wpdb->get_results('SELECT * FROM wp_dom767_reviews WHERE review_parent ='.$review_ID.' ORDER BY review_ID DESC');

    $review_query_arr = array();

    foreach ($review_query as $query_data) {

      $review_query_data_arr[]  = array(
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


    return $review_query_data_arr;
}

/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////// admin review query loadmore by ajax //////////////////////////
////////////////////////////////////////////off//////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_admin_all_review_post_loadmore', 'admin_all_review_post_loadmore' );
add_action( 'wp_ajax_nopriv_admin_all_review_post_loadmore', 'admin_all_review_post_loadmore' );

function admin_all_review_post_loadmore() {

    ob_start();
    if(is_user_logged_in()){
        $user_id            = get_current_user_id();
        $review_post_query  = get_total_review(); 

        usort($review_post_query, "admin_review_order_desc");  
        
        if ($review_post_query){

            $limit          = 20;
            $total_item     = count($review_post_query);
            $total_pages    = ceil($total_item/$limit);  
            $current_page   = isset( $_POST['current_page'] ) ? $_POST['current_page'] : 1;
            $current_page   = ( $total_item > 0 ) ? min( $total_pages, $current_page ) : 1;
            $start          = (int)$current_page * $limit - $limit;
            $review_post_query = array_slice( $review_post_query, $start, $limit ); 

            ?>
            <tr>
              <th>Review Id</th>
              <th>Post Id</th>
              <th>Review Date</th>
              <th>Review Author</th>
              <th>Rating</th>
              <th>Review Content</th>
              <th>Action</th>
            </tr>
            <?php
            foreach ($review_post_query as $review_post){
                $review_ID           = $review_post['review_ID'];
                $review_post_ID      = $review_post['review_post_ID'];
                $review_author       = $review_post['review_author'];
                $review_author_email = $review_post['review_author_email'];
                $review_author_url   = $review_post['review_author_url'];
                $review_author_IP    = $review_post['review_author_IP'];
                $review_date         = $review_post['review_date'];
                $review_date_gmt     = $review_post['review_date_gmt'];
                $review_content      = $review_post['review_content'];
                $review_rating       = $review_post['review_rating'];
                $review_karma        = $review_post['review_karma'];
                $review_approved     = $review_post['review_approved'];
                $review_agent        = $review_post['review_agent'];
                $review_type         = $review_post['review_type'];
                $review_parent       = $review_post['review_parent'];
                $user_id             = $review_post['user_id'];
                ?>

                <tr id="review-<?php echo esc_attr($post_id); ?>" class="reviews-list-item">
                  <td class="t-f-c-td"><?php echo $review_ID ?></td>
                  <td class="t-f-c-td"><?php echo $review_post_ID ?></td>
                  <td class="t-f-c-td"><?php echo _time_ago($review_date) ?></td>
                  <td class="t-f-c-td"><?php echo $review_author ?></td>
                  <td class="t-f-c-td"><?php echo $review_rating ?></td>
                  <td class="t-f-c-td"><?php echo $review_content ?></td>
                  <td class="t-f-c-td">Delete</td>
                </tr>

            <?php 
            }///end foreach
        }else{/// if no post found 
        ?>
        <h4 class="no-note-xl">No reviewourites Found</h4>
        <?php 
        } 
    }


    $output = array();
    $output['data'] = ob_get_clean();
    $output['total_posts'] = $total_item;
    $output['total_pages'] = $total_pages;

    echo json_encode($output);
    wp_die();

}



/////////////////////////////////////////////////////////////////////////////////////////
////////////////////// admin review pre post query loadmore by ajax /////////////////////
///////////////////////////////////////////off///////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_admin_pre_review_post_loadmore', 'admin_pre_review_post_loadmore' );
add_action( 'wp_ajax_nopriv_admin_pre_review_post_loadmore', 'admin_pre_review_post_loadmore' );

function admin_pre_review_post_loadmore() {

    ob_start();
    if(is_user_logged_in()){
        $user_id        = get_current_user_id();
        $review_post_query = get_total_review(); 
        usort($review_post_query, "admin_review_order_desc");  
        
        if ($review_post_query){

            $limit          = 20;
            $total_item     = count($review_post_query);
            $total_pages    = ceil($total_item/$limit);  
            $current_page   = isset( $_POST['current_page'] ) ? $_POST['current_page'] : 1;
            $current_page   = ( $total_item > 0 ) ? min( $total_pages, $current_page ) : 1;
            $current_page   = ( $current_page > 1 ) ? $current_page - 1 : 1;
            $start          = (int)$current_page * $limit - $limit;
            $review_post_query = array_slice( $review_post_query, $start, $limit ); 

            ?>
            <tr>
              <th>Review Id</th>
              <th>Post Id</th>
              <th>Review Date</th>
              <th>Review Author</th>
              <th>Rating</th>
              <th>Review Content</th>
              <th>Action</th>
            </tr>
            <?php
            foreach ($review_post_query as $review_post){
                $review_ID           = $review_post['review_ID'];
                $review_post_ID      = $review_post['review_post_ID'];
                $review_author       = $review_post['review_author'];
                $review_author_email = $review_post['review_author_email'];
                $review_author_url   = $review_post['review_author_url'];
                $review_author_IP    = $review_post['review_author_IP'];
                $review_date         = $review_post['review_date'];
                $review_date_gmt     = $review_post['review_date_gmt'];
                $review_content      = $review_post['review_content'];
                $review_rating       = $review_post['review_rating'];
                $review_karma        = $review_post['review_karma'];
                $review_approved     = $review_post['review_approved'];
                $review_agent        = $review_post['review_agent'];
                $review_type         = $review_post['review_type'];
                $review_parent       = $review_post['review_parent'];
                $user_id             = $review_post['user_id'];
                ?>

                <tr id="review-<?php echo esc_attr($post_id); ?>" class="reviews-list-item">
                  <td class="t-f-c-td"><?php echo $review_ID ?></td>
                  <td class="t-f-c-td"><?php echo $review_post_ID ?></td>
                  <td class="t-f-c-td"><?php echo _time_ago($review_date) ?></td>
                  <td class="t-f-c-td"><?php echo $review_author ?></td>
                  <td class="t-f-c-td"><?php echo $review_rating ?></td>
                  <td class="t-f-c-td"><?php echo $review_content ?></td>
                  <td class="t-f-c-td">Delete</td>
                </tr>

            <?php 
            }///end foreach
        }else{/// if no post found 
        ?>
        <h4 class="no-note-xl">No reviewourites Found</h4>
        <?php 
        } 
    }


    $output = array();
    $output['data'] = ob_get_clean();
    $output['total_posts'] = $total_item;
    $output['total_pages'] = $total_pages;
    $output['current_page'] = $current_page;

    echo json_encode($output);
    wp_die();

}



/////////////////////////////////////////////////////////////////////////////////////////
////////////////////// admin review next post query loadmore by ajax ////////////////////
//////////////////////////////////////////off////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_admin_next_review_post_loadmore', 'admin_next_review_post_loadmore' );
add_action( 'wp_ajax_nopriv_admin_next_review_post_loadmore', 'admin_next_review_post_loadmore' );

function admin_next_review_post_loadmore() {

    ob_start();
    if(is_user_logged_in()){
        $user_id        = get_current_user_id();
        $review_post_query = get_total_review(); 
        usort($review_post_query, "admin_review_order_desc");  
        
        if ($review_post_query){

            $limit          = 20;
            $total_item     = count($review_post_query);
            $total_pages    = ceil($total_item/$limit);  
            $current_page   = isset( $_POST['current_page'] ) ? $_POST['current_page'] : 1;
            $current_page   = ( $total_item > 0 ) ? min( $total_pages, $current_page ) : 1;
            $current_page   = ( $current_page < $total_pages ) ? $current_page + 1 : 1;
            $current_page   = ( $current_page == $total_pages ) ? $total_pages : $current_page;
            $start          = (int)$current_page * $limit - $limit;
            $review_post_query = array_slice( $review_post_query, $start, $limit ); 

            ?>
            <tr>
              <th>Review Id</th>
              <th>Post Id</th>
              <th>Review Date</th>
              <th>Review Author</th>
              <th>Rating</th>
              <th>Review Content</th>
              <th>Action</th>
            </tr>
            <?php
            foreach ($review_post_query as $review_post){
                $review_ID           = $review_post['review_ID'];
                $review_post_ID      = $review_post['review_post_ID'];
                $review_author       = $review_post['review_author'];
                $review_author_email = $review_post['review_author_email'];
                $review_author_url   = $review_post['review_author_url'];
                $review_author_IP    = $review_post['review_author_IP'];
                $review_date         = $review_post['review_date'];
                $review_date_gmt     = $review_post['review_date_gmt'];
                $review_content      = $review_post['review_content'];
                $review_rating       = $review_post['review_rating'];
                $review_karma        = $review_post['review_karma'];
                $review_approved     = $review_post['review_approved'];
                $review_agent        = $review_post['review_agent'];
                $review_type         = $review_post['review_type'];
                $review_parent       = $review_post['review_parent'];
                $user_id             = $review_post['user_id'];
                ?>

                <tr id="review-<?php echo esc_attr($post_id); ?>" class="reviews-list-item">
                  <td class="t-f-c-td"><?php echo $review_ID ?></td>
                  <td class="t-f-c-td"><?php echo $review_post_ID ?></td>
                  <td class="t-f-c-td"><?php echo _time_ago($review_date) ?></td>
                  <td class="t-f-c-td"><?php echo $review_author ?></td>
                  <td class="t-f-c-td"><?php echo $review_rating ?></td>
                  <td class="t-f-c-td"><?php echo $review_content ?></td>
                  <td class="t-f-c-td">Delete</td>
                </tr>

            <?php 
            }///end foreach
        }else{/// if no post found 
        ?>
        <h4 class="no-note-xl">No reviewourites Found</h4>
        <?php 
        } 
    }


    $output = array();
    $output['data'] = ob_get_clean();
    $output['total_posts'] = $total_item;
    $output['total_pages'] = $total_pages;
    $output['current_page'] = $current_page;

    echo json_encode($output);
    wp_die();

}



/////////////////////////////////////////////////////////////////////////////////////////
////////////////////// review admin pagination num count 20 by ajax /////////////////////
/////////////////////////////////////////off/////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_review_admin_pagi_num_count_20', 'review_admin_pagi_num_count_20' );
add_action( 'wp_ajax_nopriv_review_admin_pagi_num_count_20', 'review_admin_pagi_num_count_20' );

function review_admin_pagi_num_count_20() {

    ob_start();

        
    $current_page = isset( $_POST['current_page'] ) ? $_POST['current_page'] : 1; 
    $total_pages   = isset( $_POST['total_page'] ) ? $_POST['total_page'] : 1; 

    ?>
      <li class="review_admin_paginations_pre" data-total_page="<?php echo $total_pages ?>" data-page="1" > << </li>
        <?php

        $pre_num0   = ($current_page > 10) ? $current_page - 10: 1 ;
        $pre_num    = ($pre_num0 > 1)? $pre_num0 : 1;

        $next_num0  = $current_page + 10;
        $next_num   = ($next_num0 <= $total_pages)? $next_num0: $total_pages;

        $ls10 = ($current_page < 10)? 10 - $current_page : 0;
        $tnc = $total_pages - $current_page;
        $ad10 = ( $tnc < 10)? 10 - $tnc : 0;
        $next_num = $next_num + $ls10;
        $next_num = ($next_num < $total_pages) ? $next_num : $total_pages;
        $pre_num = ($pre_num > 10)?$pre_num - $ad10 : $pre_num;

        $pre_hide   = ($pre_num > 1 )? $pre_num - 1: 1;
        $next_hide  = ($next_num < $total_pages ) ? $next_num + 1: $total_pages;

        if ($pre_num > 1) {
          echo '<li class="review_admin_paginations" id="review_admin_paginations'.$pre_hide.'" data-total_page="'. $total_pages .'" data-page="'.$pre_hide.'" >'. '...'.'</li>';
        }

        for( $i = $pre_num; $i<= $next_num; $i++ ){
          echo '<li class="review_admin_paginations" id="review_admin_paginations'.$i.'" data-total_page="'. $total_pages .'" data-page="'.$i.'" >'. $i.'</li>';
        }

        if ($next_num < $total_pages) {
          echo '<li class="review_admin_paginations" id="review_admin_paginations'.$next_hide.'" data-total_page="'. $total_pages .'" data-page="'.$next_hide.'" >'. '...'.'</li>';
        }

        ?>
        <li class="review_admin_paginations_next" data-total_page="<?php echo $total_pages ?>" data-page="1" > >> </li>



    <?php

    $output = array();
    $output['data'] = ob_get_clean();
    $output['total_pages'] = $total_pages;
    $output['current_page'] = $current_page;

    echo json_encode($output);
    wp_die();

}


/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////// review or comment query for admin ////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
function bootstrapTableQuery(){
    global $wpdb;
    if(is_user_logged_in()){
        $upload           = wp_upload_dir();// Upload directory
        $upload_location  = $upload['basedir'] .'/dom767_review_uploads/';
        $upload_url       = $upload['baseurl'] .'/dom767_review_uploads/';
      $review_post_query  = get_total_review();
      if ($review_post_query) {
        $total_item     = count($review_post_query);
        $order_no       = 1;
      ?>
      <h3>Total <?php echo $total_item ?> review</h3>


        <!-- edit The Modal -->
        <div class="modal admin-review-edit-modal" id="dom767-admin-review-edit-modal">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Edit Review</h4>
                  <button type="button" class="close close_edit_modal" data-dismiss="modal">&times;</button>
                </div>
                <!-- edit Modal Header -->
                
                <!-- Modal body -->
                <div class="modal-body">
                  <form id="dom767_admin_review_edit_form" action="" method="post" class="dom767_admin_review_edit_form">
                        <input name="action" value="dom767_adminReviewEdit" type="hidden"/>
                        <input type="hidden" name="review_id" value="">
                        <input type="hidden" name="review_type" value="">
                        <label>Rating</label>
                        <input type="text" name="rating" value="">
                        <label>Text</label>
                        <textarea name="content" ></textarea>
                        <input type="submit" name="submit" id="dom767_admin_review_edit_form_submit" value="update" style="display: none">
                  </form>
                </div>
                <!-- edit Modal body -->
                
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal" id="admin_review_edit_form_update_btn" >Update</button>
                  <button type="button" class="btn btn-danger close_edit_modal" data-dismiss="modal">Close</button>
                </div>
                <!-- end Modal footer -->
                
              </div>
            </div>
        </div>

        <!-- image view modal -->
        <div class="modal admin-review-media-modal" id="dom767-admin-review-media-modal">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Media Name: <span class="mediaModalMediaName"></span></h4>
                  <button type="button" class="close close_media_modal" data-dismiss="modal">&times;</button>
                </div>
                <!-- media Modal Header -->
                
                <!-- Modal body -->
                <div class="modal-body">
                  <form id="dom767_admin_review_media_form" action="" method="post" class="dom767_admin_review_media_form">
                        <img src="" alt="" style="height: auto; max-width: 465px">
                        <input name="action" value="dom767_adminReviewMedia" type="hidden"/>
                        <input type="hidden" name="review_id" value="">
                        <input type="hidden" name="media-url" value="">
                        <input type="hidden" name="media-name" value="">
                        <input type="submit" name="submit" id="dom767_admin_review_media_form_submit" value="Delete" style="display: none">
                  </form>
                </div>
                <!-- edit Modal body -->
                
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal" id="admin_review_media_form_update_btn" >Delete</button>
                  <button type="button" class="btn btn-primary close_media_modal" data-dismiss="modal">Close</button>
                </div>
                <!-- end Modal footer -->
                
              </div>
            </div>
        </div>
        <!-- image view modal -->

      <table id="dom767_review_list_admin" class="table table-striped" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Type</th>
            <th>PID</th>
            <th>Review Date</th>
            <th>Review Author</th>
            <th>Rating</th>
            <th>Review Content</th>
            <th>Media</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php  
          foreach ($review_post_query as $review_post) {
            $review_ID           = $review_post['review_ID'];
            $review_post_ID      = $review_post['review_post_ID'];
            $review_author       = $review_post['review_author'];
            $review_author_email = $review_post['review_author_email'];
            $review_author_url   = $review_post['review_author_url'];
            $review_author_IP    = $review_post['review_author_IP'];
            $review_date         = $review_post['review_date'];
            $review_date_gmt     = $review_post['review_date_gmt'];
            $review_content      = $review_post['review_content'];
            $review_rating       = $review_post['review_rating'];
            $review_karma        = $review_post['review_karma'];
            $review_approved     = $review_post['review_approved'];
            $review_agent        = $review_post['review_agent'];
            $review_type         = $review_post['review_type'];
            $review_parent       = $review_post['review_parent'];
            $user_id             = $review_post['user_id'];

            $review_approved_btn = ($review_approved == 1)? 'Unaprove':'Aprove';
            $aproveBtnClass = ($review_approved == 1)? 'btn-warning':'btn-info';

            //////////////////////// review meta query ///////////////////////////////
            $review_meta_table = $wpdb->prefix . 'dom767_review_meta';
            $media_query = $wpdb->get_results('SELECT meta_value FROM '.$review_meta_table.' WHERE review_id ='.$review_ID.' AND meta_key = "dom767_review_uploads" ORDER BY review_ID DESC');

            $media_name_array = $media_query[0]->meta_value;
            $media_name_array = explode(",",$media_name_array);///string to array



            $comment_post_query  = get_review_comment($review_ID);
            //var_dump($comment_post_query);
            ?>
            <tr>
              <td><strong><?php echo $order_no ?></strong></td>
              <td><?php echo $review_type ?></td>
              <td><?php echo $review_post_ID ?></td>
              <td><?php echo date("F j, Y g:i a", $review_date) ?></td>
              <td><?php echo $review_author ?></td>
              <td><strong><?php echo $review_rating ?></strong></td>
              <td id="review_content_id_<?php echo $review_ID ?>"><?php echo $review_content ?></td>
              <td class="admin_review_media_td">
                <?php if ($media_query): ?>
                    <?php foreach ($media_name_array as $media_name): ?>
                    <div class="dom767_adminReviewMediaSingle">
                        <span class="dom767_adminReviewMedia" data-toggle="modal" data-target="#dom767-admin-review-media-modal" data-review-id="<?php echo $review_ID ?>" data-url="<?php echo $upload_url.$media_name ?>" data-name="<?php echo $media_name ?>" >
                        <i class="fas fa-eye adminReviewMediaViewIcon"></i>
                        </span>

                        <img src="<?php echo $upload_url.$media_name ?>" alt="" style="height: 40px; width: 40px;" >
                        
                    </div>
                    <?php endforeach ?>
                <?php endif ?>
              </td>
              <td data-review-id="<?php echo $review_ID ?>" data-review-type="<?php echo $review_type ?>">
                <button type="button" class="btn btn-primary dom767_adminReviewEdit" data-toggle="modal" data-target="#dom767-admin-review-edit-modal" >Edit</button>
                <?php if ($review_approved): ?>
                    
                <?php endif ?>
                <button type="button" class="btn <?php echo $aproveBtnClass ?> dom767_adminReviewAprove"><?php echo $review_approved_btn ?></button>
                <button type="button" class="btn btn-danger dom767_adminReviewdelete">Delete</button>
              </td>
            </tr>
            <?php
            if ($comment_post_query) {
              $order_no_c =1;
              foreach ($comment_post_query as $comment_post) {
                $comment_ID           = $comment_post['review_ID'];
                $comment_post_ID      = $comment_post['review_post_ID'];
                $comment_author       = $comment_post['review_author'];
                $comment_author_email = $comment_post['review_author_email'];
                $comment_author_url   = $comment_post['review_author_url'];
                $comment_author_IP    = $comment_post['review_author_IP'];
                $comment_date         = $comment_post['review_date'];
                $comment_date_gmt     = $comment_post['review_date_gmt'];
                $comment_content      = $comment_post['review_content'];
                $comment_rating       = $comment_post['review_rating'];
                $comment_karma        = $comment_post['review_karma'];
                $comment_approved     = $comment_post['review_approved'];
                $comment_agent        = $comment_post['review_agent'];
                $comment_type         = $comment_post['review_type'];
                $comment_parent       = $comment_post['review_parent'];
                $comment_user_id      = $comment_post['user_id'];
                $comment_approved_btn = ($comment_approved == 1)? 'Unaprove':'Aprove';
                $aproveBtnClass1 = ($comment_approved == 1)? 'btn-warning':'btn-info';

                //////////////////////// comment meta query ///////////////////////////////
                $media_query_c = $wpdb->get_results('SELECT meta_value FROM wp_dom767_review_meta WHERE review_id ='.$comment_ID.' AND meta_key = "dom767_review_uploads" ORDER BY review_ID DESC');

                $media_name_array_c = $media_query_c[0]->meta_value;
                $media_name_array_c  = explode(",",$media_name_array_c);///string to array
                ?>
                <tr>
                  <td><i class="far fa-comment-dots"></i> <?php echo $order_no_c ?></td>
                  <td><?php echo $comment_type ?></td>
                  <td><?php echo $comment_post_ID ?></td>
                  <td><?php echo date("F j, Y g:i a", $review_date) ?></td>
                  <td><?php echo $comment_author ?></td>
                  <td><i class="far fa-comment-dots"></i></td>
                  <td id="review_content_id_<?php echo $comment_ID ?>"><?php echo $comment_content ?></td>
                  <td class="admin_review_media_td">
                    <?php if ($media_query_c): ?>
                        <?php foreach ($media_name_array_c as $media_name): ?>
                        <div class="dom767_adminReviewMediaSingle">
                            <span class="dom767_adminReviewMedia" data-toggle="modal" data-target="#dom767-admin-review-media-modal" data-review-id="<?php echo $comment_ID ?>" data-url="<?php echo $upload_url.$media_name ?>" data-name="<?php echo $media_name ?>" >
                            <i class="fas fa-eye adminReviewMediaViewIcon"></i>
                            </span>

                            <img src="<?php echo $upload_url.$media_name ?>" alt="" style="height: 40px; width: 40px;" >
                            
                        </div>
                        <?php endforeach ?>
                    <?php endif ?>
                  </td>
                  <td data-review-id="<?php echo $comment_ID ?>" data-review-type="<?php echo $comment_type ?>">
                    <button type="button" class="btn btn-primary dom767_adminReviewEdit" data-toggle="modal" data-target="#dom767-admin-review-edit-modal" >Edit</button>
                    <button type="button" class="btn <?php echo $aproveBtnClass1 ?> dom767_adminReviewAprove"><?php echo $comment_approved_btn ?></button>
                    <button type="button" class="btn btn-danger dom767_adminReviewdelete">Delete</button>
                  </td>
                </tr>
                <?php
                $order_no_c++;
              }///end foreach
            }///end if comment
            $order_no++;
          }///end foreach
          ?>

        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Type</th>
            <th>PID</th>
            <th>Review Date</th>
            <th>Review Author</th>
            <th>Rating</th>
            <th>Review Content</th>
            <th>Media</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>

      <?php
      }// end if review 

    }///end if user login
}

/////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// delete review or comment for admin  //////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_dom767_adminReviewdelete', 'dom767_adminReviewdelete' );
add_action( 'wp_ajax_nopriv_dom767_adminReviewdelete', 'dom767_adminReviewdelete' );

function dom767_adminReviewdelete() {

  ob_start();
  global $wpdb;
      
  $review_id         = isset( $_POST['review_id'] ) ? $_POST['review_id'] : NULL; 
  $type              = isset( $_POST['type'] ) ? $_POST['type'] : NULL; 
  $upload            = wp_upload_dir();// Upload directory
  $upload_location   = $upload['basedir'] .'/dom767_review_uploads/';
  $upload_url        = $upload['baseurl'] .'/dom767_review_uploads/';
  $review_table      = $wpdb->prefix . 'dom767_reviews';
  $review_meta_table = $wpdb->prefix . 'dom767_review_meta';

  if ($review_id != NULL) {
    if ($type == 'review') { 
      
      /********************* delete review's comments and comments media, meta *******************/

      $comment_query = get_review_comment($review_id);///get all comment of this review
      foreach ($comment_query as $query_data) {///each comment of this review will be deleted
        
        $comment_ID = $query_data['review_ID'];
        $comment_media_query = $wpdb->get_results('SELECT meta_value FROM '.$review_meta_table.' WHERE review_id ='.$comment_ID.' AND meta_key = "dom767_review_uploads"');
        $comment_media_name_array = $comment_media_query[0]->meta_value;
        $comment_media_name_array = explode(",",$comment_media_name_array);

        $comment_where = [ 'review_ID' => $comment_ID ];
        if ($wpdb->delete($review_table, $comment_where)) { /// if comment delete

          foreach ($comment_media_name_array as $comment_image_name) {
            $file_to_delete = $upload_location.$comment_image_name;
            unlink($file_to_delete);
          }///end foreach

          $meta_where = [ 'review_id' => $comment_ID];
          $wpdb->delete($review_meta_table, $meta_where);///delete all meta of each comment
        }///end if comment delete
      }///end foreach

      /*******************************************************************************************/

      /************************** delete review and review media, meta ***************************/

      $review_media_query = $wpdb->get_results('SELECT meta_value FROM '.$review_meta_table.' WHERE review_id ='.$review_id.' AND meta_key = "dom767_review_uploads"');////get review media
      $review_media_name_array = $review_media_query[0]->meta_value;
      $review_media_name_array = explode(",",$review_media_name_array);

      $review_where = [ 'review_ID' => $review_id ];
      if ($wpdb->delete($review_table, $review_where)) {//// if review delete
        foreach ($review_media_name_array as $review_image_name) {
          $file_to_delete = $upload_location.$review_image_name;
          unlink($file_to_delete);
        }///end foreach

        $meta_where = [ 'review_id' => $review_id];
        $wpdb->delete($review_meta_table, $meta_where);///delete all meta of each comment
      }///end if review delete

      /*******************************************************************************************/
    }elseif ($type == 'comment') {


      $review_media_query = $wpdb->get_results('SELECT meta_value FROM '.$review_meta_table.' WHERE review_id ='.$review_id.' AND meta_key = "dom767_review_uploads"');////get review media
      $review_media_name_array = $review_media_query[0]->meta_value;
      $review_media_name_array = explode(",",$review_media_name_array);

      $review_where = [ 'review_ID' => $review_id ];
      if ($wpdb->delete($review_table, $review_where)) {//// if review delete
        foreach ($review_media_name_array as $review_image_name) {
          $file_to_delete = $upload_location.$review_image_name;
          unlink($file_to_delete);
        }///end foreach

        $meta_where = [ 'review_id' => $review_id];
        $wpdb->delete($review_meta_table, $meta_where);///delete all meta of each comment
      }///end if review delete

    }///end if
  }//end if

  $htmldata = bootstrapTableQuery();

  $output = array();
  $output['data'] = ob_get_clean();
  $output['htmldata'] = $htmldata;

  echo json_encode($output);
  wp_die();

}


/////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// delete review or comment for admin  //////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_dom767_adminReviewEdit', 'dom767_adminReviewEdit' );
add_action( 'wp_ajax_nopriv_dom767_adminReviewEdit', 'dom767_adminReviewEdit' );

function dom767_adminReviewEdit() {

    ob_start();
    global $wpdb;
      
    $review_id         = isset( $_POST['review_id'] ) ? $_POST['review_id'] : NULL; 
    $type              = isset( $_POST['type'] ) ? $_POST['type'] : NULL; 
    $content           = isset( $_POST['content'] ) ? $_POST['content'] : ''; 
    $rating            = isset( $_POST['rating'] ) ? $_POST['rating'] : 0;

    if ($review_id != NULL) {
        $data=array( 
            'review_author_IP'    => $ipaddress, 
            'review_date'         => time(), 
            'review_date_gmt'     => time(), 
            'review_content'      => $content, 
            'review_rating'        => $rating, 
        );

        $tablename = $wpdb->prefix.'dom767_reviews';
        $where = array('review_ID' => $review_id );
        $wpdb->update( $tablename, $data, $where);

    }//end if

    $htmldata = bootstrapTableQuery();

    $output = array();
    $output['data'] = ob_get_clean();
    $output['htmldata'] = $htmldata;

    echo json_encode($output);
    wp_die();

}


/////////////////////////////////////////////////////////////////////////////////////////
///////////////////// delete review or comment  media for admin  ////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_dom767_adminReviewMedia', 'dom767_adminReviewMedia' );
add_action( 'wp_ajax_nopriv_dom767_adminReviewMedia', 'dom767_adminReviewMedia' );

function dom767_adminReviewMedia() {

    ob_start();
    global $wpdb;
      
    $review_ID         = isset( $_POST['review_id'] ) ? $_POST['review_id'] : NULL; 
    $media_url         = isset( $_POST['media_url'] ) ? $_POST['media_url'] : NULL; 
    $img_name        = isset( $_POST['media_name'] ) ? $_POST['media_name'] : '';

    $upload            = wp_upload_dir();// Upload directory
    $upload_location   = $upload['basedir'] .'/dom767_review_uploads/';
    $upload_url        = $upload['baseurl'] .'/dom767_review_uploads/';
    $review_table      = $wpdb->prefix . 'dom767_reviews';
    $review_meta_table = $wpdb->prefix . 'dom767_review_meta';

    if ($review_ID != NULL) {
        $media_query = $wpdb->get_results('SELECT * FROM wp_dom767_review_meta WHERE review_id ='.$review_ID.' AND meta_key = "dom767_review_uploads" ORDER BY review_ID DESC');

        if ($media_query) {
            foreach ($media_query as $medias) {
                //$media_name_array = $media_query[0]->meta_value;
                $meta_id = $medias->meta_id;
                $media_name_array = $medias->meta_value;
                $media_name_array  = explode(",",$media_name_array);///string to array
            }
        }



        $new_name_arr = [];
        foreach ($media_name_array as $media_name) {
          if ($media_name != $img_name) {
            $new_name_arr[] = $media_name;
          }
        }

        $new_name_arr = implode(",",$new_name_arr);
        $data=array(
            'review_id'   => $review_ID,
            'meta_key'    => 'dom767_review_uploads', 
            'meta_value'  => $new_name_arr,
        );

        $where = array('meta_id' => $meta_id );
        $tablename = $wpdb->prefix.'dom767_review_meta';
        $wpdb->update( $tablename, $data, $where );

    }//end if

    $htmldata = bootstrapTableQuery();

    $output = array();
    $output['data'] = ob_get_clean();
    $output['htmldata'] = $htmldata;

    echo json_encode($output);
    wp_die();

}


/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////// aprove review or comment from admin  ///////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_dom767_adminReviewAprove', 'dom767_adminReviewAprove' );
add_action( 'wp_ajax_nopriv_dom767_adminReviewAprove', 'dom767_adminReviewAprove' );

function dom767_adminReviewAprove() {

    ob_start();
    global $wpdb;
      
    $review_ID    = isset( $_POST['review_id'] ) ? $_POST['review_id'] : NULL; 
    $type         = isset( $_POST['type'] ) ? $_POST['type'] : NULL; 
    $status       = isset( $_POST['status'] ) ? $_POST['status'] : '';

    //var_dump($status);
    if ($review_ID != NULL) {

        if ($status == 'Unaprove') {
            $newStatus = 0;
        }elseif ($status == 'Aprove') {
            $newStatus = 1;
        }

        $data=array( 
            'review_approved'        => $newStatus
        );
        $where = array('review_ID' => $review_ID );
        $tablename = $wpdb->prefix.'dom767_reviews';
        $wpdb->update( $tablename, $data, $where );

    }//end if

    $htmldata = bootstrapTableQuery();

    $output = array();
    $output['data'] = ob_get_clean();
    $output['htmldata'] = $htmldata;

    echo json_encode($output);
    wp_die();

}