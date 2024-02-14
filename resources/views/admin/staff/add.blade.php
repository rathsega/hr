<form action="{{route('admin.staff.store')}}" method="post" enctype="multipart/form-data">
@Csrf
	<div class="fpb-7">
		<label for="name" class="eForm-label">{{get_phrase('Name')}}</label>
		<input type="text" name="name" class="form-control eForm-control" id="name" required>
	</div>

	<div class="fpb-7">
		<label for="email" class="eForm-label">{{get_phrase('Email')}}</label>
		<input type="email" name="email" class="form-control eForm-control" id="email" required>
	</div>

	<div class="fpb-7">
		<label for="password" class="eForm-label">{{get_phrase('Password')}}</label>
		<input type="text" name="password" class="form-control eForm-control" id="password" required>
	</div>

	<div class="fpb-7">
		<label for="role" class="eForm-label">{{get_phrase('User role')}}</label>
		<select name="role" class="form-select eForm-select" required>
			<option value="staff">{{get_phrase('Staff')}}</option>
			<option value="manager">{{get_phrase('Manager')}}</option>
		</select>
	</div>

	<div class="fpb-7">
		<label for="manager" class="eForm-label">{{get_phrase('Select manager')}}</label>
		<select name="manager" class="form-select eForm-select select2" id="manager">
			<option value="">{{ get_phrase('Select a manager') }}</option>
			@foreach (App\Models\User::where('status', 'active')->where('role', 'manager')->orderBy('sort')->get() as $manager)
				<option value="{{ $manager->id }}">{{ $manager->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="fpb-7">
		<label for="department" class="eForm-label">{{get_phrase('Select Department')}}</label>
		<select name="department" class="form-select eForm-select select2" id="department">
			<option value="">{{ get_phrase('Select a department') }}</option>
			@foreach (App\Models\Department::orderBy('title')->get() as $department)
				<option value="{{ $department->id }}">{{ $department->title }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-12 mt-3">
			<label for="billingtype" class="eForm-label">{{get_phrase('Billing Type')}} : </label></br>
            <input type="radio" data-bs-toggle="tooltip" value="billable" name="billingtype" />
            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Billable')}}</label>
            <input type="radio" data-bs-toggle="tooltip" value="non-billable" name="billingtype" />
            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Non Billable')}}</label>

    </div>

	<div class="col-md-12 mt-3">
			<label for="employmenttype" class="eForm-label">{{get_phrase('Employment Type')}} : </label></br>

            <input type="radio" data-bs-toggle="tooltip" value="contract" name="employmenttype" />
            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Contact')}}</label>
            <input type="radio" data-bs-toggle="tooltip" value="full time" name="employmenttype" />
            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Full Time')}}</label>

    </div>

	<div class="fpb-7">
        <label for="eBrithDay" class="eForm-label">{{ get_phrase('Birthday') }}</label>
        <input type="date" class="form-control eForm-control date-picker" id="eInputDate" name="birthday" value="{{ date('m/d/Y') }}" />
    </div>

	<div class="fpb-7">
		<label for="designation" class="eForm-label">{{get_phrase('Designation')}}</label>
		<input type="text" name="designation" class="form-control eForm-control" id="designation">
	</div>

	<div class="fpb-7">
		<label for="photo" class="eForm-label">{{get_phrase('Photo')}}</label>
		<input type="file" name="photo" class="form-control eForm-control-file" id="photo" accept="image/*">
	</div>

	<div class="fpb-7">
		<label for="aadhar_number" class="eForm-label">{{get_phrase('Aadhar Number')}}</label>
		<input type="text" name="aadhar_number" class="form-control eForm-control" id="aadhar_number">
	</div>

	<div class="fpb-7">
		<label for="pan_number" class="eForm-label">{{get_phrase('PAN Number')}}</label>
		<input type="text" name="pan_number" class="form-control eForm-control" id="pan_number">
	</div>

	<div class="fpb-7">
		<label for="uan_number" class="eForm-label">{{get_phrase('UAN Number')}}</label>
		<input type="text" name="uan_number" class="form-control eForm-control" id="uan_number">
	</div>

	<div class="fpb-7">
		<label for="pf_number" class="eForm-label">{{get_phrase('PF Number')}}</label>
		<input type="text" name="pf_number" class="form-control eForm-control" id="pf_number">
	</div>

	<div class="fpb-7">
		<label for="passport_number" class="eForm-label">{{get_phrase('Passport Number')}}</label>
		<input type="text" name="passport_number" class="form-control eForm-control" id="passport_number">
	</div>


	<div class="fpb-7">
        <label for="passport_expiry_date" class="eForm-label">{{ get_phrase('Passport Expiry Date') }}</label>
        <input type="date" class="form-control eForm-control date-range-picker" id="eInputDate" name="passport_expiry_date" value="{{ date('m/d/Y') }}" />
    </div>

	<div class="fpb-7">
		<label for="bank_name" class="eForm-label">{{get_phrase('Bank Number')}}</label>
		<input type="text" name="bank_name" class="form-control eForm-control" id="bank_name">
	</div>

	<div class="fpb-7">
		<label for="bank_account_number" class="eForm-label">{{get_phrase('Bank Account Number')}}</label>
		<input type="text" name="bank_account_number" class="form-control eForm-control" id="bank_account_number">
	</div>

	<div class="fpb-7">
		<label for="ifsc_code" class="eForm-label">{{get_phrase('IFSC Code')}}</label>
		<input type="text" name="ifsc_code" class="form-control eForm-control" id="ifsc_code">
	</div>

	<button type="submit" class="btn-form mt-2 mb-3">{{get_phrase('Apply')}}</button>
</form>

@include('init')