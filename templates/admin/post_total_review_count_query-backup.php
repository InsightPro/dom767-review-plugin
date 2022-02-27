<?php


if(is_user_logged_in()){


  $review_post_query  = get_total_review();
  usort($review_post_query, "admin_review_order_desc");


  ?>
    <?php if ($review_post_query): ?>
      <?php  
        $limit          = 20;
        $total_item     = count($review_post_query);
        $total_pages    = ceil($total_item/$limit);  
        $review_post_query = array_slice( $review_post_query, 0, $limit ); 
        $review_list_number = 1;
      ?>
    <hr>
    <h1>Review List</h1>
    <h3>Total <?php echo $total_item ?> review</h3>
    <div class="admin_review_loadmore_loading_div" style="display: none">
      <img class="admin_review_loadmore_loading_img" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/loading.gif" alt="" >
    </div>
    <table class="post_review_count_admin_table">
      <tr>
        <th>No</th>
        <th>Type</th>
        <th>#</th>
        <th>Post Id</th>
        <th>Review Date</th>
        <th>Review Author</th>
        <th>Rating</th>
        <th>Review Content</th>
        <th>Action</th>
      </tr>
      <?php foreach ($review_post_query as $review_post): ?>
        <?php 
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

        <tr id="review-<?php echo esc_attr($review_ID); ?>" class="reviews-list-item">
          <td class="t-f-c-td"><?php echo $review_list_number ?></td>
          <td class="t-f-c-td"><?php echo $review_type ?></td>
          <td class="t-f-c-td"></td>
          <td class="t-f-c-td"><?php echo $review_post_ID ?></td>
          <td class="t-f-c-td"><?php echo _time_ago($review_date) ?></td>
          <td class="t-f-c-td"><?php echo $review_author ?></td>
          <td class="t-f-c-td"><?php echo $review_rating ?></td>
          <td class="t-f-c-td"><?php echo $review_content ?></td>
          <td class="t-f-c-td">
            <button type="button" class="btn review-btn-dange">Delete</button>
          </td>
        </tr>
        <?php
        $comment_post_query  = get_review_comment($review_ID);
        if ($comment_post_query) {
          $comment_list_number = 1;
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
            <tr id="review-<?php echo esc_attr($comment_ID); ?>" class="comment-list-item">
              <td class="t-f-c-td"></td>
              <td class="t-f-c-td"><?php echo $comment_type ?></td>
              <td class="t-f-c-td"><?php echo $comment_list_number ?></td>
              <td class="t-f-c-td"><?php echo $comment_post_ID ?></td>
              <td class="t-f-c-td"><?php echo _time_ago($comment_date) ?></td>
              <td class="t-f-c-td"><?php echo $comment_author ?></td>
              <td class="t-f-c-td"></td>
              <td class="t-f-c-td"><?php echo $comment_content ?></td>
              <td class="t-f-c-td">
                <button type="button" class="btn review-btn-dange">Delete</button>
              </td>
            </tr>
            <?php
            $comment_list_number ++;
          }//end foreach
        }///end if
        $review_list_number ++;
        ?>

      <?php endforeach ?>
    </table>



      <?php 
      echo "<br>";
      ?>
      <ul class="review_admin_paginations_ul">
      <li class="review_admin_paginations_pre" data-total_page="<?php echo $total_pages ?>" data-page="1" > << </li>
      <?php

      for( $i=1; $i<= $total_pages; $i++ ){
        if ($i<= 20) {
          echo '<li class="review_admin_paginations" id="review_admin_paginations'.$i.'" data-total_page="'. $total_pages .'" data-page="'.$i.'" >'. $i.'</li>';
        }
        if ($i == 21) {
          echo '<li class="review_admin_paginations" id="review_admin_paginations'.$i.'" data-total_page="'. $total_pages .'" data-page="'.$i.'" >'. '...'.'</li>';
        }
      }
      ?>
      <li class="review_admin_paginations_next" data-total_page="<?php echo $total_pages ?>" data-page="1" > >> </li>
      </ul>
      <?php

      ?>


    <?php else: /// if no post found ?>
      <h4 class="no-note-xl">No review Found</h4>
    <?php endif ?>
<?php
}/// end if user login
?>



<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
            </tr>
            <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012/03/29</td>
                <td>$433,060</td>
            </tr>
            <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>2008/11/28</td>
                <td>$162,700</td>
            </tr>
            <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
                <td>2012/12/02</td>
                <td>$372,000</td>
            </tr>
            <tr>
                <td>Herrod Chandler</td>
                <td>Sales Assistant</td>
                <td>San Francisco</td>
                <td>59</td>
                <td>2012/08/06</td>
                <td>$137,500</td>
            </tr>
            <tr>
                <td>Rhona Davidson</td>
                <td>Integration Specialist</td>
                <td>Tokyo</td>
                <td>55</td>
                <td>2010/10/14</td>
                <td>$327,900</td>
            </tr>
            <tr>
                <td>Colleen Hurst</td>
                <td>Javascript Developer</td>
                <td>San Francisco</td>
                <td>39</td>
                <td>2009/09/15</td>
                <td>$205,500</td>
            </tr>
            <tr>
                <td>Sonya Frost</td>
                <td>Software Engineer</td>
                <td>Edinburgh</td>
                <td>23</td>
                <td>2008/12/13</td>
                <td>$103,600</td>
            </tr>
            <tr>
                <td>Jena Gaines</td>
                <td>Office Manager</td>
                <td>London</td>
                <td>30</td>
                <td>2008/12/19</td>
                <td>$90,560</td>
            </tr>
            <tr>
                <td>Quinn Flynn</td>
                <td>Support Lead</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2013/03/03</td>
                <td>$342,000</td>
            </tr>
            <tr>
                <td>Charde Marshall</td>
                <td>Regional Director</td>
                <td>San Francisco</td>
                <td>36</td>
                <td>2008/10/16</td>
                <td>$470,600</td>
            </tr>
            <tr>
                <td>Haley Kennedy</td>
                <td>Senior Marketing Designer</td>
                <td>London</td>
                <td>43</td>
                <td>2012/12/18</td>
                <td>$313,500</td>
            </tr>
            <tr>
                <td>Tatyana Fitzpatrick</td>
                <td>Regional Director</td>
                <td>London</td>
                <td>19</td>
                <td>2010/03/17</td>
                <td>$385,750</td>
            </tr>
            <tr>
                <td>Michael Silva</td>
                <td>Marketing Designer</td>
                <td>London</td>
                <td>66</td>
                <td>2012/11/27</td>
                <td>$198,500</td>
            </tr>
            <tr>
                <td>Paul Byrd</td>
                <td>Chief Financial Officer (CFO)</td>
                <td>New York</td>
                <td>64</td>
                <td>2010/06/09</td>
                <td>$725,000</td>
            </tr>
            <tr>
                <td>Gloria Little</td>
                <td>Systems Administrator</td>
                <td>New York</td>
                <td>59</td>
                <td>2009/04/10</td>
                <td>$237,500</td>
            </tr>
            <tr>
                <td>Bradley Greer</td>
                <td>Software Engineer</td>
                <td>London</td>
                <td>41</td>
                <td>2012/10/13</td>
                <td>$132,000</td>
            </tr>
            <tr>
                <td>Dai Rios</td>
                <td>Personnel Lead</td>
                <td>Edinburgh</td>
                <td>35</td>
                <td>2012/09/26</td>
                <td>$217,500</td>
            </tr>
            <tr>
                <td>Jenette Caldwell</td>
                <td>Development Lead</td>
                <td>New York</td>
                <td>30</td>
                <td>2011/09/03</td>
                <td>$345,000</td>
            </tr>
            <tr>
                <td>Yuri Berry</td>
                <td>Chief Marketing Officer (CMO)</td>
                <td>New York</td>
                <td>40</td>
                <td>2009/06/25</td>
                <td>$675,000</td>
            </tr>
            <tr>
                <td>Caesar Vance</td>
                <td>Pre-Sales Support</td>
                <td>New York</td>
                <td>21</td>
                <td>2011/12/12</td>
                <td>$106,450</td>
            </tr>
            <tr>
                <td>Doris Wilder</td>
                <td>Sales Assistant</td>
                <td>Sydney</td>
                <td>23</td>
                <td>2010/09/20</td>
                <td>$85,600</td>
            </tr>
            <tr>
                <td>Angelica Ramos</td>
                <td>Chief Executive Officer (CEO)</td>
                <td>London</td>
                <td>47</td>
                <td>2009/10/09</td>
                <td>$1,200,000</td>
            </tr>
            <tr>
                <td>Gavin Joyce</td>
                <td>Developer</td>
                <td>Edinburgh</td>
                <td>42</td>
                <td>2010/12/22</td>
                <td>$92,575</td>
            </tr>
            <tr>
                <td>Jennifer Chang</td>
                <td>Regional Director</td>
                <td>Singapore</td>
                <td>28</td>
                <td>2010/11/14</td>
                <td>$357,650</td>
            </tr>
            <tr>
                <td>Brenden Wagner</td>
                <td>Software Engineer</td>
                <td>San Francisco</td>
                <td>28</td>
                <td>2011/06/07</td>
                <td>$206,850</td>
            </tr>
            <tr>
                <td>Fiona Green</td>
                <td>Chief Operating Officer (COO)</td>
                <td>San Francisco</td>
                <td>48</td>
                <td>2010/03/11</td>
                <td>$850,000</td>
            </tr>
            <tr>
                <td>Shou Itou</td>
                <td>Regional Marketing</td>
                <td>Tokyo</td>
                <td>20</td>
                <td>2011/08/14</td>
                <td>$163,000</td>
            </tr>
            <tr>
                <td>Michelle House</td>
                <td>Integration Specialist</td>
                <td>Sydney</td>
                <td>37</td>
                <td>2011/06/02</td>
                <td>$95,400</td>
            </tr>
            <tr>
                <td>Suki Burks</td>
                <td>Developer</td>
                <td>London</td>
                <td>53</td>
                <td>2009/10/22</td>
                <td>$114,500</td>
            </tr>
            <tr>
                <td>Prescott Bartlett</td>
                <td>Technical Author</td>
                <td>London</td>
                <td>27</td>
                <td>2011/05/07</td>
                <td>$145,000</td>
            </tr>
            <tr>
                <td>Gavin Cortez</td>
                <td>Team Leader</td>
                <td>San Francisco</td>
                <td>22</td>
                <td>2008/10/26</td>
                <td>$235,500</td>
            </tr>
            <tr>
                <td>Martena Mccray</td>
                <td>Post-Sales support</td>
                <td>Edinburgh</td>
                <td>46</td>
                <td>2011/03/09</td>
                <td>$324,050</td>
            </tr>
            <tr>
                <td>Unity Butler</td>
                <td>Marketing Designer</td>
                <td>San Francisco</td>
                <td>47</td>
                <td>2009/12/09</td>
                <td>$85,675</td>
            </tr>
            <tr>
                <td>Howard Hatfield</td>
                <td>Office Manager</td>
                <td>San Francisco</td>
                <td>51</td>
                <td>2008/12/16</td>
                <td>$164,500</td>
            </tr>
            <tr>
                <td>Hope Fuentes</td>
                <td>Secretary</td>
                <td>San Francisco</td>
                <td>41</td>
                <td>2010/02/12</td>
                <td>$109,850</td>
            </tr>
            <tr>
                <td>Vivian Harrell</td>
                <td>Financial Controller</td>
                <td>San Francisco</td>
                <td>62</td>
                <td>2009/02/14</td>
                <td>$452,500</td>
            </tr>
            <tr>
                <td>Timothy Mooney</td>
                <td>Office Manager</td>
                <td>London</td>
                <td>37</td>
                <td>2008/12/11</td>
                <td>$136,200</td>
            </tr>
            <tr>
                <td>Jackson Bradshaw</td>
                <td>Director</td>
                <td>New York</td>
                <td>65</td>
                <td>2008/09/26</td>
                <td>$645,750</td>
            </tr>
            <tr>
                <td>Olivia Liang</td>
                <td>Support Engineer</td>
                <td>Singapore</td>
                <td>64</td>
                <td>2011/02/03</td>
                <td>$234,500</td>
            </tr>
            <tr>
                <td>Bruno Nash</td>
                <td>Software Engineer</td>
                <td>London</td>
                <td>38</td>
                <td>2011/05/03</td>
                <td>$163,500</td>
            </tr>
            <tr>
                <td>Sakura Yamamoto</td>
                <td>Support Engineer</td>
                <td>Tokyo</td>
                <td>37</td>
                <td>2009/08/19</td>
                <td>$139,575</td>
            </tr>
            <tr>
                <td>Thor Walton</td>
                <td>Developer</td>
                <td>New York</td>
                <td>61</td>
                <td>2013/08/11</td>
                <td>$98,540</td>
            </tr>
            <tr>
                <td>Finn Camacho</td>
                <td>Support Engineer</td>
                <td>San Francisco</td>
                <td>47</td>
                <td>2009/07/07</td>
                <td>$87,500</td>
            </tr>
            <tr>
                <td>Serge Baldwin</td>
                <td>Data Coordinator</td>
                <td>Singapore</td>
                <td>64</td>
                <td>2012/04/09</td>
                <td>$138,575</td>
            </tr>
            <tr>
                <td>Zenaida Frank</td>
                <td>Software Engineer</td>
                <td>New York</td>
                <td>63</td>
                <td>2010/01/04</td>
                <td>$125,250</td>
            </tr>
            <tr>
                <td>Zorita Serrano</td>
                <td>Software Engineer</td>
                <td>San Francisco</td>
                <td>56</td>
                <td>2012/06/01</td>
                <td>$115,000</td>
            </tr>
            <tr>
                <td>Jennifer Acosta</td>
                <td>Junior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>43</td>
                <td>2013/02/01</td>
                <td>$75,650</td>
            </tr>
            <tr>
                <td>Cara Stevens</td>
                <td>Sales Assistant</td>
                <td>New York</td>
                <td>46</td>
                <td>2011/12/06</td>
                <td>$145,600</td>
            </tr>
            <tr>
                <td>Hermione Butler</td>
                <td>Regional Director</td>
                <td>London</td>
                <td>47</td>
                <td>2011/03/21</td>
                <td>$356,250</td>
            </tr>
            <tr>
                <td>Lael Greer</td>
                <td>Systems Administrator</td>
                <td>London</td>
                <td>21</td>
                <td>2009/02/27</td>
                <td>$103,500</td>
            </tr>
            <tr>
                <td>Jonas Alexander</td>
                <td>Developer</td>
                <td>San Francisco</td>
                <td>30</td>
                <td>2010/07/14</td>
                <td>$86,500</td>
            </tr>
            <tr>
                <td>Shad Decker</td>
                <td>Regional Director</td>
                <td>Edinburgh</td>
                <td>51</td>
                <td>2008/11/13</td>
                <td>$183,000</td>
            </tr>
            <tr>
                <td>Michael Bruce</td>
                <td>Javascript Developer</td>
                <td>Singapore</td>
                <td>29</td>
                <td>2011/06/27</td>
                <td>$183,000</td>
            </tr>
            <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                <td>2011/01/25</td>
                <td>$112,000</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
</table>