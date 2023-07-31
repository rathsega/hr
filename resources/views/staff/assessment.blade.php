@extends('index')

@section('content')

@php
	$user_id = auth()->user()->id;
	$selected_user_details = DB::table('users')->where('id', $user_id)->first();


	$timestamp_of_my_first_entry = DB::table('assessments')->where('user_id', $user_id)->orderBy('id', 'desc')->value('date_time');

	//selected timestamp to filter
	if(isset($_GET['date']) && $_GET['date'] != ''){
		$selected_timestamp_of_month = strtotime('1 '.$_GET['date']);
	}else{
		$selected_timestamp_of_month = strtotime(date('1 M Y'));
	}

	$start_timestamp = $selected_timestamp_of_month;
	$end_timestamp = strtotime(date('t M Y 23:59:59', $start_timestamp));

	$day = date('d', $timestamp_of_my_first_entry);
	$month = date('m', $timestamp_of_my_first_entry);
	$year = date('Y', $timestamp_of_my_first_entry);
	$counter = 0;
@endphp

<div class="row">
	<div class="col-md-7">
		<div class="eSection-wrap">
			<div class="row">

				<div class="col-md-6">
					<form action="{{route('admin.assessment')}}" method="get">
						<!-- Month chooser -->
						<div class="fpb-7">
							<label class="eForm-label">Selected Month</label>
							<select onchange="$(this).parent().parent().submit();" name="date" class="form-select eForm-select eChoice-multiple-without-remove">
								@for($y = date('Y'); $y >= $year; $y--)

									@php
										if($y == $year){
											$loo_limit_for_starting_month = $month;
										}else{
											$loo_limit_for_starting_month = 1;
										}

										if($y == date('Y')){
											$m = date('m');
										}else{
											$m = 12;
										}
									@endphp
									
									<optgroup label = "Months of - {{$y}}">
										@for($m; $m >= $loo_limit_for_starting_month; $m--)

											@php $date_timestamp = strtotime('1-'.$m.'-'.$y); @endphp

											<option value="{{date('F Y', $date_timestamp)}}" @if($date_timestamp == $selected_timestamp_of_month) selected @endif>
												{{date('F, Y', $date_timestamp)}}

												@if($date_timestamp == strtotime(date('1 M Y')))
													<small>(Current)</small>
												@endif
											</option>

										@endfor
									</optgroup>
								@endfor
							</select>
						</div>
					</form>
				</div>

				<div class="col-md-6">
					<div class="user-info-basic d-flex flex-column justify-content-center mb-4">
						<div class="userImg" style="height: 100px; width: 100px;">
							<img src="{{get_image('uploads/user-image/'.$selected_user_details->photo)}}" class="border" alt="" style="height: 100px;">
						</div>
						<div class="userContent text-center">
							<h3 class="eDisplay-5" >{{$selected_user_details->name}}</h3>
							<p class="info">{{$selected_user_details->designation}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="eSection-wrap">
			<div class="eh6">Incidents</div>
			<div class="table-responsive">
				<table class="table eTable">
					<tbody>
						@php $incidents = DB::table('assessments')->where('user_id', $user_id)->where('date_time', '>=', $start_timestamp)->where('date_time', '<=', $end_timestamp)->get(); @endphp
						@foreach($incidents as $incident)
							<tr>
								<td>{{date('d M Y', $incident->date_time)}} : </td>
								<td>@php echo script_checker($incident->description); @endphp</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="eSection-wrap">
			<div class="eh6">Ratings</div>
			<div class="fpb-7">
				<div class="table-responsive">
					<table class="table eTable">
						<tbody>
							@php $staff_performances = DB::table('staff_performances')->where('user_id', $user_id)->where('date_time', '>=', $start_timestamp)->where('date_time', '<=', $end_timestamp)->orderBy('type', 'asc')->get(); @endphp

							@foreach($staff_performances as $staff_performance)
								<tr>
									<td class="fw-bold text-capitalize">{{$staff_performance->type}}</td>
									<td>
										@for($i = 1; $i <= 5; $i++)
											@if($i <= $staff_performance->rating)
												<i class="bi bi-star-fill text-warning"></i>
											@else
												<i class="bi bi-star"></i>
											@endif
										@endfor
									</td>
								</tr>
							@endforeach

							@if($staff_performances->count() <= 0)
								<p>
									<i class="bi bi-star"></i>
									<i class="bi bi-star"></i>
									<i class="bi bi-star"></i>
									<i class="bi bi-star"></i>
									<i class="bi bi-star"></i>
								</p>
								<p class="text-12px">Not yet reviewed</p>
							@endif
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection