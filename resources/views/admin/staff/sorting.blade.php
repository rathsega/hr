@php
	$active_staffs = DB::table('users')->where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();
	$inactive_staffs = DB::table('users')->where('role', '!=', 'admin')->where('status', '!=', 'active')->orderBy('sort', 'asc')->get();
@endphp

<form action="{{route('admin.staff.sort.update')}}" method="post">
	@Csrf
	<h6 class="text-14px mb-3">Active users</h6>
	<ul id="activeUserSortable">
		@foreach($active_staffs as $active_staff)
			<li class="ui-state-default">
				<input type="hidden" name="active_user_ids[]" value="{{$active_staff->id}}">
				<table class="table eTable mx-0 mt-0 p-0 card mb-1">
				<tbody>
					<tr>
						<td class="border-0">
							<img class="rounded-circle" src="{{get_image('uploads/user-image/'.$active_staff->photo)}}" width="30px">
							<span>{{$active_staff->name}}</span>
						</td>
					</tr>
				</tbody>
			</table>
			</li>
		@endforeach
	</ul>

	<h6 class="text-14px mb-3 mt-5">Inactive users</h6>
	<ul id="inActiveUserSortable">
		@foreach($inactive_staffs as $inactive_staff)	
			<li class="ui-state-default">
				<input type="hidden" name="inactive_user_ids[]" value="{{$inactive_staff->id}}">
				<table class="table eTable mx-0 mt-0 p-0 card mb-1">
				<tbody>
					<tr>
						<td class="border-0">
							<img class="rounded-circle" src="{{get_image('uploads/user-image/'.$inactive_staff->photo)}}" width="30px">
							<span>{{$inactive_staff->name}}</span>
						</td>
					</tr>
				</tbody>
			</table>
			</li>
		@endforeach
	</ul>

	<div class="form-group pt-4">
		<button type="submit" class="btn btn-success">Update</button>
	</div>
</form>

<script>
	"Use strict";

	$(function() {
		$("#activeUserSortable").sortable();
		$("#inActiveUserSortable").sortable();
	});
</script>