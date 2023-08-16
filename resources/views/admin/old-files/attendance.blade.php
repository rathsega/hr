@extends('index')
   
@section('content')

@php
	if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
		$user_id = $_GET['user_id'];
	}else{
		$user_id = auth()->user()->id;
	}

	$selected_user_details = DB::table('users')->where('id', $user_id)->first();


	$timestamp_of_my_first_attendance = DB::table('attendances')->where('user_id', $user_id)->orderBy('id', 'asc')->value('checkin');

	//selected timestamp to filter
	if(isset($_GET['date']) && $_GET['date'] != ''){
		$selected_timestamp_of_month = strtotime('1 '.$_GET['date']);
	}else{
		$selected_timestamp_of_month = strtotime(date('1 M Y'));
	}

	$start_timestamp = $selected_timestamp_of_month;
	$end_timestamp = strtotime(date('t M Y 23:59:59', $start_timestamp));

	$start_timestamp_of_year = strtotime('1 Jan '.date('Y', $start_timestamp));
	$end_timestamp_of_year = strtotime('31 Dec '.date('Y', $start_timestamp).' 23:59:59');

	$day = date('d', $timestamp_of_my_first_attendance);
	$month = date('m', $timestamp_of_my_first_attendance);
	$year = date('Y', $timestamp_of_my_first_attendance);
	$counter = 0;

@endphp

<div class="row">
	<div class="col-md-7">
		<div class="eSection-wrap">
			<div class="row">

				<div class="col-md-6">
					<form action="{{route('admin.attendance')}}" method="get">
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
						<div class="fpb-7">
							<label class="eForm-label">Selected User</label>
							<select onchange="$(this).parent().parent().submit();" name="user_id" class="form-select eForm-select eChoice-multiple-without-remove">
								
								@foreach($users as $user)
									<option value="{{$user->id}}" @if($user->id == $user_id) selected @endif>
										{{$user->name}}

										@if($user->id == auth()->user()->id)
											<small>(Me)</small>
										@endif
									</option>
								@endforeach
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
			<div class="eh6">Attendance report</div>
			<div class="table-responsive">
				<table class="table eTable">
					<thead>
						<tr>
							<th>Date</th>
							<th>Checkin</th>
							<th>Checkout</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@php
							$att_reports = DB::table('attendances')->where('user_id', $user_id)->where('checkin', '>=', $start_timestamp)->where('checkin', '<=', $end_timestamp)->get();
						@endphp

						@foreach($att_reports as $att_report)
							<tr>
								<td>
									{{date('d M Y', $att_report->checkin)}}
								</td>
								<td>
									{{date('h:i a', $att_report->checkin)}}
								</td>
								<td>
									@if(!empty($att_report->checkout))
										{{date('h:i a', $att_report->checkout)}}
									@endif
								</td>
								<td>

									@if($att_report->late_entry == 1)
										<span class="badge bg-warning fw-700">Late entry</span>
									@endif

									@if($att_report->early_leave == 1)
										<span class="badge bg-danger fw-700">Early leave</span>
									@endif

									<p class="text-12px"><b>Note:</b> @php echo script_checker($att_report->note); @endphp</p>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="eSection-wrap">
			<div class="fpb-7">
				<label for="eInputTextarea" class="eForm-label">Report summary</label>

				<table class="table eTable">
					<thead>
						<tr>
							<th>Topic</th>
							<th>{{date('F, Y', $selected_timestamp_of_month)}}</th>
							<th>Year, {{date('Y', $selected_timestamp_of_month)}}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Late checkin
							</td>
							<td>
								{{DB::table('attendances')->where('user_id', $user_id)->where('late_entry', 1)->where('checkin', '>=', $start_timestamp)->where('checkin', '<=', $end_timestamp)->get()->count()}}
							</td>
							<td>
								{{DB::table('attendances')->where('user_id', $user_id)->where('late_entry', 1)->where('checkin', '>=', $start_timestamp_of_year)->where('checkin', '<=', $end_timestamp_of_year)->get()->count()}}
							</td>
						</tr>
						<tr>
							<td>
								Early checkout
							</td>
							<td>
								{{DB::table('attendances')->where('user_id', $user_id)->where('early_leave', 1)->where('checkin', '>=', $start_timestamp)->where('checkin', '<=', $end_timestamp)->get()->count()}}
							</td>
							<td>
								{{DB::table('attendances')->where('user_id', $user_id)->where('early_leave', 1)->where('checkin', '>=', $start_timestamp_of_year)->where('checkin', '<=', $end_timestamp_of_year)->get()->count()}}
							</td>
						</tr>
						<tr>
							<td>
								Absent
							</td>
							<td>
								@php
									$absent_monthly = DB::table('leave_applications')->where('user_id', $user_id)->where('from_date', '>=', $start_timestamp)->where('from_date', '<=', $end_timestamp)->where('status', 'approved');
								@endphp

								{{$absent_monthly->get()->count()}}
								<br>
								<span class="eBadge  ebg-soft-dark">{{$absent_monthly->sum('working_day')}} days</span>
							</td>
							<td>
								@php
									$absent_yearly = DB::table('leave_applications')->where('user_id', $user_id)->where('from_date', '>=', $start_timestamp_of_year)->where('from_date', '<=', $end_timestamp_of_year)->where('status', 'approved');
								@endphp

								{{$absent_yearly->get()->count()}}
								<br>
								<span class="eBadge  ebg-soft-dark">{{$absent_yearly->sum('working_day')}} days</span>
							</td>
						</tr>
						<tr>
							<td>
								Leave applied
							</td>
							<td>
								{{DB::table('leave_applications')->where('user_id', $user_id)->where('from_date', '>=', $start_timestamp)->where('from_date', '<=', $end_timestamp)->get()->count()}}
							</td>
							<td>
								{{DB::table('leave_applications')->where('user_id', $user_id)->where('from_date', '>=', $start_timestamp_of_year)->where('from_date', '<=', $end_timestamp_of_year)->get()->count()}}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="eSection-wrap">

			<form action="{{route('admin.attendance.add')}}" method="post">
				@Csrf

				<input type="hidden" name="user_id" value="{{$user_id}}">

				<div class="row">
					<div class="col-md-6">
						<div class="fpb-7">
							<label for="eInputTextarea" class="eForm-label">Task</label>
							<select class="form-select eForm-select eChoice-multiple-without-remove" name="check_in_out">
								<option value="checkin">Check in</option>
								<option value="checkout">Check out</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="fpb-7">
							<label for="eInputTextarea" class="eForm-label">Date & time</label>
							<input type="datetime-local" name="time" value="{{date('Y-m-d H:i')}}" 
							class="form-control eForm-control"
							id="eInputDateTime" />
						</div>
					</div>
					<div class="col-md-12">
						<div class="fpb-7">
							<label for="eInputTextarea" class="eForm-label">Note <small class="text-muted">(Optional)</small></label>
							<textarea name="note" class="form-control" rows="2">{{old('note')}}</textarea>
						</div>
						<button type="submit" class="btn-form mt-2 mb-3">Add time log</button>
					</div>
				</div>
			</form>
		</div>
		<div class="eSection-wrap">
			<ul class="nav nav-tabs eNav-Tabs-custom" id="myTab" role="tablist" >
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="cHome-tab" data-bs-toggle="tab" data-bs-target="#cHome" type="button" role="tab" aria-controls="cHome" aria-selected="true"
					>
						Leave application
						<span></span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="cProfile-tab" data-bs-toggle="tab" data-bs-target="#cProfile" type="button" role="tab" aria-controls="cProfile" aria-selected="false" >
						Apply for leave
						<span></span>
					</button>
				</li>
			</ul>
			<div class="tab-content eNav-Tabs-content" id="myTabContent" >
				<div class="tab-pane fade show active" id="cHome" role="tabpanel" aria-labelledby="cHome-tab">
					<p>
						<table class="table eTable">
							<thead>
								<tr>
									<th>From</th>
									<th>To</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach(DB::table('leave_applications')->where('user_id', $user_id)->take(100)->orderBy('id', 'desc')->get() as $leave_requests)
									<tr>
										<td>
											{{date('d M Y', $leave_requests->from_date)}}
										</td>
										<td>
											{{date('d M Y', $leave_requests->to_date)}}
										</td>
										<td>
											<span class="eBadge @if($leave_requests->status == 'pending') ebg-soft-danger @elseif($leave_requests->status == 'approved') ebg-soft-success @else ebg-soft-dark @endif text-capitalize">{{$leave_requests->status}}</span>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</p>
				</div>
				<div class="tab-pane fade" id="cProfile" role="tabpanel" aria-labelledby="cProfile-tab" >
					<form action="{{route('admin.leave_application.add')}}" method="post">
						@Csrf

						<input type="hidden" name="user_id" value="{{$user_id}}">

						<div class="row">
							<div class="col-md-6">
								<div class="fpb-7">
									<label for="eInputTextarea" class="eForm-label">From</label>
									<input type="date" name="from_date" value="{{date('Y-m-d')}}" 
									class="form-control eForm-control"
									id="eInputDateTime" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="fpb-7">
									<label for="eInputTextarea" class="eForm-label">To</label>
									<input type="date" name="to_date" value="{{date('Y-m-d')}}" 
									class="form-control eForm-control"
									id="eInputDateTime" />
								</div>
							</div>
							<div class="col-md-12">
								<div class="fpb-7">
									<label for="eInputTextarea" class="eForm-label">Reason</label>
									<textarea class="form-control" rows="2" name="reason" required>{{old('reason')}}</textarea>
									@if($errors->has('reason'))
										<small class="text-danger">
											{{$errors->first('reason')}}
										</small>
									@endif
								</div>
								<button type="submit" class="btn-form mt-2 mb-3">Apply</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<div>
@endsection