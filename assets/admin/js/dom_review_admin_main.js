jQuery(document).ready(function ($) {

	/************************************** Get Ajax URL********************************/
  	var ajaxURL = dom_admin_review_list.ajax_url;
  	if (dom_admin_review_list.ajax_url.includes("mydashboard")) {
    	ajaxURL = dom_admin_review_list.ajax_url.replace("mydashboard", "wp-admin");
  	}
  	/************************************************************************************/

  	/***************************************data Table************************************/
  	/*$(document).ready(function() {
	    $('#dom767_review_list_admin').DataTable({
	    	"ordering": false
	    });
	});*/	


	function datatablefilter() {
    	// Setup - add a text input to each footer cell
		$(".admin-review-edit-modal").on('shown.bs.modal', function() {
		  $('.modal-backdrop').css('background', '#00000073');
		});	

		$(".admin-review-media-modal").on('shown.bs.modal', function() {
		  $('.modal-backdrop').css('background', '#00000073');
		});
		
	    $('#dom767_review_list_admin thead tr').clone(true).addClass('rev_table_cell_filters').prependTo('#dom767_review_list_admin thead');
	 
	    var table = $('#dom767_review_list_admin').DataTable({
	        orderCellsTop: true,
	        fixedHeader: true,
	        "ordering": false,
	        initComplete: function () {
	            var api = this.api();
	            // For each column
	            api.columns().eq(0).each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.rev_table_cell_filters th:eq(3),th:eq(4),th:eq(5)').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
                    $(cell).css('width','150px');
                    $(cell).find('input').css('width','150px');
	 
	                    // On every keypress in this input
                    $('input', $('.rev_table_cell_filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                        e.stopPropagation();

                        // Get the search value
                        $(this).attr('title', $(this).val());
                        var regexr = '({search})'; //$(this).parents('th').find('select').val();

                        var cursorPosition = this.selectionStart;
                        // Search the column for that value
                        api.column(colIdx).search(this.value != ''? regexr.replace('{search}', '(((' + this.value + ')))'): '', this.value != '', this.value == '').draw();

                        $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                    });
	            });
	        },
	    });
    //do stuff
	}

	$(document).ready(function () {
		datatablefilter();
	});
  	/************************************************************************************/


  	////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////

  	$(document).on('click', '.review_admin_paginations', function review_admin_paginations_num(e){

  		var default_page  = 1;
    	var that          = $(this);
    	var current_page  = $(this).attr("data-page");
    	var page          = parseInt(current_page)+parseInt(default_page);
    	//console.log(current_page);

    	$(".admin_review_loadmore_loading_div").fadeIn();
    	$('.review_admin_paginations').removeClass('active_btn');
    	var pagi_id = $(this).attr("id");
    	 $('#'+pagi_id).addClass('active_btn');
	    ///////////loadpore post by ajax//////////
		var ajax_data = {
		  action: 		"admin_all_review_post_loadmore",
		  security: 	dom_admin_review_list.security,
		  page: 		page,
		  current_page: current_page,
		};

		$.ajax({
			type: 	"post",
			url: 	ajaxURL,
			data: 	ajax_data,
			beforeSend: function () {
			  
			},
			success: function (data_res) {
			  //console.log(page);
			  var isFindInArr   = JSON.parse(data_res);
			  $(".admin_review_loadmore_loading_div").fadeOut();
			  $(".review_admin_paginations_pre").attr("data-page",current_page);
			  $(".review_admin_paginations_next").attr("data-page",current_page);
			  $(".post_review_count_admin_table").html(isFindInArr.data);
			},
		});
		///////////end loadpore post by ajax//////////

      	//e.preventDefault();

  	});


  	////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////

  	$(document).on('click', '.review_admin_paginations_pre', function review_admin_paginations_pre(e){

  		var default_page  = 1;
    	var that          = $(this);
    	var current_page  = $(this).attr("data-page");
    	var page          = parseInt(current_page)+parseInt(default_page);
    	//console.log(current_page);

    	$(".admin_review_loadmore_loading_div").fadeIn();
	    ///////////loadpore post by ajax//////////
		var ajax_data = {
		  action: 		"admin_pre_review_post_loadmore",
		  security: 	dom_admin_review_list.security,
		  page: 		page,
		  current_page: current_page,
		};

		$.ajax({
			type: 	"post",
			url: 	ajaxURL,
			data: 	ajax_data,
			beforeSend: function () {
			  
			},
			success: function (data_res) {
			  //console.log(page);
			  var isFindInArr   = JSON.parse(data_res);
			  $('.review_admin_paginations').removeClass('active_btn');
			  $('#review_admin_paginations'+isFindInArr.current_page).addClass('active_btn');
			  $(".admin_review_loadmore_loading_div").fadeOut();
			  $(".post_review_count_admin_table").html(isFindInArr.data);
			  $(".review_admin_paginations_pre").attr("data-page",isFindInArr.current_page);
			  $(".review_admin_paginations_next").attr("data-page",isFindInArr.current_page);
			},
		});
		///////////end loadpore post by ajax//////////

      	//e.preventDefault();

  	});



  	////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////

  	$(document).on('click', '.review_admin_paginations_next', function review_admin_paginations_next(e){

  		var default_page  = 1;
    	var that          = $(this);
    	var current_page  = $(this).attr("data-page");
    	var page          = parseInt(current_page)+parseInt(default_page);
    	//console.log(current_page);

    	$(".admin_review_loadmore_loading_div").fadeIn();
	    ///////////loadpore post by ajax//////////
		var ajax_data = {
		  action: 		"admin_next_review_post_loadmore",
		  security: 	dom_admin_review_list.security,
		  page: 		page,
		  current_page: current_page,
		};

		$.ajax({
			type: 	"post",
			url: 	ajaxURL,
			data: 	ajax_data,
			beforeSend: function () {
			  
			},
			success: function (data_res) {
			  //console.log(page);
			  var isFindInArr   = JSON.parse(data_res);
			  $('.review_admin_paginations').removeClass('active_btn');
			  $('#review_admin_paginations'+isFindInArr.current_page).addClass('active_btn');
			  $(".admin_review_loadmore_loading_div").fadeOut();
			  $(".post_review_count_admin_table").html(isFindInArr.data);
			  $(".review_admin_paginations_pre").attr("data-page",isFindInArr.current_page);
			  $(".review_admin_paginations_next").attr("data-page",isFindInArr.current_page);
			},
		});
		///////////end loadpore post by ajax//////////

      	//e.preventDefault();

  	});




  	////////////////////////////////////////////////////////////////////////////////////////
  	///////////////////////////// admin review post paginations ///////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////

  	$(document).on('click', '.review_admin_paginations', function review_admin_pagi_num_count(e){

  		var default_page  = 1;
    	var that          = $(this);
    	var current_page  = $(this).attr("data-page");
    	var total_page  = $(this).attr("data-total_page");
    	var page          = parseInt(current_page)+parseInt(default_page);
    	//console.log(current_page);

    	$(".admin_review_loadmore_loading_div").fadeIn();
	    ///////////loadpore post by ajax//////////
		var ajax_data = {
		  action: 		"review_admin_pagi_num_count_20",
		  security: 	dom_admin_review_list.security,
		  page: 		page,
		  current_page: current_page,
		  total_page: total_page,
		};

		$.ajax({
			type: 	"post",
			url: 	ajaxURL,
			data: 	ajax_data,
			beforeSend: function () {
			  
			},
			success: function (data_res) {
			  //console.log(page);
			  var isFindInArr   = JSON.parse(data_res);
			  $('.review_admin_paginations_ul').html(isFindInArr.data);
			  $('.review_admin_paginations').removeClass('active_btn');
			  $('#review_admin_paginations'+isFindInArr.current_page).addClass('active_btn');

			},
		});
		///////////end loadpore post by ajax//////////

      	//e.preventDefault();

  	});

  	//////////////////////////////////////////////////////////////////////////////////////
  	//////////////////////////// delete review from admin by ajax ////////////////////////
  	//////////////////////////////////////////////////////////////////////////////////////


  	$(document).on('click', '.dom767_adminReviewdelete', function adminReviewdelete(e){
  		var review_id 	= $(this).parents().attr('data-review-id');
  		var type 		= $(this).parents().attr('data-review-type');
  		var that		= $(this);
  		$(that).text('Deleting..');

  		var ajax_data ={
		  	action: "dom767_adminReviewdelete",
		  	security: dom_admin_review_list.security,
		  	review_id: review_id,
		  	type: type
		};

		$.ajax({
			type: 	"post",
			url: 	ajaxURL,
			data: 	ajax_data,
			beforeSend: function () {
			  
			},
			success: function (data_res) {
			  	var isFindInArr   = JSON.parse(data_res);
			  	$('.admin-all-reviewpage-rev-table').html(isFindInArr.data);
			 	datatablefilter();
			},
		});
		//e.preventDefault();
  	});



  	/////////////////////////////////////////////////////////////////////////////////////
  	//////////////////////////// Delete admin review media /////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////

  	$(document).on('click', '.dom767_adminReviewMedia', function adminReviewMediabtn(e){
  		var review_id 	= $(this).attr('data-review-id');
  		var url 		= $(this).attr('data-url');
  		var name 		= $(this).attr('data-name');
  		var that		= $(this);
  		$(this).parents('.dom767_adminReviewMediaSingle').fadeOut();
  		$('#dom767_admin_review_media_form').find('input[name="review_id"]').val(review_id);
  		$('#dom767_admin_review_media_form').find('input[name="media-url"]').val(url);
  		$('#dom767_admin_review_media_form').find('input[name="media-name"]').val(name);
  		$('#dom767_admin_review_media_form').find('img').attr('src',url);
  		$('.mediaModalMediaName').text(name);

		e.preventDefault();
  	});

  	$('#admin_review_media_form_update_btn').on('click', function(event) {
  		var form = $('form#dom767_admin_review_media_form');
    	form.find('input[type=submit]').click();
  	});	   	

  	$(document).on('submit', '#dom767_admin_review_media_form', function adminReviewMediaSubmit(e){
  		e.preventDefault();
  		dataObj = {};
  		var form_data = $('#dom767_admin_review_media_form').serializeArray();
	    $(form_data).each(function(i, field){
	      dataObj[field.name] = field.value;
	    });

	    var review_id 	= dataObj['review_id'];
	    var media_url 	= dataObj['media-url'];
	    var media_name 	= dataObj['media-name'];


	    var ajax_data ={
		  	action: "dom767_adminReviewMedia",
		  	security: dom_admin_review_list.security,
		  	review_id: review_id,
		  	media_url: media_url,
		  	media_name: media_name
		};

		$.ajax({
			type: 	"post",
			url: 	ajaxURL,
			data: 	ajax_data,
			beforeSend: function () {
			  
			},
			success: function (data_res) {
			  	var isFindInArr   = JSON.parse(data_res);
			  	$('.admin-all-reviewpage-rev-table').html(isFindInArr.data);
			 	datatablefilter();
			},
		});

  	});


  	$('.close_media_modal').on('click', function(event) {
  		$('.dom767_adminReviewMediaSingle').fadeIn(1);
  	});	  	

  	/////////////////////////////////////////////////////////////////////////////////////
  	//////////////////////////// Edit review from admin by ajax ////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////
  	$('.close_edit_modal').on('click', function(event) {
  		$('.dom767_adminReviewEdit').text('Edit');
  	});	  	


  	$(document).on('click', '.dom767_adminReviewEdit', function adminReviewEditbtn(e){
  		$(this).text('waite..');
  		var review_id 	= $(this).parents().attr('data-review-id');
  		var type 		= $(this).parents().attr('data-review-type');
  		var that		= $(this);
  		var this_tr 	= $(this).parents('td').parents('tr');
  		var rating 		= $(this_tr).find('td:nth-child(6)').text();
  		var content 	= $(this_tr).find('td:nth-child(7)').text();
  		$('#dom767_admin_review_edit_form').find('input[name="review_id"]').val(review_id);
  		$('#dom767_admin_review_edit_form').find('input[name="review_type"]').val(type);
  		if (type == 'review') {
  			$('#dom767_admin_review_edit_form').find('input[name="rating"]').css("display","block");
  			$('#dom767_admin_review_edit_form').find('input[name="rating"]').attr("value",rating);
  		}else{
  			$('#dom767_admin_review_edit_form').find('input[name="rating"]').css("display","none");
  		}
  		$('#dom767_admin_review_edit_form').find('textarea').text(content);

		e.preventDefault();
  	});
 
  	////////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////// admin review edit form submit ///////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////////

  	$('#admin_review_edit_form_update_btn').on('click', function(event) {

  		var form = $('form#dom767_admin_review_edit_form');
    	form.find('input[type=submit]').click();
  		//event.preventDefault();
  	});	   	


  	$(document).on('submit', '#dom767_admin_review_edit_form', function adminReviewEditSubmit(e){
  		e.preventDefault();
  		dataObj = {};
  		var form_data = $('#dom767_admin_review_edit_form').serializeArray();
	    $(form_data).each(function(i, field){
	      dataObj[field.name] = field.value;
	    });

	    var review_id 	= dataObj['review_id'];
	    var type 		= dataObj['review_type'];
	    var rating 		= dataObj['rating'];
	    var content 	= dataObj['content'];

	    var ajax_data ={
		  	action: "dom767_adminReviewEdit",
		  	security: dom_admin_review_list.security,
		  	review_id: review_id,
		  	type: type,
		  	rating: rating,
		  	content: content,
		};

		$.ajax({
			type: 	"post",
			url: 	ajaxURL,
			data: 	ajax_data,
			beforeSend: function () {
			  
			},
			success: function (data_res) {
			  	var isFindInArr   = JSON.parse(data_res);
			  	$('.admin-all-reviewpage-rev-table').html(isFindInArr.data);
			 	datatablefilter();
			 	$('.dom767_adminReviewEdit').text('Edit');
			},
		});

  	});


  	////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////
  	////////////////////////////////////////////////////////////////////////////////////////
  	$(document).on('click', '.dom767_adminReviewAprove', function adminReviewAprove(e){

  		var review_id 	= $(this).parents().attr('data-review-id');
  		var type 		= $(this).parents().attr('data-review-type');
  		var status 		= $(this).text();
  		var that		= $(this);
  		$(this).text('waite..');

  		var ajax_data ={
		  	action: "dom767_adminReviewAprove",
		  	security: dom_admin_review_list.security,
		  	review_id: review_id,
		  	type: type,
		  	status: status
		};

		$.ajax({
			type: 	"post",
			url: 	ajaxURL,
			data: 	ajax_data,
			beforeSend: function () {
			  
			},
			success: function (data_res) {
			  	var isFindInArr   = JSON.parse(data_res);
			  	$('.admin-all-reviewpage-rev-table').html(isFindInArr.data);
			 	datatablefilter();
			},
		});
  		//event.preventDefault();
  	});	
  
});//////////////////////////////////// THE END ////////////////////////////////////////
