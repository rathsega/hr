<form action="{{route('admin.staff.update', $user_id)}}" method="post" enctype="multipart/form-data">
@php $user_details = DB::table('users')->find($user_id); @endphp
@Csrf
	<div class="fpb-7">
		<label for="name" class="eForm-label">Name</label>
		<input type="text" name="name" class="form-control eForm-control" value="{{$user_details->name}}" id="name" required>
	</div>

	<div class="fpb-7">
		<label for="email" class="eForm-label">Email</label>
		<input type="email" name="email" class="form-control eForm-control"  value="{{$user_details->email}}" id="email" required>
	</div>

	<div class="fpb-7">
		<label for="role" class="eForm-label">User role</label>
		<select name="role" class="form-select eForm-select eChoice-multiple-without-remove" required>
			<option value="staff" @if($user_details->role == 'staff') selected @endif>Staff</option>
		</select>
	</div>

	<div class="fpb-7">
		<label for="designation" class="eForm-label">Designation</label>
		<input type="text" name="designation"  value="{{$user_details->designation}}" class="form-control eForm-control" id="designation">
	</div>

	<div class="fpb-7">
		<label for="photo" class="eForm-label">Photo</label>
		<input type="file" name="photo" class="form-control eForm-control-file" id="photo" accept="image/*">
	</div>

	<button type="submit" class="btn-form mt-2 mb-3">Apply</button>
</form>

<script type="text/javascript">
	"user strict";

	$(document).ready(function () {
		$(".eChoice-multiple-without-remove").select2();
	});
</script>