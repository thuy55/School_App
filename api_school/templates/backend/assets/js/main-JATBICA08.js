$(document).ready(function() {
	  var timeout = null;
	  var doneTypingInterval = 500;
	  var pjax = new Pjax({
			 elements: ".pjax-load",
			 selectors: [
			 ".eclo-content",
			 ".notification",
			 ],
			 cacheBust: false,
	  });
	  topbar.config({
			barColors    : {
			  '0'        : 'rgba(44, 124, 253, .5)',
			  '.3'       : 'rgba(44, 124, 253, .5)',
			  '1.0'      : 'rgba(44, 124, 253, .5)'
			},
			className    : 'topbar',
	  });
	  function whenDOMReady() {
			 $(".select2").select2(); 
			 $('.daterange-select').daterangepicker({
					  opens: 'left',
					 ranges   : {
						'Hôm nay'       : [moment(), moment()],
						'Hôm qua'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'7 ngày trước' : [moment().subtract(6, 'days'), moment()],
						'30 ngày trước': [moment().subtract(29, 'days'), moment()],
						'Trong tháng'  : [moment().startOf('month'), moment().endOf('month')],
						'Tháng trước'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					 },
					 locale: {
						  format: 'DD/MM/YYYY',
					 }
						  });
						  var ratings = document.getElementsByClassName('star-rating');
					  for (var i = 0; i < ratings.length; i++) {
							var r = new SimpleStarRating(ratings[i]);
					  }
						  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
						  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
							 return new bootstrap.Tooltip(tooltipTriggerEl);
						  });
						  var toastElList = [].slice.call(document.querySelectorAll('.toast'));
						  var toastList = toastElList.map(function (toastEl) {
							 return new bootstrap.Toast(toastEl);
						  });
						  function previewFile(input){
						var file = $("input[type=file]").get(0).files[0];
						if(file){
							 var reader = new FileReader();
							 reader.onload = function(){
								  $("#preview-data").attr("src", reader.result);
							 }
							 reader.readAsDataURL(file);
						}
				  }
						  $('.number').toArray().forEach(function (field) {
						 new Cleave(field, {
							  numeral: true,
							numeralThousandsGroupStyle: 'thousand'
						 });
					  });
						  var pjax_link = new Pjax({
								 elements: ".pjax-content",
								 selectors: [
								 ".pjax-content-load",
								 ".notification",
								 ],
								 cacheBust: false,
								 scrollTo : false,
						  });
						  $pjax_link = pjax_link;
						  var message_chat = new Pjax({
								elements: ".pjax-message",
								selectors: [
								  ".pjax-message-load",
								  // ".notification",
								],
								cacheBust: false,
								scrollTo : false,
						  });
	  }
	  function errorload(){
			 Swal.fire({
					title: 'Rất tiếc, chúng tôi không tìm thấy',
					text:'Đây không phải là lỗi, Chỉ là đường dẫn bạn yêu cầu không được tìm thấy hoặc bạn không có quyền truy cập vào đường dẫn này',
					imageUrl: '/templates/backend/assets/img/something-lost.png',
					showCancelButton: false,
					buttonsStyling: false,
					showConfirmButton: false,
		  });
	  }
	  whenDOMReady();
	  $(document).on('pjax:send', topbar.show);
	  $(document).on('pjax:complete', topbar.hide);
	  $(document).on('pjax:success', whenDOMReady);
	  $(document).on('pjax:error', errorload);
	  $(document).on('click','#menu-toggle',function (e){
			$('body').toggleClass('nav-menu-small');
			if($('body').hasClass('nav-menu-small')){
			 var skinClass = 'nav-menu-small';
			}
			else {
			 var skinClass = '';
			}
			$.ajax({
			  url: '/skin/mode/',
			  type: 'POST',
			  data: {'skin':skinClass},
			});
	  }); 
	  $(document).on('click','#menu-toggle-skin',function (e){
			$('body').toggleClass('eclo-dark');
			if ($('body').hasClass('eclo-dark')){
					$(this).find("i.fas").removeClass('fa-moon').toggleClass('fa-sun');
					var skinClass = 'eclo-dark';
			}
			else {
					$(this).find("i.fas").removeClass('fa-sun').toggleClass('fa-moon');
					var skinClass = '';
			}
			$.ajax({
			  url: '/skin/dark/',
			  type: 'POST',
			  data: {'skin':skinClass},
			});
	  });
	  $(document).on('click','#menu-toggle-mobile',function (e){
			$('body').toggleClass('nav-menu-mobile');
	  }); 
	  $(document).on("click",'.nav-menu-sub-link , .nav-menu-link',function(){
			 if($('body').hasClass('nav-menu-mobile')){
					var $mobile = $(this).attr("data-bs-toggle");
					if($mobile!='collapse'){
						  $('body').removeClass('nav-menu-mobile');
					}
			}
			 $('.nav-menu-sub-link').removeClass("active");         
			 $('.nav-menu-link').removeClass("active");        
			 $(this).addClass("active");        
			 $(this).parents('.nav-menu-item').find(".nav-menu-link").addClass("active");         
	  });
	  $(document).on('change', '.selectall',function() {
			$('input.checker').prop('checked', this.checked);
	  });
  $(document).on('change','.permission-all', function() {
			$('input.permission-item').prop('checked', this.checked);
	  });
	  $(document).on("click",'.update-status',function(){
		 var $this = $(this);
		url = $(this).attr("data-status");
		 $this.attr('disabled','disabled');
		$.ajax({
			 url: url,
			 type: 'POST',
			 context: this,
			 success: function(string){
				  var getData = JSON.parse(string);
				  if(getData.status=='success'){
					 Swal.fire({
							 text: getData.content,
							 icon: 'success',
							 buttonsStyling: false,
							 confirmButtonText: "OK",
							 customClass: {
								  confirmButton: "btn font-weight-bold btn-primary"
							 }
						});
						$this.removeAttr('disabled','disabled');
				  } else {
					 Swal.fire({
						 text: getData.content,
						 icon: 'error',
						 showCancelButton: false,
						 buttonsStyling: false,
						 confirmButtonText: "Ok",
						 customClass: {
							  confirmButton: "btn font-weight-bold btn-danger"
						 }
					  });
					  $this.removeAttr('disabled','disabled');
				  }
			 },
		});
	  });
	  $(document).on('click','.modal-url',function(event){
			 var $this = $(this);
			 $this.removeClass("modal-url");
			 topbar.show();
			 var url = $(this).attr('data-url');
			 var array = $(this).attr('data-array');
			 if(array=='true'){
			 if ($("input.checker:checked").length > 0) {    
						  var boxid = [];
					$('.checker:checkbox:checked').each(function(i){
						  boxid[i] = $(this).val();
					});
					url = url+boxid;
			 }
			 else {
						  Swal.fire({
						 text:'Vui lòng chọn dữ liệu',
						 icon: 'error',
						 showCancelButton: false,
						 buttonsStyling: false,
						 confirmButtonText: "Ok",
						 customClass: {
							  confirmButton: "btn font-weight-bold btn-danger"
						 }
					});
						  $this.addClass("modal-url");
						  topbar.hide();
				 }
			 }
			 if($(".modal-views").length==0){
			 $('<div class="modal-views"></div>').appendTo('body');
			 }
			 $('.modal-views').load(url, function(response, status, req) {
			 if(status=="error"){
						  $('.modal-views').remove();
						  $('.modal-load').modal('hide');
						  $this.addClass("modal-url");
						  topbar.hide();
						  errorload();
			 }
			 else {
					$('select.select2:not(.normal)').each(function () {
							  $(this).select2({
									dropdownParent: $(this).parent().parent()
							  });
						 });
						 $('.number').toArray().forEach(function (field) {
								new Cleave(field, {
									 numeral: true,
								  numeralThousandsGroupStyle: 'thousand'
								});
						});
						  $('.modal-load').modal('show');
						  $('.modal-load').on('shown.bs.modal', function (e) {
						  topbar.hide();
						  });
						  $('.ajax-form').submit(function (e){
								 e.preventDefault();
										e.stopImmediatePropagation();
						  var formData = new FormData($(this)[0]);
						  $('.ajax-submit').attr('disabled','disabled');
						  $('.ajax-submit .spinner-button').show();
						  $('.ajax-submit .name-button').hide();
						  topbar.show();
						  $.ajax({
										xhr: function() {
									 var xhr = new window.XMLHttpRequest();
									 xhr.upload.addEventListener(topbar.show(), function(evt) {
									 }, false);
									 return xhr;
								  },
								  type:'POST',
								  url: url,
								  data: formData,
								  cache:false,
								  contentType: false,
								  processData: false,
								  success:function(string){
										var getData = JSON.parse(string);
										 if(getData.status=='error'){
											  topbar.hide();
											  Swal.fire({
													text: getData.content,
													icon: 'error',
													showCancelButton: false,
													buttonsStyling: false,
													confirmButtonText: "Ok",
													customClass: {
														 confirmButton: "btn font-weight-bold btn-danger"
													}
												 });
											  $('.ajax-submit').removeAttr('disabled','disabled');
											  $('.ajax-submit .spinner-button').hide();
											  $('.ajax-submit .name-button').show();
										 }
										 if(getData.status=='success'){
											  topbar.hide();
																		 pjax.loadUrl('');
											  Swal.fire({
														text: getData.content,
														icon: 'success',
														buttonsStyling: false,
														confirmButtonText: "OK",
														customClass: {
															 confirmButton: "btn font-weight-bold btn-primary"
														}
												  }).then(function(isConfirm) {
														if(isConfirm){ 
														  $('.modal-load').modal('hide');
																  $('.modal-views').remove();
																  $this.addClass("modal-url");
														} 
												  });
										 }
								  }
						  });
						  return false;
						  }); 
						  
			 } 
			 }).on('hidden.bs.modal', function (e) {
			 $('.modal-load').modal('hide');
			 $('.modal-views').remove();
			 $this.addClass("modal-url");
			 whenDOMReady();
			 });
	  });
	  $(document).on("click",'.page-row',function(){
		 var $this = $(this);
				row = $this.attr("data-row");
		$.ajax({
			 url: /row/,
			 type: 'POST',
			 data: {'page':row},
			 context: this,
			 success: function(string){
				  var getData = JSON.parse(string);
				  if(getData.status=='success'){
					 pjax.loadUrl('');
				  } else {
					 Swal.fire({
						 text: getData.content,
						 icon: 'error',
						 showCancelButton: false,
						 buttonsStyling: false,
						 confirmButtonText: "Ok",
						 customClass: {
							  confirmButton: "btn font-weight-bold btn-danger"
						 }
					  });
				  }
			 },
		});
	  }); 
	  $(document).on("change",".preview-images .getImg",function(){
			 var file = $('.preview-images .getImg').get(0).files[0];
		  if(file){
				var reader = new FileReader();
				reader.onload = function(){
					 $(".preview-images #preview-data").attr("src", reader.result);
					 $(".preview-images #preview-data").show();
				}
				reader.readAsDataURL(file);
		  }
	  });
	  $(document).on("change",'.areas-province',function() {
			var value = $(this).val();
			  data = $(this).attr("data-name");
			$.ajax({
					url: '/district/',
					type: 'POST',
					data: {'value':value},
					  context: this,
					success: function(string){
						 var getData = JSON.parse(string);
						 if(getData.status=='success'){
					$(this).parents('.select-areas').find('.areas-district').html(getData.html);
					$(this).parents('.select-areas').find('.areas-district').val('');
					$(this).parents('.select-areas').find('.areas-ward').val('');
						 }
					},
			  });
	  });
	  $(document).on("change",'.areas-district',function() {
			var value = $(this).val();
			  data = $(this).attr("data-name");
			$.ajax({
					url: '/ward/',
					type: 'POST',
					data: {'value':value},
					  context: this,
					success: function(string){
						 var getData = JSON.parse(string);
						 if(getData.status=='success'){
					$(this).parents('.select-areas').find('.areas-ward').html(getData.html);
					$(this).parents('.select-areas').find('.areas-ward').val('');
						 }
					},
			  });
	  });
	  $(document).on("change",'.change-update',function() {
			var $this = $(this);
			 $url = $this.attr("data-url");
			 $value = $this.val();
			 $load = $this.attr("data-load");
			 $.ajax({
						  url: $url,
						  type: 'POST',
						  data: {'value':$value,},
					  context: this,
						  success: function(string){
						  var getData = JSON.parse(string);
						  if(getData.status=='success'){
								 if($load!='false'){
													 pjax.loadUrl('');
											  }
						  }
						  else {
								 Swal.fire({
										text: getData.content,
										icon: 'error',
										showCancelButton: false,
										buttonsStyling: false,
										confirmButtonText: "Ok",
										customClass: {
										confirmButton: "btn font-weight-bold btn-danger"
								 }
							 });
						 }
					},
					});
					if($load!='false'){
						  $this.val("");
					}
	  });
	  $(document).on('focus','.blur-update',function(){
		var $thiscosting = $(this);
		$thiscosting.data('before', $thiscosting.val());
		return $thiscosting;
  });
	  $(document).on("blur",'.blur-update',function() {
			  var $thiscosting = $(this);
			  if ($thiscosting.data('before') !== $thiscosting.val()) {
			 var $this = $(this);
			 $url = $this.attr("data-url");
			 $value = $this.val();
			 $load = $this.attr("data-load");
			 $.ajax({
					url: $url,
					type: 'POST',
					data: {'value':$value,},
				context: this,
					success: function(string){
					var getData = JSON.parse(string);
					if(getData.status=='success'){
										if($load!='false'){
											  pjax.loadUrl('');
										}
					}
					else {
						  Swal.fire({
								 text: getData.content,
								 icon: 'error',
										showCancelButton: false,
								 buttonsStyling: false,
								 confirmButtonText: "Ok",
								 customClass: {
								 confirmButton: "btn font-weight-bold btn-danger"
						  }
					  });
				  }
					},
			 });
		  }
	  });
	  $(document).on("click",'.click-update',function() {
			 var error = confirm("Bạn có thật sự muốn thực hiện thao tác này");
			 if (error == true) {
				  var $this = $(this);
					$url = $this.attr("data-url");
					$this.attr('disabled','disabled');
					$load = $this.attr("data-load");
					$.ajax({
					url: $url,
					type: 'POST',
				context: this,
					success: function(string){
					var getData = JSON.parse(string);
					if(getData.status=='success'){
								 if($load!='false'){
										pjax.loadUrl($load);
								 }
								 $this.removeAttr('disabled','disabled');
								 if($('body').hasClass("modal-open")){
										$('.modal-load').modal('hide');
													$('.modal-views').remove();
								 }
					}
					else {
						  Swal.fire({
						  text: getData.content,
						  icon: 'error',
								 showCancelButton: false,
						  buttonsStyling: false,
						  confirmButtonText: "Ok",
						  customClass: {
						confirmButton: "btn font-weight-bold btn-danger"
						  }
						  });
						  $this.removeAttr('disabled','disabled');
					}
					},
					 });
			 }
	  });
	  $(document).on("click",'.click-action',function() {
			 var error = confirm("Bạn có thật sự muốn thực hiện thao tác này");
			 if (error == true) {
				  var $this = $(this);
				  $url = $this.attr("data-url");
				  $this.attr('disabled','disabled');
				  topbar.show();
				  $.ajax({
			 url: $url,
			 type: 'POST',
			 context: this,
			 success: function(string){
				var getData = JSON.parse(string);
				if(getData.status=='success'){
					$this.parents("tr").remove();
								 pjax.loadUrl('');
								 Swal.fire({
						  text: getData.content,
						  icon: 'success',
								 showCancelButton: false,
						  buttonsStyling: false,
						  confirmButtonText: "Ok",
						  customClass: {
					 confirmButton: "btn font-weight-bold btn-danger"
						  }
						  });
						  $this.removeAttr('disabled','disabled');
						  topbar.hide();
				}
				else {
						  Swal.fire({
						  text: getData.content,
						  icon: 'error',
								 showCancelButton: false,
						  buttonsStyling: false,
						  confirmButtonText: "Ok",
						  customClass: {
					 confirmButton: "btn font-weight-bold btn-danger"
						  }
						  });
						  $this.removeAttr('disabled','disabled');
				}
			 },
				  });
			 }
	  });
	  $(document).on("click",'.click-url',function() {
		  var $this = $(this);
		  $url = $this.attr("data-url");
		  $load = $this.attr("data-load");
		  $this.attr('disabled','disabled');
		  topbar.show();
		  $.ajax({
			 url: $url,
			 type: 'POST',
			 context: this,
			 success: function(string){
				var getData = JSON.parse(string);
				if(getData.status=='success'){
					// if($load!='false'){
						pjax.loadUrl('');
					// }
					$this.removeAttr('disabled','disabled');
					topbar.hide();
				}
				else {
					Swal.fire({
						text: getData.content,
						icon: 'error',
						showCancelButton: false,
						buttonsStyling: false,
						confirmButtonText: "Ok",
						customClass: {
					 		confirmButton: "btn font-weight-bold btn-danger"
						}
					});
					$this.removeAttr('disabled','disabled');
				}
			 },
		  });
	  });
	   $(document).on("change",'.change-upload',function() {
		  	var formData = new FormData();
		  	var $this = $(this);
		  	$url = $this.attr("data-url");
		  	$load = $this.attr("data-load");
		    formData.append('value', $(this)[0].files[0]);
		  	$.ajax({
				 url: $url,
				 type: 'POST',
				 data: formData,
			    processData: false,
			    contentType: false,
				 context: this,
				 success: function(string){
					var getData = JSON.parse(string);
					if(getData.status=='success'){
						if($load!='false'){
							  pjax.loadUrl('');
						}
					}
					else {
						Swal.fire({
							text: getData.content,
							icon: 'error',
							showCancelButton: false,
							buttonsStyling: false,
							confirmButtonText: "Ok",
							customClass: {
						 		confirmButton: "btn font-weight-bold btn-danger"
							}
						});
					}
				 },
		  	});
	  });
	  $(document).on('change','.search-form input, .search-form select',function(){
		var $thiscosting = $(this);
		$thiscosting.data('before', $thiscosting.val());
		return $thiscosting;
  });
	  $(document).on("keyup",'.search-form input, .search-form select',function(){
			 var $thiscosting = $(this);
			 if ($thiscosting.data('before') !== $thiscosting.val()) {
					clearTimeout(timeout);
		var url  = window.location.pathname; 
					var form = $(this).parents(".search-form").serialize();
					if ($('.search-form input, .search-form select').val) {
				 timeout = setTimeout(function(){
										$pjax_link.loadUrl(url+'?'+form);
				 }, doneTypingInterval);
			}
			 }
	  });
	  $(document).on("change",".filler-select",function(){
			 var key = $(this).val();
			 $(this).parents('.filler-details').find(".filer-item").hide();
			 $(this).parents('.filler-details').find("."+key).show();
	  });
	  $(document).on("click",".filler-add",function(){
			 $(this).parents(".search-form").find(".filler").click();
	  });
	  $(document).on("click",'.filler-cancel',function(){
			 $(this).parents(".search-form").find(".filler").click();
	  });
	  $(document).on("click",'.pjax-notification',function() {
			 var active = $(this).attr("data-active");
			 $.ajax({
		url: '/admin/notification-views/'+active+'/',
		type: 'POST',
		context: this,
	 });
	  });
  $(document).on("submit",'.login-form',function (e){
	 e.preventDefault();
	 e.stopImmediatePropagation();
	 var formData = new FormData($(this)[0]);
	 $('.login-submit').attr('disabled','disabled');
	 $.ajax({
		type:'POST',
		url: '/login/',
		data: formData,
		cache:false,
		contentType: false,
		processData: false,
		success:function(string){
		  var getData = JSON.parse(string);
		  if(getData.status=='error'){
				$('.login-submit').removeAttr('disabled','disabled');
				Swal.fire({
				  text: getData.content,
				  icon: 'error',
				  showCancelButton: false,
				  buttonsStyling: false,
				  confirmButtonText: "Ok",
				  customClass: {
						confirmButton: "btn font-weight-bold btn-danger"
				  }
				});
		  }
		  if(getData.status=='success'){
			 Swal.fire({
				text: getData.content,
				icon: 'success',
				buttonsStyling: false,
				confirmButtonText: "Truy cập ngay",
				customClass: {
					 confirmButton: "btn font-weight-bold btn-primary"
				}
			 }).then(function(isConfirm) {
				if(isConfirm){ 
				  window.location.href = '/';
				} 
			 });
		  }
		}
	 });
	 return false;
  }); 
	  $(document).on('keypress','.message-content',function (e) {
				if (e.which == 13) {
				  $('.message-send').click();
				  $(this).val("");
				}
	  });
	  $(document).on("click",'.message-send',function(){
					var active = $(this).parents(".message-form").attr("data-active");
					var content = $(this).parents(".message-form").find(".message-content").val();
					$(this).attr('disabled','disabled');
					 $.ajax({
					url: '/chat/send/'+active+'/message/',
					type: 'POST',
					data: {content:content},
					context: this,
					success: function(string){
						 var getData = JSON.parse(string);
						 if(getData.status=='success'){
															$(this).parents(".message-main").find(".message-content").val("");
										$(this).removeAttr('disabled','disabled');
													 $('.chat-content').append('<div class="d-block mb-2 text-end"><div class="bg-light p-2 pe-3 ps-3 rounded-3 d-inline-block">'+content+'</div></div>');
															$(".chat-content").animate({
								 scrollTop: $(
									'.chat-content').get(0).scrollHeight
							}, 0);
													 $pjax_link.loadUrl('');
						 } else {
						  Swal.fire({
									  text:'Lỗi kết nối dữ liệu',
									  icon: 'error',
									  showCancelButton: false,
									  buttonsStyling: false,
									  confirmButtonText: "Ok",
									  customClass: {
											confirmButton: "btn font-weight-bold btn-danger"
									  }
								 });
										$(this).removeAttr('disabled','disabled');
						 }
					},
			  });
	  });
	  $(document).on("click",".social-submit",function(){
					var formData = new FormData();
					var $$this = $(this);
					var content = $(this).parents(".social-form").find(".social-content").html();
					var tokens = $(this).parents(".social-form").find("input[name='token']").val();
					var getfiles = $(this).parents(".social-form").find("input[name='files[]']");
			 // formData.append('files', getfiles[0].files[0]); 
			 formData.append('content', content); 
			 formData.append('token', tokens); 
			 formData.append('test', 'test'); 
					$.each(getfiles,function(i, obj) {
					$.each(obj.files,function(j,file){
					formData.append('files['+j+']', file);
			 });
		});
					$('.social-submit').attr('disabled','disabled');
		$('.social-submit .spinner-button').show();
		$('.social-submit .name-button').hide();
					$.ajax({
		  type:'POST',
		  url: "/social/social-add/",
		  data: formData,
		  processData: false, // tell jQuery not to process the data
			 contentType: false, // tell jquery not to set content type
		  success:function(string){
			  var getData = JSON.parse(string);
			  if(getData.status=='error'){
				  Swal.fire({
								text: getData.content,
								icon: 'error',
								showCancelButton: false,
								buttonsStyling: false,
								confirmButtonText: "Ok",
								customClass: {
									 confirmButton: "btn font-weight-bold btn-danger"
								}
						  });
				  $('.social-submit').removeAttr('disabled','disabled');
								 $('.social-submit .spinner-button').hide();
								 $('.social-submit .name-button').show();
				}
				if(getData.status=='success'){
								 pjax.loadUrl('');
					Swal.fire({
									text: getData.content,
									icon: 'success',
									buttonsStyling: false,
									confirmButtonText: "OK",
									customClass: {
										 confirmButton: "btn font-weight-bold btn-primary"
									}
								 }).then(function(isConfirm) {
								 if(isConfirm){ 
										$('.modal-load').modal('hide');
													 $('.modal-views').remove();
													 $this.addClass("modal-url");
								 } 
								 });
						  }
			}
		});
	  });
	  $(document).on("click",".social-like",function(){
					var url = $(this).attr("data-url");
								 $this = $(this);
					$.ajax({
		  type:'POST',
		  url: url,
		  success:function(string){
			  var getData = JSON.parse(string);
			  if(getData.status=='error'){
				  Swal.fire({
								text: getData.content,
								icon: 'error',
								showCancelButton: false,
								buttonsStyling: false,
								confirmButtonText: "Ok",
								customClass: {
									 confirmButton: "btn font-weight-bold btn-danger"
								}
						  });
				}
				if(getData.status=='success'){
					if(getData.data=='like'){
						  $this.find("i").removeClass("far");
						  $this.find("i").addClass("fas");
						  $this.find("i").addClass("text-danger");
					}
					if(getData.data=='deleted'){
						  $this.find("i").removeClass("fas");
						  $this.find("i").removeClass("text-danger");
						  $this.find("i").addClass("far");
					}
					$this.parents(".card").find(".number-like").text(getData.sum);
						  }
			}
		});
	  });
	  $(document).on("click",".social-comment-click",function(){
					var url = $(this).attr("data-url");
					// $(this).toggle()
					$(this).parents(".card").find('.social-comments-list').toggle();
					$(this).parents(".card").find('.social-comments-list').load(url, function(response, status, req) {});
	  });
});