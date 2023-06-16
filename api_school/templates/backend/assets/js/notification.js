$(document).ready(function() {
  var active = $('body').attr("data-active");
  permission();
  function permission() {
    if (!("Notification" in window)) {
      console.log("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
      // Check whether notification permissions have already been granted;
      // if so, create a notification
      // const notification = new Notification("Hi there!");
          var active = $('body').attr("data-active");
          // console.log('gửi yêu cầu kích hoạt thông báo');
          getToken(active);
      // …
    } else if (Notification.permission !== "denied") {
      // We need to ask the user for permission
      Notification.requestPermission().then((permission) => {
        // If the user accepts, let's create a notification
        if (permission === "granted") {
          var active = $('body').attr("data-active");
          // console.log('gửi yêu cầu kích hoạt thông báo',active);
          getToken(active);
        }
      });
    }
    // Notification.requestPermission().then((permission) => {
    //   if (permission === 'granted') {
    //     var active = $('body').attr("data-active");
    //     // console.log('gửi yêu cầu kích hoạt thông báo',active);
    //     getToken(active);
    //   }
    // });
  }
  function getToken(active){
    messaging.getToken({ vapidKey: 'BDpYx_A--n48OMDVOEvwyst2mkZr1kecSO9k3f2lOFGmApzey-nLGnUttRfNoeVzW9lYVr1hnByHBT96fCGQSpI' }).then((currentToken) => {
      if (currentToken) {
        sendTokenToServer(currentToken,active);
        // console.log("gui token 1",currentToken,active);
      } else {
        sendTokenToServer(currentToken);
        // console.log("gui token 2",currentToken,active);
      }
    }).catch((err) => {
      NotificationSendServer(false,active);
    });
  }
  function isTokenSentToServer(active) {
    var token = localStorage.getItem('localNoti');
    if(token==null || token!=active){
      return 0;
    }
    else {
      return token;
    }
    // console.log(token);
  }
  function NotificationSendServer(sent,token,active) {
    $.ajax({
        url: '/accounts-notification/',
        type: 'POST',
        data: {token:token,active:active},
    });
    if(sent==true){
      localStorage.setItem('localNoti', active);
    }
    else {
      localStorage.setItem('localNoti', 0);
    }
  }
  function sendTokenToServer(currentToken,active) {
    if (isTokenSentToServer(active)==0) {
      // console.log('Sending token to server...');
      NotificationSendServer(true,currentToken,active);
    } else {
      // console.log('Token already sent to server so won\'t send it again ' +'unless it changes');
    }
  }
});
messaging.onMessage((payload) => {
  // console.log('Message received.  asdasdasd', payload);
  $('<div class="notification-views"></div>').appendTo('body');
  $(".notification-views").html('<div class="position-fixed top-0 end-0 p-3" style="z-index: 999999">'+
    '<div id="notification-push" class="toast align-items-center text-white bg-primary bg-opacity-75 border-0" role="alert" aria-live="assertive" aria-atomic="true">'+
      '<div class="d-flex">'+
        '<div class="toast-body">'+
          '<a href="'+payload.notification.click_action+'" class="pjax-load text-white">'+payload.notification.body+'</a>'+
        '</div>'+
        '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>'+
      '</div>'+
    '</div>'+
  '</div>');
  var notification_push = document.getElementById('notification-push');
  var toast = new bootstrap.Toast(notification_push);
  toast.show();
  var myToastEl = document.getElementById('notification-push')
  myToastEl.addEventListener('hidden.bs.toast', function () {
    $(".notification-views").remove();
  });
});