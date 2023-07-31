<!-- Show flush message by toastr -->
@if($message = Session::get('success_message'))
	<script>success_message("{{$message}}");</script>
	@php Session()->forget('success_message'); @endphp
@elseif($message = Session::get('error_message'))
	<script>error_message("{{$message}}");</script>
	@php Session()->forget('error_message'); @endphp
@elseif($message = $errors->first())
	<script>error_message("{{$message}}");</script>
@endif

<script type="">
	"Use strict";
	//Cancel the anchor-scrolling when click
	$('a[href="#"]').on('click', function(event){
		event.preventDefault();
	});
</script>