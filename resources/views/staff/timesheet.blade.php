@extends('index')

@section('content')

@php
	$timestamp_of_my_first_entry = DB::table('timesheets')->where('user_id', auth()->user()->id)->orderBy('id', 'asc')->value('from_date');

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
					<form action="{{route('staff.timesheet')}}" method="get">
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
							<img src="{{get_image('uploads/user-image/'.auth()->user()->photo)}}" class="border" alt="" style="height: 100px;">
						</div>
						<div class="userContent text-center">
							<h3 class="eDisplay-5" >{{auth()->user()->name}}</h3>
							<p class="info">{{auth()->user()->designation}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="eSection-wrap">
			<div class="eh6">Working Timesheet</div>

			<div class="accordion custom-accordion" id="accordionOfMonth">


				@for($d = date('t', $selected_timestamp_of_month); 1 <= $d; $d--)
					@php
						$to_date = strtotime(date("$d M Y 23:59:59", $selected_timestamp_of_month));
						$from_date = strtotime(date("$d M Y", $selected_timestamp_of_month));

						if($from_date > strtotime(date('d M Y'))){
							continue;
						}

						$working_logs = DB::table('timesheets')->where('user_id', auth()->user()->id)->where('from_date', '>=', $from_date)->where('to_date', '<', $to_date)->orderBy('id', 'desc')->get();

						$attendance_details = DB::table('attendances')->where('user_id', auth()->user()->id)->where('checkin', '>=', $from_date)->where('checkin', '<=', $to_date)->first();

						$counter++;
					@endphp
					
					<div class="accordion-item">
						<h2 class="accordion-header" id="heading_{{$d}}">
							<button class="accordion-button @if($counter != 1) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$d}}" aria-expanded="@if($counter != 1) true @else false @endif" aria-controls="collapse_{{$d}}">

								{{date('d M, ', $from_date)}}  {{date('l', $from_date)}}

							</button>
						</h2>
						<div id="collapse_{{$d}}" class="accordion-collapse collapse @if($counter == 1) show @endif" aria-labelledby="heading_{{$d}}" data-bs-parent="#accordionOfMonth">
							<div class="accordion-body p-0">

								<div class="table-responsive">
									<table class="table eTable">
										<tbody>
											<tr>
												<th scope="row" colspan="2" style="background-color: #f1f2f7;">
													@if($attendance_details)
														{{date('h:i a', $attendance_details->checkin)}}
													@else
														00:00
													@endif
												</th>
												<td style="background-color: #f1f2f7;">
													Checked in
												</td>
											</tr>

											@php $total_working_time = 0; @endphp
											@foreach($working_logs as $working_log)
												@php $total_working_time += $working_log->working_time; @endphp
												<tr>
													<th>{{date('h:i a', $working_log->from_date)}}</th>
													<td>{{date('h:i a', $working_log->to_date)}}</td>
													<td><?php echo script_checker($working_log->description); ?></td>
												</tr>
											@endforeach

											<tr>
												<th colspan="2" style="background-color: #f1f2f7;">
													@if($attendance_details)
														{{date('h:i a', $attendance_details->checkout)}}
													@else
														00:00
													@endif
												</th>
												<td style="background-color: #f1f2f7;">
													Checked out
													<span class="eBadge ebg-soft-dark fw-bold">
														Worked:
														@php
															$hr = gmdate('G', $total_working_time);
															$min = gmdate('i', $total_working_time);
															if($hr > 0){ echo $hr.'hr '; }
															if($min > 0){ echo $min.'min'; }
														@endphp
													</span>
												</td>
											</tr>
										</tbody>
									</table>

								</div>

							</div>
						</div>
					</div>
				@endfor			
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="eSection-wrap">
			<div class="fpb-7">
				@php $my_task = DB::table('tasks')->where('user_id', auth()->user()->id)->first(); @endphp
				<h5 class="eForm-label">Assigned task</h5>
				<div class="" style="font-size: 13px;color: #000;">
					@if(isset($my_task->description))
						@php echo script_checker($my_task->description); @endphp
					@endif
				</div>
				
			</div>
		</div>
		<div class="eSection-wrap">
			<form action="{{route('staff.timesheet.add_working_log')}}" method="post">
				@Csrf

				<div class="row">
					<div class="col-md-6">
						<div class="fpb-7">
							<label for="fromDate" class="eForm-label">From</label>
							<input type="datetime-local" value="{{date('Y-m-d H:i')}}" name="from_date"
							class="form-control eForm-control"
							id="fromDate" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="fpb-7">
							<label for="toDate" class="eForm-label">To</label>
							<input type="datetime-local" value="{{date('Y-m-d H:i')}}"
							class="form-control eForm-control" name="to_date"
							id="toDate" />
						</div>
					</div>
					<div class="col-md-12">
						<div class="fpb-7">
							<label for="eInputText" class="eForm-label">Work description</label>
							<textarea rows="2" class="form-control" name="description" required>{{old('description')}}</textarea>
							@if($errors->has('description'))
								<small class="text-danger">
									{{__($errors->first('description'))}}
								</small>
							@endif
						</div>
						<button type="submit" class="btn-form mt-2 mb-3">Add time log</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection