$(document).ready(function() {
  $('.login-form').submit(function (e){
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
})
if ("serviceWorker" in navigator) {
  if (navigator.serviceWorker.controller) {
    console.log("[PWA Builder] active service worker found, no need to register");
  } else {
    navigator.serviceWorker
      .register("/service-worker.js", {
        scope: "./"
      })
      .then(function (reg) {
        console.log("[PWA Builder] Service worker has been registered for scope: " + reg.scope);
      });
  }
}