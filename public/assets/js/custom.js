//Start Bootstrap Tooltip initialize
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});
// End Bootstrap Tooltip initialize


//Start password show and hide
$(function(){
	$('.show-password').on('click', function(){
		if($(this).parent().find('input').attr('type') == 'password'){
			$(this).parent().find('input').attr('type', 'text');
			$(this).parent().find('i').removeClass('bi-eye-slash');
			$(this).parent().find('i').addClass('bi-eye');
		}else{
			$(this).parent().find('input').attr('type', 'password');
			$(this).parent().find('i').removeClass('bi-eye');
			$(this).parent().find('i').addClass('bi-eye-slash');
		}
	});
});
//End password show and hide


//Start toastr
toastr.options = {
	"closeButton": true,
	"debug": false,
	"newestOnTop": true,
	"progressBar": true,
	"positionClass": "toast-top-right",
	"preventDuplicates": false,
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "5000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "slideUp"
}
function success_message(message) {
	toastr.success(message);
}

function error_message(message) {
	toastr.error(message);
}
//End toastr


function fadeInArea(taskViewElem, taskFormElem, taskAreaElem){
	$(taskViewElem).parent().css('min-height', $(taskViewElem).parent().height()+'px');
	$(taskViewElem).fadeOut(100);
	setTimeout(function(){
		$(taskFormElem).fadeIn(100);
		$(taskAreaElem).height(document.querySelector(taskAreaElem).scrollHeight);
	}, 100);
}