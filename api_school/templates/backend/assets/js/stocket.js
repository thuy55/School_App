$(document).ready(function() {
	var active = $("body").attr("data-active");
	var conn = new WebSocket('wss://pscmedia.eclo.io:5388?active='+active);
	conn.onopen = function(e) {
	    console.log("Connection established!");
	};
	conn.onmessage = function(e) {
	    console.log(e.data);
	};
});