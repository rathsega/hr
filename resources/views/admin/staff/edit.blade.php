<form action="{{route('admin.staff.update', $user_id)}}" method="post" enctype="multipart/form-data">
@php $user_details = DB::table('users')->find($user_id); @endphp
@Csrf
	<div class="fpb-7">
		<label for="name" class="eForm-label">{{get_phrase('Name')}}</label>
		<input type="text" name="name" class="form-control eForm-control" value="{{$user_details->name}}" id="name" required>
	</div>

	<div class="fpb-7">
		<label for="email" class="eForm-label">{{get_phrase('Email')}}</label>
		<input type="email" name="email" class="form-control eForm-control"  value="{{$user_details->email}}" id="email" required>
	</div>

	<div class="fpb-7">
		<label for="role" class="eForm-label">{{get_phrase('User role')}}</label>
		<select name="role" class="form-select eForm-select" required>
			<option value="staff" @if($user_details->role == 'staff') selected @endif>{{get_phrase('Staff')}}</option>
			<option value="manager" @if($user_details->role == 'manager') selected @endif>{{get_phrase('Manager')}}</option>
		</select>
	</div>

	<div class="fpb-7">
		<label for="client" class="eForm-label">{{get_phrase('Select Client')}}</label>
		<select name="client" class="form-select eForm-select select2" id="client">
			<option value="">{{ get_phrase('Select a client') }}</option>
			@foreach (App\Models\Clients::where('status', 'active')->orderBy('name')->get() as $client)
				<option value="{{ $client->id }}" @if($client->id == $user_details->client) selected @endif>{{ $client->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="fpb-7">
		<label for="manager" class="eForm-label">{{get_phrase('Select manager')}}</label>
		<select name="manager" class="form-select eForm-select select2" id="manager" required>
			<option value="">{{ get_phrase('Select a manager') }}</option>
			@foreach (App\Models\User::where('status', 'active')->where('role', 'manager')->orderBy('sort')->get() as $manager)
				<option value="{{ $manager->id }}" @if($manager->id == $user_details->manager) selected @endif>{{ $manager->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="fpb-7">
		<label for="department" class="eForm-label">{{get_phrase('Select Department')}}</label>
		<select name="department" class="form-select eForm-select select2" id="department" required>
			<option value="">{{ get_phrase('Select a department') }}</option>
			@foreach (App\Models\Department::orderBy('title')->get() as $department)
				<option value="{{ $department->id }}" @if($department->id == $user_details->department) selected @endif>{{ $department->title }}</option>
			@endforeach
		</select>
	</div>

	<div class="col-md-12 mt-3">
			<label for="billingtype" class="eForm-label eform-d">{{get_phrase('Billing Type')}} : </label></br>
            <input type="radio" data-bs-toggle="tooltip"  value="billable" @if($user_details->billingtype == 'billable') checked @endif name="billingtype" />
            <label for="eInputTextarea" class="eForm-label eform-d">{{get_phrase('Billable')}}</label>
            <input type="radio" data-bs-toggle="tooltip"  value="non-billable" @if($user_details->billingtype == 'non-billable') checked @endif name="billingtype" />
            <label for="eInputTextarea" class="eForm-label eform-d">{{get_phrase('Non Billable')}}</label>

    </div>

	<div class="col-md-12 mt-3">
			<label for="employmenttype" class="eForm-label eform-d">{{get_phrase('Employment Type')}} : </label></br>

            <input type="radio" data-bs-toggle="tooltip" name="employmenttype" value="contract" @if($user_details->employmenttype == 'contract') checked @endif />
            <label for="eInputTextarea" class="eForm-label eform-d">{{get_phrase('Contract')}}</label>
            <input type="radio" data-bs-toggle="tooltip" name="employmenttype" value="full time"  @if($user_details->employmenttype == 'full time') checked @endif />
            <label for="eInputTextarea" class="eForm-label eform-d">{{get_phrase('Full Time')}}</label>

    </div>

	<div class="col-md-12 mt-3">
        <label for="eBrithDay" class="eForm-label">{{ get_phrase('Birthday') }}</label>
        <input type="date" class="form-control eForm-control date-range-picker" id="eInputDate" name="birthday" required value="{{ date('Y-m-d', strtotime($user_details->birthday)) }}" />
    </div>

	<div class="col-md-12 mt-3">
        <label for="eBrithDay" class="eForm-label">{{ get_phrase('Joining Date') }}</label>
        <input type="date" class="form-control eForm-control date-range-picker" id="eInputDate" name="joining_date" required value="{{ date('Y-m-d', strtotime($user_details->joining_date)) }}" />
    </div>

	<div class="fpb-7">
		<label for="designation" class="eForm-label">{{get_phrase('Designation')}}</label>
		<input type="text" name="designation"  value="{{$user_details->designation}}" class="form-control eForm-control" id="designation">
	</div>

	<div class="fpb-7">
		<label for="photo" class="eForm-label">{{get_phrase('Photo')}}</label>
		<input type="file" name="photo" class="form-control eForm-control-file" id="photo" accept="image/*">
	</div>

	<button type="submit" class="btn-form mt-2 mb-3">{{get_phrase('Apply')}}</button>
</form>

@include('init')