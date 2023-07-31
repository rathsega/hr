@extends('index')

@section('content')
<div class="row">
	<div class="col-lg-12 col-xl-8">
		<div class="eSection-wrap">
			<div class="title">
				<h3>All staff</h3>
			</div>
			<div class="eMain">
				<div class="accordion custom-accordion" id="accordionStaff">

					@foreach($staffs as $key => $staff)
						@php $task = DB::table('tasks')->where('user_id', $staff->id)->first(); @endphp
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading_{{$key}}">
								<button class="accordion-button @php echo (isset($_GET['expand-user']) && $staff->id == $_GET['expand-user']) ? '' : 'collapsed'; @endphp" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$key}}" aria-expanded="@php echo (isset($_GET['expand-user']) && $staff->id == $_GET['expand-user']) ? 'true' : 'false'; @endphp" aria-controls="collapse_{{$key}}">
									<img class="rounded-circle me-2" width="30px" src="{{get_image('uploads/user-image/'.$staff->photo)}}">
									 {{$staff->name}}
								</button>
							</h2>
							<div id="collapse_{{$key}}" class="accordion-collapse collapse @php echo (isset($_GET['expand-user']) && $staff->id == $_GET['expand-user']) ? 'show' : ''; @endphp" aria-labelledby="heading_{{$key}}" data-bs-parent="#accordionStaff" style="">
								<div class="accordion-body py-3">

									<div class="row pb-5" ondblclick="fadeInArea(this, '#task_form_{{$key}}', '#task_area{{$key}}')" id="task_view_{{$key}}">
										<div class="col-md-12" style="font-size: 13px; color: #000;">
											@php echo script_checker($task->description ?? ''); @endphp
										</div>
									</div>

									<form id="task_form_{{$key}}" class="d-hidden" method="post" action="{{route('admin.task_manager.update',['user_id' => $staff->id])}}">
										@Csrf
										<div class="form-group">
											<textarea id="task_area{{$key}}" class="form-control fade-in-area-1 border-0 p-0" name="description" style="font-size: 13px; color: #000;">{{$task->description ?? ''}}</textarea>
										</div>
										<div class="form-group text-end mt-1 pt-2">
											<button class="btn btn-primary px-4" type="submit">Save</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					@endforeach
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection