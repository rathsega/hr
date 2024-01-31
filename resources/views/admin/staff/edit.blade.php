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