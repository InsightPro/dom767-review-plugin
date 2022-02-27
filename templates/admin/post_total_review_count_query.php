<?php
if(is_user_logged_in()){

  $review_post_query  = get_total_review();
  if ($review_post_query) {
    $total_item     = count($review_post_query);
    $order_no       = 1;
  ?>
  <h1>Review List</h1>
  <h3>Total <?php echo $total_item ?> review</h3>
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

        $comment_post_query  = get_review_comment($review_ID);
        //var_dump($comment_post_query);
        ?>
        <tr>
          <td><?php echo $order_no ?></td>
          <td><?php echo $review_type ?></td>
          <td><?php echo $review_post_ID ?></td>
          <td><?php echo date("F j, Y g:i a", $review_date) ?></td>
          <td><?php echo $review_author ?></td>
          <td><?php echo $review_rating ?></td>
          <td><?php echo $review_content ?></td>
          <td><button type="button" class="btn review-btn-dange">Delete</button></td>
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
            ?>
            <tr>
              <td><i class="far fa-comment-dots"></i> <?php echo $order_no_c ?></td>
              <td><?php echo $comment_type ?></td>
              <td><?php echo $comment_post_ID ?></td>
              <td><?php echo date("F j, Y g:i a", $review_date) ?></td>
              <td><?php echo $comment_author ?></td>
              <td><i class="far fa-comment-dots"></i></td>
              <td><?php echo $comment_content ?></td>
              <td><button type="button" class="btn review-btn-dange">Delete</button></td>
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
        <th>Action</th>
      </tr>
    </tfoot>
  </table>

  <?php
  }// end if review 

}///end if user login