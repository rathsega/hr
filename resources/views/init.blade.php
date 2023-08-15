<script>
    "Use strict";
    
    $(function(){
        var formElement;
		if($('.ajaxForm:not(.inited)').length > 0){
			$('.ajaxForm:not(.inited)').ajaxForm({
				beforeSend: function(data, form) {
					var formElement = $(form);
				},
				uploadProgress: function(event, position, total, percentComplete) {
				},
				complete: function(xhr) {

					setTimeout(function(){
						distributeServerResponse(xhr.responseText);
					}, 400);

					if($('.ajaxForm.resetable').length > 0){
						$('.ajaxForm.resetable').map(function(index){
							$('.ajaxForm.resetable')[index].reset();
						});
					}
				},
				error: function(e)
				{
					console.log(e);
				}
			});
			$('.ajaxForm:not(.inited)').addClass('inited');
		}
    });
</script>