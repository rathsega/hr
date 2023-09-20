<form action="{{route('admin.staff.store')}}" method="post" enctype="multipart/form-data">
@Csrf
	<div class="fpb-7">
		<label for="name" class="eForm-label">Name</label>
		<input type="text" name="name" class="form-control eForm-control" id="name" required>
	</div>

	<div class="fpb-7">
		<label for="email" class="eForm-label">Email</label>
		<input type="email" name="email" class="form-control eForm-control" id="email" required>
	</div>

	<div class="fpb-7">
		<label for="password" class="eForm-label">Password</label>
		<input type="text" name="password" class="form-control eForm-control" id="password" required>
	</div>

	<div class="fpb-7">
		<label for="role" class="eForm-label">User role</label>
		<select name="role" class="form-select eForm-select" required>
			<option value="staff">Staff</option>
		</select>
	</div>

	<div class="fpb-7">
		<label for="designation" class="eForm-label">Designation</label>
		<input type="text" name="designation" class="form-control eForm-control" id="designation">
	</div>

	<div class="fpb-7">
		<label for="photo" class="eForm-label">Photo</label>
		<input type="file" name="photo" class="form-control eForm-control-file" id="photo" accept="image/*">
	</div>

	<button type="submit" class="btn-form mt-2 mb-3">Apply</button>
</form>

@include('init')