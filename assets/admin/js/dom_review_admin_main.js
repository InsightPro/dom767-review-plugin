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

	$(document).ready(function () {
    	// Setup - add a text input to each footer cell
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
  
});//////////////////////////////////// THE END ////////////////////////////////////////
