<form action="{{route('manager.separation.store')}}" method="post" enctype="multipart/form-data">
@Csrf
@php $user_details = DB::table('users')->find(auth()->user()->id); @endphp
	<div class="fpb-7">
		<label for="reason" class="eForm-label">{{get_phrase('Reason')}}</label>
		<textarea type="text" name="reason" class="form-control eForm-control" id="reason" required></textarea>
	</div>

	<div class="fpb-7">
		<label for="alw" class="eForm-label">{{get_phrase('Actual Last Working Day')}}</label>
		<input type="text" class="form-control eForm-control" id="eInputDate2" disabled value="{{ date('d, F, Y', time() + (3600*24*90)) }}" />
	</div>

	<div class="fpb-7">
		<label for="user_proposed_last_working_day" class="eForm-label">{{get_phrase('Proposed Last Working Day')}}</label>
		<input type="date" class="form-control eForm-control date-range-picker" id="eInputDate" name="user_proposed_last_working_day" value="{{ date('m/d/Y') }}" />
	</div>

	

	<button type="submit" class="btn-form mt-2 mb-3">{{get_phrase('Apply')}}</button>
</form>

@include('init')