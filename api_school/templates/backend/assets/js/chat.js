$(document).ready(function() {
	var active = $("body").attr("data-active");
	var conn = new WebSocket('wss://pscmedia.eclo.io:5388?active='+active);
  	function chat_active(receiver,update){
  		var $this = $('.chat-user[data-active="'+receiver+'"]');
		$(".chat-user").removeClass("active");
		$this.addClass("active");
		$this.find(".chat-content-input").focus();
		if(update=='send'){
			send(active,'',receiver,"views");
		}
  	}
  	function chat_user_small(receiver,name,avatar,status,count){
  		chat_small = $("body").find(".chat-small").length;
  		length_active = $("body").find(".chat-small .chat-user-thumb[data-active='"+receiver+"']").length;
  		length_chat_user = $("body").find(".chat-user[data-active='"+receiver+"']").length;
		if(!chat_small) {
			$('<div class="chat-small"></div>').appendTo('body');
		}
		if(!length_active && !length_chat_user) {
			$('<div class="chat-user-thumb item-chat-user load-chat animate__animated animate__heartBeat" data-active="'+receiver+'" data-name="'+name+'" data-avatar="'+avatar+'">'+
				'<div class="chat-online-status" data-active="'+receiver+'">'+status+'</div>'+
				'<div class="chat-number-notifi" data-active="'+receiver+'"></div>'+
				'<img src="'+avatar+'">'+
			+'</div>').appendTo('.chat-small');
		}
	    get_user(active,receiver);
  	}
  	function remove_chat_user_small(receiver){
  		var getActive = $("body").find(".chat-small .chat-user-thumb[data-active='"+receiver+"']");
		getActive.remove();
  	}
  	function send(active,content,receiver,type){
  		var data = {
			active: active,
			content: content,
			receiver:receiver,
			type:type,
		};
  		conn.send(JSON.stringify(data));
  	}
  	function append(active,receiver,content,type){
  		var find = $("body[data-active='"+active+"']").find(".chat-user[data-active='"+receiver+"']");
  		var chat_content = $("body[data-active='"+active+"']").find(".chat-user[data-active='"+receiver+"'] .chat-body");
  			if(find.length>0){
  				chat_content.append('<div class="chat-content-'+type+'""><div class="chat-content">'+content+'</div>');
		  		chat_content.animate({
					 scrollTop: chat_content.get(0).scrollHeight
				}, 0);
  			}
  	}
  	function online(active,type,content){
  		if(type=='online'){
  			$('body').find(".chat-online-status[data-active='"+active+"']").html('<span class="bg-success me-1 d-inline-block chat-online-icon"></span><span class="chat-online-text">'+content+'</span>');
  		}
  		if(type=='offline'){
  			$('body').find(".chat-online-status[data-active='"+active+"']").html('<span class="bg-secondary me-1 d-inline-block chat-online-icon"></span><span class="chat-online-text">'+content+'</span>');
  		}
  	}
  	function auto_chat_small(){
  		chat_user = $("body").find(".chat-user").length;
  		if(chat_user>3){
  			$(".chat-user").first().find(".chat-user-small").click();
  		}
  	}
  	function localSave(active){
  		var local = JSON.parse(localStorage.getItem('localSave'));
  		var data = new Array();
  		if(local==null){
  			local = [];
  		}
  		if(local.length==0){
  			data[0] = active;
  		}
  		else {
  			if(jQuery.inArray(active, local) != -1) {
			    $.each(local, function(i, item) {
			    	data[i] = item;
			    });
			} else {
				$.each(local, function(i, item) {
			    	data[i] = item;
			    	data[i+1] = active;
			    });
			} 
  		}
		cache = JSON.stringify(data);
		localStorage.setItem('localSave', cache);
  	}
  	function localDeleted(active){
  		var local = JSON.parse(localStorage.getItem('localSave'));
  		var result = local.filter(function(v,i) {  
		     if (v === active){ local.splice(i,1) } 
		}); 
		cache = JSON.stringify(local);
		localStorage.setItem('localSave', cache);
  	}
  	function localSelect(){
  		var local = JSON.parse(localStorage.getItem('localSave'));
  		$.each(local, function(i, item) {
	    	chat_user_small(item,'','','');
	    });
  	}
  	function update_user(receiver,name,avatar,status,count){
  		var chat_user = $("body").find(".chat-user[data-active='"+receiver+"']");
  		var chat_user_small = $("body").find('.chat-user-thumb[data-active="'+receiver+'"]');
  		if(chat_user.length){
  			chat_user.find(".chat-name").text(name);
  			chat_user.find(".chat-avatar").attr("src",avatar);
  		}
  		if(chat_user_small.length){
  			chat_user_small.attr("data-name",name);
  			chat_user_small.attr("data-avatar",avatar);
  			chat_user_small.find("img").attr("src",avatar);
  		}
  		online(receiver,status.type,status.content);
  		update_notification(receiver,count);
  	}
  	function update_notification(receiver,count){
  		var chat_user = $("body").find(".chat-number-notifi[data-active='"+receiver+"']");
  		if(chat_user.length && count>0){
  			chat_user.text(count);
  			chat_user.addClass('show');
  		}
  	}
  	function get_user(active,receiver) {
  		var data = {
  			active: active,
  			receiver: receiver,
  			type:'user',
  		};
  		conn.send(JSON.stringify(data));
  	}
  	function chat_block(active,receiver,name,avatar){
  		$('<div class="chat-user animate__animated animate__slideInUp animate__faster" data-active="'+receiver+'">'+
					'<div class="chat-header">'+
						'<div class="chat-header-start">'+
							'<img src="'+avatar+'" class="chat-avatar"><div><span class="fw-bold chat-name">'+name+'</span><div class="chat-online-status" data-active="'+receiver+'">'+status+'</div></div>'+
						'</div>'+
						'<div class="chat-header-end">'+
							'<button class="btn chat-user-small"><i class="fas fa-minus"></i></button>'+
							'<button class="btn chat-user-close"><i class="fas fa-times"></i></button>'+
						'</div>'+
					'</div>'+
					'<div class="chat-body"></div>'+
					'<div class="chat-footer">'+
						'<div class="chat-content">'+
							'<div  contenteditable="true" class="chat-content-input"></div>'+
							'<button class="btn p-0"><i class="far fa-smile fs-6"></i></button>'+
						'</div>'+
						'<div class="chat-content-end">'+
							'<button class="btn text-primary btn-send-chat"><i class="fas fa-paper-plane"></i></button>'+
						'</div>'+
					+'</div>'+
				+'</div>').appendTo('.chat');
  		send(active,'',receiver,"select");
		auto_chat_small();
		remove_chat_user_small(receiver);
		chat_active(receiver);
		localSave(receiver);
	    get_user(active,receiver);
  	}
	$(document).on("click",".load-chat",function(){
		var receiver = $(this).attr("data-active");
		var name = $(this).attr("data-name");
		var avatar = $(this).attr("data-avatar");
			status = $(this).parents(".item-chat-user").find(".chat-online-status[data-active='"+receiver+"']").html();
			length_active = $(this).parents("body").find(".chat-user[data-active='"+receiver+"']").length;
			chat = $(this).parents("body").find(".chat").length;
			if(!chat) {
				$('<div class="chat"></div>').appendTo('body');
			}
			if(!length_active) {
				chat_block(active,receiver,name,avatar,status);
		    } else {
		        alert('false');
		    }
	});
	$(document).on("click",".chat-user-close",function(){
		var $this = $(this).parents(".chat-user");
		var active = $(this).parents(".chat-user").attr("data-active");
		$this.removeClass("animate__slideInUp");
  		$this.addClass("animate__fadeOut");
  		setTimeout(function() {
           $this.remove();
        }, 200);
        localDeleted(active);
	});
	$(document).on("click",".chat-user",function(){
		var $this = $(this);
		chat_active($this.attr("data-active"),'send');
	});
	$(document).on("click",".btn-send-chat", function(){
		var receiver = $(this).parents(".chat-user").attr("data-active");
		var content = $(this).parents(".chat-user").find(".chat-content-input").text();
		var type = '1';
	    send(active,content,receiver,'content');
       $(this).parents(".chat-user").find(".chat-content-input").empty();
	});
	$(document).on('keypress','.chat-content-input',function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			var receiver = $(this).parents(".chat-user").attr("data-active");
			var content = $(this).text();
	       send(active,content,receiver,'content');
	       e.preventDefault();
	       $(this).empty();
	       return false;
	    }
  	});
  	$(document).on("click",".chat-user-small",function(){
  		var $this = $(this).parents(".chat-user");
			status = $this.find(".chat-online-status").html();
	  		$this.removeClass("animate__slideInUp");
	  		$this.addClass("animate__slideOutDown");
	  		var receiver = $this.attr("data-active");
	  		var avatar = $this.find(".chat-header-start .chat-avatar").attr("src");
	  		var name = $this.find(".chat-header-start .chat-name").text();
	  		setTimeout(function() {
	           $this.remove();
	  			chat_user_small(receiver,name,avatar,status);
	        }, 200);
  	});
	conn.onopen = function(e) {
  		localSelect();
	};
	conn.onmessage = function(e) {
		var getData = JSON.parse(e.data);
		if(active===getData.active){
	    	if(getData.type==='select'){
	    		$.each(getData.data, function(i, item) {
				    if(item.user_to==active){
				    	append(active,getData.receiver,item.content,'user');
					}
					if(item.user_from==active){
						append(active,getData.receiver,item.content,'send');
					}
				});
			}
		}
		if(getData.type==='content'){
			if(active===getData.receiver){
				append(getData.receiver,getData.active,getData.content,'send');
				chat_user_small(getData.active,'','','');
  				update_notification(getData.active,getData.count);
			}
			if(active===getData.active){
				append(getData.active,getData.receiver,getData.content,'user');
			}
		}
		if(getData.type==='online' || getData.type==='offline'){
			online(getData.active,getData.type,getData.content);
		}
		if(getData.type==='user'){
			update_user(getData.receiver,getData.data.name,getData.data.avatar,getData.data.status,getData.data.count);
			// console.log("user:",getData);
		}
	};
});