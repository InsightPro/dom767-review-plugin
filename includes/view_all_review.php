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
////////////////////// admin review next post query loadmore by ajax ////////////////////////
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
////////////////////// review admin pagination num count 20 by ajax ////////////////////////
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
