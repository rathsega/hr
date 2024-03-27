<form action="{{route('admin.announcements.store')}}" method="post" enctype="multipart/form-data">
@Csrf
	<div class="fpb-7">
		<label for="subject" class="eForm-label">{{get_phrase('Subject')}}</label>
		<input type="text" name="subject" class="form-control eForm-control" id="subject" required>
	</div>

	<div class="fpb-7">
		<label for="message" class="eForm-label">{{get_phrase('Message')}}</label>
		<textarea type="message" name="message" class="form-control eForm-control" id="message" required  rows="6"></textarea>
	</div>
    <div class="fpb-7">
    <label for="message" class="eForm-label">Note : for Password {password}, for Name {name}</label>
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

	<div class="col-md-12">
		<div class="fpb-7">
			<label for="date" class="eForm-label">{{get_phrase('From Date')}}</label>
			<input type="date" value="{{ date('Y-m-d') }}"  min="<?php echo date('Y-m-d'); ?>" name="from_date" class="form-control eForm-control" id="from_date" />
		</div>
	</div>
	<div class="col-md-12">
		<div class="fpb-7">
			<label for="date" class="eForm-label">{{get_phrase('To Date')}}</label>
			<input type="date" value="{{ date('Y-m-d') }}"  min="<?php echo date('Y-m-d'); ?>" name="to_date" class="form-control eForm-control" id="to_date" />
		</div>
	</div>

	<div class="fpb-7">
            &nbsp;&nbsp;&nbsp;<input type="checkbox" data-bs-toggle="tooltip" name="notification" class="task-checkbox" />
            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Send Email')}}</label>

	</div>

	<button type="submit" class="btn-form mt-2 mb-3">{{get_phrase('Announce')}}</button>
</form>

@include('init')