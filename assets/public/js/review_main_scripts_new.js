jQuery(document).ready(function($){


  var page_no           = 1 ;
  var filteredBY        = 'false';
  var current_user_id   = dom_review_list.current_user_id;
  var public_assets_dri = dom_review_list.public_assets_dri;
  var upload_form_nonce = dom_review_list.upload_form_nonce;

  /************************************** Get Ajax URL********************************/
  var ajaxURL = dom_review_list.ajax_url;
  if (dom_review_list.ajax_url.includes("mydashboard")) {
    ajaxURL = dom_review_list.ajax_url.replace("mydashboard", "wp-admin");
  }
  /************************************************************************************/


  var alert_danger = '<div class="dom767-review-alert-danger" role="alert"><span class="review-alert-danger-text">This is a danger alert—check it out!</span><i class="far fa-times-circle review_alert_close"></i></div>';

  var alert_success ='<div class="dom767-review-alert-success" role="alert"><span class="review-alert-success-text">This is a danger alert—check it out!</span><i class="far fa-times-circle review_alert_close"></i></div>';


  /******************************* delete review unused img **********************************/

  var uploaded_review_img = (typeof Cookies.get("uploaded_review_image") != "undefined") ? Cookies.get("uploaded_review_image") : '';// get file field value using field id
  //var uploaded_review_img  = (uploaded_review_img)? uploaded_review_img.split(","): [];

  if (uploaded_review_img) {
    var ajax_data = {
      action: "onload_remove_uploaded_img",
      security: dom_review_list.security
    };

    $.ajax({
      type: 'post',
      url: ajaxURL,
      data: ajax_data,
      success: function (data_res) {
        var result = JSON.parse(data_res);
        Cookies.remove("uploaded_review_image");
      }
    });
  }
  /************************************************************************************/ 
  /******************************* delete comment unused img **********************************/

  var uploaded_review_comment_image = (typeof Cookies.get("uploaded_review_comment_image") != "undefined") ? Cookies.get("uploaded_review_comment_image") : '';// get file field value using field id
  //var uploaded_review_img  = (uploaded_review_img)? uploaded_review_img.split(","): [];

  if (uploaded_review_comment_image) {
    var ajax_data = {
      action: "onload_remove_comment_uploaded_img",
      security: dom_review_list.security
    };

    $.ajax({
      type: 'post',
      url: ajaxURL,
      data: ajax_data,
      success: function (data_res) {
        var result = JSON.parse(data_res);
        Cookies.remove("uploaded_review_comment_image");
      }
    });
  }
  /************************************************************************************/

  /************ clicked on comment form close btn remove uploaded image **************/

  $(document).on('click touchend', '.comment_form_close_btn, .dom767_review_reply_button, .dom767_review_edit_button, #review_old_to_new, #filterForHighRating, #filterForLowRating', function(){

    var uploaded_review_comment_image = (typeof Cookies.get("uploaded_review_comment_image") != "undefined") ? Cookies.get("uploaded_review_comment_image") : '';// get file field value using field id

    if (uploaded_review_comment_image) {
      var ajax_data = {
        action: "cancel_remove_comment_uploaded_img",
        security: dom_review_list.security
      };

      $.ajax({
        type: 'post',
        url: ajaxURL,
        data: ajax_data,
        success: function (data_res) {
          var result = JSON.parse(data_res);
          Cookies.remove("uploaded_review_comment_image");
        }
      });
    }

  });

  /******************************* Show 1 comment **********************************/
  $(".comments-single-info").each(function(){
    $(".comments-single-info:first-child").css('display', 'inline-flex');
  });

  /******************************* Show all comment **********************************/
  $(document).on('click', '.view_all_comments_btn', function(e){
    var sib = $(this).next('.dom767_review_reply_main_wrap').find(".comments-single-info");
    $(sib).css('display', 'inline-flex');
    $(this).hide();///hide view all button
  });

  /*************************** Show all comment reply *********************************/
  $(document).on('click', '.view_all_comment_reply_btn', function(e){
    var sib = $(this).next('.dom767_comment_reply_main_wrap').find(".reply-single-info");
    $(sib).css('display', 'inline-flex');
    $(this).hide();///hide view all button
  });


  /*********************************** Rating Star ************************************/
  $("input[type='radio'].revRadioBtn").click(function(){
    $('.dom767_myratings_wraps').fadeIn();
    var sim = $("input[type='radio'].revRadioBtn:checked").val();
    if (sim<3) { 
      $('.dom767_myratings').css('color','red'); 
      $(".dom767_myratings").text(sim); 
    }else{ 
      $('.dom767_myratings').css('color','green'); 
      $(".dom767_myratings").text(sim);
    } 
  });



  /*********************** comment, Reply, edit form close ***************************/

  /******************************* comment form close ********************************/
  $(document).on('click', '#comment_form_close_btn', function close_review_reply_form(e){
    $('.review-comment-form-wrap').remove();
    $('.dom767_review_reply_button').fadeIn();
    e.preventDefault();
  });  

  /******************************* Reply form close ********************************/
  $(document).on('click', '#reply_form_close_btn', function close_review_reply_form(e){
    $('.review-reply-form-wrap').remove();
    e.preventDefault();
  });

  /******************************* edit form close ********************************/
  $(document).on('click', '#edit_form_close_btn', function close_review_reply_form(e){
    $('.review-edit-form-wrap').remove();
    $('.dom767_review_edit_button').fadeIn();
    e.preventDefault();
  });



  /******************************** comment form open ******************************/

  $(document).on('click', '.dom767_review_reply_button', function poen_review_comment_form(e){

    $(this).fadeOut();
    $('.review-comment-form-wrap').remove();
    $('.review-edit-form-wrap').remove();
    var review_post_id = $(this).attr('data-post_id');
    var review_parent_id = $(this).attr('data-parent_ID');
    var karma = $(this).attr('data-karma');///main review id
    var user_id = current_user_id;
    var that = $(this);
    var that_parent = $(this).parent();
    var media_farm1 = $('.commentAndReply_media_form_div').html();

    var media_farm = '<div class="dom767_comment_media_upload_wrap"><form id="dom767_comment_image_formId" class="dom767_comment_image_formId" method="post" enctype="multipart/form-data" autocomplete="off" ><input type="file" name="file[]" id="dom767_comments_file" multiple /><h2 class="drag_and_drop_text">Drag your images here or click in this area.</h2><input name="security" value="'+upload_form_nonce+'" type="hidden"><input name="action" value="comment_upload_file_callback" type="hidden"/><input name="submit" value="upload" type="submit" id="dom767-submit-comment-img" style="display: none" /><h4>Image Type png, jpeg, jpg only</h4></form><div class="dom767_show_coment_uploaded_img"></div><div class="comment_media_upload_loading_img"><img src="'+public_assets_dri+'/image/llF5iyg.gif" alt="" style=" " ><p>Media is Uploading...</p></div><div class="commetFormSubmitAndCloseBtn"><button type="button" class="btn comment_form_submit_btn" id="comment_form_submit_btn">Submit</button><button type="button" class="btn comment_form_close_btn" id="comment_form_close_btn">close</button></div></div>';

    var htmlform = '<div class="review-comment-form-wrap"><h4>Leave a comment <button type="button" class="btn comment_media_form_show_btn" id="comment_media_form_show_btn"><i class="fas fa-image"></i></button></h4><form id="dom767_review_reply_form" action="" method="post" class="dom767_review_reply_form"><div class="comment-form-element"><input type="hidden" name="review_post_id" id="reply_post_id" value="'+review_post_id+'" ><input type="hidden" name="review_parent_id" id="review_parent_id" value="'+review_parent_id+'" ><input type="hidden" name="review_karma" id="review_karma" value="'+karma+'" ><label class="hide" for="review">Message</label><textarea id="review_text_area" class="review-input-fields" placeholder="Write your Comment" name="review" cols="40" rows="10"></textarea></div><input name="submit" class="comment-form-submit"  type="submit" id="dom767-comment-submit" value="submit" style="display: none;"></form><div class="comment-form-bottom-element">'+media_farm+'</div></div>';

    //$(that_parent).after(htmlform);
    if (user_id != '0') {
      $(that_parent).parent().after(htmlform);
    }else{
      $('.dom767-review-alert-danger').remove();
      $(that_parent).parent().after(alert_danger);
      $('.dom767-review-alert-danger').fadeIn();
      $('.review-alert-danger-text').html('Please Login Or Register');
    }

    e.preventDefault();
  });

  /******************************** Reply form open ******************************/
  $(document).on('click', '#dom767_review_reply_button-off', function poen_review_reply_form(e){
    //$(this).find('span').attr('data-id');
    $('.review-reply-form-wrap').remove();
    $('.review-edit-form-wrap').remove();
    var review_post_id = $(this).attr('data-post_id');
    var review_parent_id = $(this).attr('data-parent_ID');
    var karma = $(this).attr('data-karma');///main review id
    var user_id = current_user_id;
    var that = $(this);
    var that_parent = $(this).parent();

    var htmlform = '<div class="review-reply-form-wrap"><h4>Leave a comment</h4><form id="dom767_review_reply_form" action="" method="post" class="dom767_review_reply_form"><div class="reply-form-element"><input type="hidden" name="review_post_id" id="reply_post_id" value="'+review_post_id+'" ><input type="hidden" name="review_parent_id" id="review_parent_id" value="'+review_parent_id+'" ><input type="hidden" name="review_karma" id="review_karma" value="'+karma+'" ><label class="hide" for="review">Message</label><textarea id="review_text_area" class="review-input-fields" placeholder="Write your reply" name="review" cols="40" rows="10"></textarea></div><input name="submit" class="form-submit-button"  type="submit" id="dom767-reply-submit" value="submit"><button type="button" class="btn reply_form_close_btn" id="reply_form_close_btn">close</button></form></div>';

    //$(that_parent).after(htmlform);
    if (user_id != '0') {
      $(that_parent).parent().after(htmlform);
    }else{
      $('.dom767-review-alert-danger').remove();
      $(that_parent).parent().after(alert_danger);
      $('.dom767-review-alert-danger').fadeIn();
      $('.review-alert-danger-text').html('Please Login Or Register');
    }

    e.preventDefault();
  });


  /******************************** Edid form open ******************************/

  $(document).on('click', '#dom767_review_edit_button', function poen_review_edit_form(e){

    $(this).fadeOut();
    $('.review-reply-form-wrap').remove();
    $('.review-edit-form-wrap').remove();
    var review_post_id = $(this).attr('data-post_id');
    var edit_review_id = $(this).attr('data-review_ID');
    var user_id = current_user_id;
    var that = $(this);
    var that_parent = $(this).parent();
    var content = $(that_parent).parent().siblings('.review-content-div').find('p').text();

    var htmlform = '<div class="review-edit-form-wrap"><h4>Edit comment</h4><form id="dom767_review_edit_form" action="" method="post" class="dom767_review_edit_form"><div class="edit-form-element"><input type="hidden" name="review_post_id" id="edit_post_id" value="'+review_post_id+'" ><input type="hidden" name="edit_review_id" id="edit_review_id" value="'+edit_review_id+'" ><label class="hide" for="review">Message</label><textarea id="review_text_area" class="review-input-fields" placeholder="Write your edit" name="review" cols="40" rows="10">'+content+'</textarea></div><input name="submit" class="form-submit-button"  type="submit" id="dom767-edit-review-submit" value="submit"><button type="button" class="btn edit_form_close_btn" id="edit_form_close_btn">close</button></form></div>';

    //$(that_parent).after(htmlform);
    $(that_parent).parent().after(htmlform);

    e.preventDefault();
  });



  /****************************** review form submit *********************************/

  $('#dom767_review_form_submit_btn').on('click', function() {
    //var $form = $(this).closest('form');
    $('#dom767-submit-review').click();
  });

  $(document).on('submit', '#dom767_review_form', function review_form_submit(e){
    $('.dom767-review-alert-danger').remove();
    $(this).before(alert_danger);
    dataObj = {};
    var post_id = $('#review_post_id').val();
    var form_data = $('#dom767_review_form').serializeArray();
    $(form_data).each(function(i, field){
      dataObj[field.name] = field.value;
    });

    if(dataObj['review'] != '' && dataObj['rating']){///if textarea and rating is not empty
      $('#dom767_review_form_submit_btn').text("Submitting, Please Waite....");
      var ajax_data = {
        action: "dom767_review_form_submit",
        security: dom_review_list.security,
        post_id : post_id,
        form_data: form_data,
        page_no: page_no
      };

      $.ajax({
        type: 'post',
        url: ajaxURL,
        data: ajax_data,
        success: function (data_res) {
          var result = JSON.parse(data_res);
          $('#review_list_wrap_main').html(result.data);
          $('#total_review_count').html(result.total_review);
          if (result.total_review > 1) {$('#total_review_text').text('Reviews');}
          $('.dom767_total_rating_val').html(result.total_rating);
          var rating_stars = result.total_rating * 20 +'%';
          $('#postTotalEmptyStarRating').css("width", rating_stars);
          $('.dom767_review_form_wrap').fadeOut();
          //alert('form was submitted');
          $('.dom767-review-alert-success').fadeIn();
          $('.review-alert-success-text').html('THANKS FOR YOUR REVIEW & RATING')

          Cookies.remove("uploaded_review_image");/// set new fav cookies data for 1 days
          $('#dom767_review_form_submit_btn').text("Leave Your Review");

          $(".comments-single-info").each(function(){
            $(".comments-single-info:first-child").css('display', 'inline-flex');
          });
        }
      });
      
    }else{///if textarea and rating is empty
      if (dataObj['review'] == '' && ! dataObj['rating']) {///if textarea is empty
        $('.dom767-review-alert-danger').fadeIn();
        $('.review-alert-danger-text').html('WRITE SOMTHING AS REVIEW AND RATE US BY STAR');
      }else if(! dataObj['rating']){///if rating is empty
        $('.dom767-review-alert-danger').fadeIn();
        $('.review-alert-danger-text').html('RATE US BY STAR');
      }else if(dataObj['review'] == ''){
        $('.dom767-review-alert-danger').fadeIn();
        $('.review-alert-danger-text').html('WRITE SOMTHING AS REVIEW');
      }
    }

    e.preventDefault();
  });




  /****************************** comment form submit *********************************/
  $(document).on('click', '#comment_form_submit_btn', function (e){
    $('.comment-form-submit').click();
  });

  $(document).on('submit', '#dom767_review_reply_form', function reply_form_submit(e){

    var post_id   = $('#reply_post_id').val();
    var user_id   = current_user_id;
    var form_data = $('#dom767_review_reply_form').serializeArray();
    
    dataObj = {};
    $(form_data).each(function(i, field){
      dataObj[field.name] = field.value;
    });

    if(dataObj['review'] != ''){///if textarea and rating is not empty
      $('.comment_form_submit_btn').text("Submitting...");
      var ajax_data = {
        action: "dom767_reply_form_submit",
        security: dom_review_list.security,
        post_id : post_id,
        form_data: form_data,
        page_no: page_no
      };

      $.ajax({
        type: 'post',
        url: ajaxURL,
        data: ajax_data,
        success: function (data_res) {
          var result = JSON.parse(data_res);
          $('#review_list_wrap_main').html(result.data);
          //$('.comment_form_submit_btn').taxt("Submit");
          Cookies.remove("uploaded_review_comment_image");
          $(".comments-single-info").each(function(){
            $(".comments-single-info:first-child").css('display', 'inline-flex');
          });
        }
      });
      
    }else{///if textarea and rating is empty
      $('.dom767-review-alert-danger').remove();
      $(this).before(alert_danger);
      $('.dom767-review-alert-danger').fadeIn();
      $('.review-alert-danger-text').html('WRITE SOMTHING AS COMMENT');
    }


    e.preventDefault();
  });


  /****************************** Edit form submit *********************************/

  $(document).on('submit', '#dom767_review_edit_form', function edit_form_submit(e){

    dataObj = {};
    var post_id = $('#edit_post_id').val();
    var form_data = $('#dom767_review_edit_form').serializeArray();
    $(form_data).each(function(i, field){
      dataObj[field.name] = field.value;
    });

    if(dataObj['review'] != ''){///if textarea and rating is not empty
      $(this).find('#dom767-edit-review-submit').val("Submitting...");
      var ajax_data = {
        action: "dom767_edit_form_submit",
        security: dom_review_list.security,
        post_id : post_id,
        form_data: form_data,
        page_no: page_no
      };

      $.ajax({
        type: 'post',
        url: ajaxURL,
        data: ajax_data,
        success: function (data_res) {
          var result = JSON.parse(data_res);
          $('#review_list_wrap_main').html(result.data);
          $('#dom767_review_form_submit_btn').text("Leave Your Review");
          $(this).find('#dom767-edit-review-submit').val("Submit");
          $(".comments-single-info").each(function(){
            $(".comments-single-info:first-child").css('display', 'inline-flex');
          });
        }
      });
      
    }else{///if textarea and rating is empty
      $('.dom767-review-alert-danger').remove();
      $(this).before(alert_danger);
      $('.dom767-review-alert-danger').fadeIn();
      $('.review-alert-danger-text').html('WRITE SOMTHING AS REVIEW');
    }

    e.preventDefault();
  });



  /****************************** review vote like *********************************/

  $(document).on('click', '.dom767_review_like_dislike', function review_vote_like(e){

    var review_id     = $(this).attr('data-review_id');
    var user_id       = current_user_id;
    var button_type   = $(this).attr('data-value');/// clicked on like or deslike
    var did_vote      = $(this).attr('data-did_vote');
    var vote_val      = $(this).attr('data-vote_val');///previus vote
    var this_total    = $(this).find('bdi').text();/// this button total value
    var this_total    = parseInt(this_total);/// convert string to integer
    var attar_id      = $(this).attr('id');
    var that_parent   = $(this).parent();/// find parent element
    var that          = $(this);
    var sibling       = $(that_parent).siblings().find('.dom767_review_like_dislike');

    database = '';
    if(user_id != '0'){///if user not login
      if (did_vote == 'true') { /// if user alrady voted
        if (button_type == vote_val) { /// if user previous vote and new vote button is same
          $(this).attr('data-did_vote','false');
          $(sibling).attr('data-did_vote','false');

          var new_this_total = this_total - 1; /// total vote new
          $(this).find('bdi').text(new_this_total);
          database = 'delete';

        }else{ /// if previous vote and new vote is not same

          $(this).attr('data-vote_val',button_type);
          $(sibling).attr('data-vote_val',button_type);

          var new_this_total = this_total + 1;
          $(this).find('bdi').text(new_this_total);/// show total vot value for this
          
          /*change sibling valu for vote*/
          sib_val = $(sibling).find('bdi').text();
          sib_val = parseInt(sib_val);
          sib_val_new = sib_val - 1;
          $(sibling).find('bdi').text(sib_val_new);
          /*end change sibling valu for vote*/
          database = 'update';

        }///end if
        //$(this).attr('data-did_vote','false');
      }else{/// if user didn't vote
        $(this).attr('data-did_vote','true');
        $(sibling).attr('data-did_vote','true');
        $(this).attr('data-vote_val',button_type);
        $(sibling).attr('data-vote_val',button_type);
        var new_this_total = this_total + 1;
        $(this).find('bdi').text(new_this_total);/// show total vot value for this
        database = 'insert';
        
      }////end if
      
        var ajax_data = {
          action: "dom767_review_vote_like",
          security: dom_review_list.security,
          review_id: review_id,
          vote_val: button_type,
          database: database
        };

        $.ajax({
          type: 'post',
          url: ajaxURL,
          data: ajax_data,
          success: function (data_res) {
            var result = JSON.parse(data_res);
            $(that).append(result.data);
          }
        });
      
    }else{///if user not logedin
      $('.dom767-review-alert-danger').remove();
      $(that_parent).parent().after(alert_danger);
      $('.dom767-review-alert-danger').fadeIn();
      $('.review-alert-danger-text').html('PLEASE LOGIN OR REGISTER');
    }
    
    e.preventDefault();
  });



  /***************************** Review Meadia *********************************/
  $(document).on('change', '#dom767_review_file', function (e){
    var $form = $(this).closest('form');
    $form.find('input[type=submit]').click();
    //$('.drag_and_drop_text').text(this.files.length + " file(s) selected");
  }); 

  $(document).on('submit', '#dom767_review_image_formId', function review_img_form_submit(e){

    $('#dom767_review_form_submit_btn').prop('disabled',true);
    var fileInputElement  = document.getElementById("dom767_review_file");
    var file_length       = fileInputElement.files;
    var file_length       = file_length.length;
    //var fileName        = fileInputElement.files[0].name;

    //var ex_uploaded_img = (typeof Cookies.get("uploaded_review_image") != "undefined") ? Cookies.get("uploaded_review_image") : '';// get file field value using field id
    //var uploaded_review_img  = (ex_uploaded_img)? ex_uploaded_img.split(","): [];
    //Cookies.remove("uploaded_review_image");

    if(file_length > 0){

      //$('#dom767_review_image_formId').fadeOut(1);
      $('.review_media_upload_loading_img').fadeIn();

      jQuery.ajax({
        url:ajaxURL,
        type:"post",
        action: "review_upload_file_callback",
        processData: false,
        contentType: false,
        data:  new FormData(this),
        success : function( response ){
          $('.review_media_upload_loading_img').fadeOut(1);
          var returnedData = JSON.parse(response);
          $('.dom767_show_upload_img').html(returnedData.data);

          Cookies.set("uploaded_review_image", returnedData.file_name_arr, {
            expires: 1,
          });
          $('#dom767_review_form_submit_btn').prop('disabled',false);
        },
      });
    }else{
      $('#dom767_review_form_submit_btn').prop('disabled',false);
      $('.dom767-review-alert-danger').remove();
      $('.review_upload_file_wrap').after(alert_danger);
      $('.dom767-review-alert-danger').fadeIn();
      $('.review-alert-danger-text').html("You didn't select any file");
    }//end if

    e.preventDefault();
  });///end function

  /****************************************************************************/

  $(document).on('click', '.media_form_show_hide_btn', function (e){
    $("#dom767_review_image_formId").toggle();
  });  

  /********************************** comment Meadia *********************************/
  
  /**************************** comment media form submit ****************************/

  $(document).on('change', '#dom767_comments_file', function (e){
    var $form = $(this).closest('form.dom767_comment_image_formId');
    $form.find('input[type=submit]').click();
  }); 

  $(document).on('submit', '.dom767_comment_image_formId', function comment_img_form_submit(e){
    $('#comment_form_submit_btn').prop('disabled',true);
    var fileInputElement  = document.getElementById("dom767_comments_file");
    var file_length       = fileInputElement.files;
    var file_length       = file_length.length;

    if(file_length > 0){
      $('.comment_media_upload_loading_img').fadeIn();

      jQuery.ajax({
        url:ajaxURL,
        type:"post",
        action: "comment_upload_file_callback",
        processData: false,
        contentType: false,
        data:  new FormData(this),
        success : function( response ){
          $('.comment_media_upload_loading_img').fadeOut(1);
          var returnedData = JSON.parse(response);
          $('.dom767_show_coment_uploaded_img').html(returnedData.data);

          Cookies.set("uploaded_review_comment_image", returnedData.file_name_arr, {
            expires: 1,
          });
          $('#comment_form_submit_btn').prop('disabled',false);
        },
      });
    }else{
      $('#comment_form_submit_btn').prop('disabled',false);
      $('.dom767-review-alert-danger').remove();
      $('.review_upload_file_wrap').after(alert_danger);
      $('.dom767-review-alert-danger').fadeIn();
      $('.review-alert-danger-text').html("You didn't select any file");
    }//end if

    e.preventDefault();
  });///end function

  /****************************************************************************/
  $(document).on('click', '.comment_media_form_show_btn', function (e){
    $(".dom767_comment_image_formId").toggle();
  }); 

  /**************************** review uploaded extra file remove ***********************/

  $(document).on('click', '.uploaded_file_delete_icon', function remove_review_extra_file(e){
    
    $('.uploaded_file_delete_icon').prop('disabled', true);
    $('#dom767_review_form_submit_btn').prop('disabled', true);
    $(this).find('img').css("display", "block");
    $(this).find('svg').css("display", "none");

    var path      = $(this).attr('data-path');
    var img_name  = $(this).attr('data-image-name');
    var that      = $(this).parent();

    var ajax_data = {
      action: "review_extra_file_remove",
      security: dom_review_list.security,
      path: path,
      img_name: img_name
    };

    $.ajax({
      type: 'post',
      url: ajaxURL,
      data: ajax_data,
      success: function (data_res) {
        var returnedData = JSON.parse(data_res);
        $(that).parent().parent().append(returnedData.data);
        $(that).parent().fadeOut();

        Cookies.set("uploaded_review_image", returnedData.new_name_arr, {
          expires: 1,
        });

        $('.uploaded_file_delete_icon').prop('disabled', false);
        $('#dom767_review_form_submit_btn').prop('disabled', false);

        $('.review_upload_file_wrap').after(alert_success);
        $('.dom767-review-alert-success').fadeIn();
        $('.review-alert-success-text').html('FILE REMOVED SUCCESSFULLY');
      }
    });

    e.preventDefault();
  });  


  /**************************** comment uploaded extra file remove ***********************/

  $(document).on('click', '.comment_uploaded_file_delete_icon', function remove_review_extra_file(e){
    
    $('.comment_uploaded_file_delete_icon').prop('disabled', true);
    $('#dom767_review_form_submit_btn').prop('disabled', true);
    $('#comment_form_submit_btn').prop('disabled', true);
    $(this).find('img').css("display", "block");
    $(this).find('svg').css("display", "none");

    var path      = $(this).attr('data-path');
    var img_name  = $(this).attr('data-image-name');
    var that      = $(this).parent();

    var ajax_data = {
      action: "review_comment_extra_file_remove",
      security: dom_review_list.security,
      path: path,
      img_name: img_name
    };

    $.ajax({
      type: 'post',
      url: ajaxURL,
      data: ajax_data,
      success: function (data_res) {
        var returnedData = JSON.parse(data_res);
        $(that).parent().parent().append(returnedData.data);
        $(that).parent().fadeOut();

        Cookies.set("uploaded_review_comment_image", returnedData.new_name_arr, {
          expires: 1,
        });

        $('.comment_uploaded_file_delete_icon').prop('disabled', false);
        $('.comment_form_submit_btn').prop('disabled', false);
        $('#dom767_review_form_submit_btn').prop('disabled', false);

        $('.review_upload_file_wrap').after(alert_success);
        $('.dom767-review-alert-success').fadeIn();
        $('.review-alert-success-text').html('FILE REMOVED SUCCESSFULLY');
      }
    });

    e.preventDefault();
  });


  /***************************loadmore review**********************************/
  $(document).on('click', '.dom767-load-more-review',function(e){

    var post_id       = $(this).attr('data-post-id');
    var post_id       = parseInt(post_id);
    var total_page    = $(this).attr('data-total-page');
    var total_page    = parseInt(total_page);
    var current_page  = $(this).attr('data-current-page');
    var current_page  = parseInt(current_page);
    var page          = current_page + 1;
    var that          = $(this);
        page_no       = page;

    $(this).text('Please waite, Loading...');

    var ajax_data = {
      action: "review_load_more",
      security: dom_review_list.security,
      post_id: post_id,
      total_page: total_page,
      filteredBy: filteredBY,
      page: page
    };

    $.ajax({
      type: 'post',
      url: ajaxURL,
      data: ajax_data,
      success: function (data_res) {
        var returnedData = JSON.parse(data_res);
        $('.reviewer-single-info-cont').append(returnedData.data);
        $(that).text('Load More');
        $(that).attr('data-current-page', page)
        if (total_page == page) {
          $('.dom767-load-more-review').fadeOut();
        }
        $(".comments-single-info").each(function(){
          $(".comments-single-info:first-child").css('display', 'inline-flex');
        });
      }
    });

    e.preventDefault();
  });


  /*************************************Revuiew filter ************************************/

  $(document).on('change', 'input.review_filter_checkbox',function(e){

    $('.review_list_loader').fadeIn();
    $('input.review_filter_checkbox').not(this).prop('checked', false); 
    $('input.review_filter_checkbox').parent().css('background-color', '#fff');
     
    if ($(this).is(':checked')){
      filteredBY = $(this).val();
      $(this).parent().css('background-color', '#ddd');
    }else{
      filteredBY = 'NULL';
      $(this).parent().css('background-color', '#fff');
    }
    var post_id       = $(this).attr('data-post-id');
    var post_id       = parseInt(post_id);
    var that          = $(this);

    var ajax_data = {
      action: "review_filter",
      security: dom_review_list.security,
      post_id: post_id,
      filteredBy: filteredBY,
      page: page_no
    };

    $.ajax({
      type: 'post',
      url: ajaxURL,
      data: ajax_data,
      success: function (data_res) {
        var returnedData = JSON.parse(data_res);
        $('.reviewer-single-info-cont').html(returnedData.data);
        $('.review_list_loader').fadeOut(); 
        $(".comments-single-info").each(function(){
          $(".comments-single-info:first-child").css('display', 'inline-flex');
        });
      }
    });

    e.preventDefault();
  });




  /**************************************************************************/
  $(document).on('click', '.review_alert_close',function(e){
    //$(this).parent().fadeOut();
    $(this).parent().remove();
    e.preventDefault();
  });  



});