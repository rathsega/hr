@extends('index')

@section('content')
	<div class="eCard">
		<div class="card-body">
			<ul class="nav nav-tabs eNav-Tabs-custom" id="pills-tab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="pills-jHome-tab" data-bs-toggle="pill" data-bs-target="#pills-jHome" type="button" role="tab" aria-controls="pills-jHome" aria-selected="true" >
						Active
						<span></span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-jProfile-tab" data-bs-toggle="pill" data-bs-target="#pills-jProfile" type="button" role="tab" aria-controls="pills-jProfile" aria-selected="false">
						Inactive
						<span></span>
					</button>
				</li>
				<li class="nav-item ms-auto" role="presentation">
					<a href="#" data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-primary btn-sm"> <i class="bi bi-plus"></i> <span class="d-none d-sm-inline-block" onclick="showRightModal('{{route('right_modal', ['view_path'=>'admin.add_staff'])}}', '{{__('Add staff')}}')">Add new staff</span></a>

					<a href="#" data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-primary btn-sm ms-1" onclick="showRightModal('{{route('right_modal', ['view_path'=>'admin.staff_sorting'])}}', '{{__('Sort by drag and drop')}}')"> <i class="bi bi-sort-up"></i> <span class="d-none d-sm-inline-block">Sort</span></a>
				</li>
			</ul>
			<div class="tab-content eNav-Tabs-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-jHome" role="tabpanel" aria-labelledby="pills-jHome-tab">
					<table class="table eTable">
						<thead>
							<tr>
								<th>Name</th>
								<th>Role</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($active_staffs as $active_staff)
								<tr>
									<td>
										<img class="rounded-circle" src="{{get_image('uploads/user-image/'.$active_staff->photo)}}" width="30px">
										<span>{{$active_staff->name}}</span>
									</td>
									<td>
										<span class="badge ebg-soft-success text-capitalize">{{$active_staff->role}}</span>
									</td>
									<td class="text-center">
										<div class="btn-group">
											<button type="button" class="btn btn-outline-secondary btn-sm btn-action dropdown-toggle py-1" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="bi bi-three-dots-vertical"></i>
											</button>
											<ul class="dropdown-menu dropdown-menu-end eDropdown-menu-2">
												<li>
													<a class="dropdown-item" onclick="showRightModal('{{route('right_modal', ['view_path'=>'admin.edit_staff', 'user_id' => $active_staff->id])}}', '{{__('Edit staff')}}')" href="#">Edit</a>
												</li>
												<li>
													@if($active_staff->status == 'active')
														<a class="dropdown-item" onclick="confirmModal('{{route('admin.staff.status', ['status' => 'inactive', 'user_id' => $active_staff->id])}}')" href="#">Mark as inactive</a>
													@elseif($active_staff->status == 'inactive')
														<a class="dropdown-item" onclick="confirmModal('{{route('admin.staff.status', ['status' => 'active', 'user_id' => $active_staff->id])}}')" href="#">Mark as active</a>
													@endif
												</li>
												<li>
													<hr class="dropdown-divider my-1"/>
												</li>
												<li>
													<a onclick="confirmModal('{{route('admin.staff.delete', $active_staff->id)}}')" class="dropdown-item" href="#">Delete</a>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="pills-jProfile" role="tabpanel" aria-labelledby="pills-jProfile-tab">
					<table class="table eTable">
						<thead>
							<tr>
								<th>Name</th>
								<th>Role</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($inactive_staffs as $inactive_staff)
								<tr>
									<td>
										<img class="rounded-circle" src="{{get_image('uploads/user-image/'.$inactive_staff->photo)}}" width="30px">
										<span>{{$inactive_staff->name}}</span>
									</td>
									<td>
										<span class="badge ebg-soft-dark text-capitalize">{{$inactive_staff->role}}</span>
									</td>
									<td class="text-center">
										<div class="btn-group">
											<button type="button" class="btn btn-outline-secondary btn-sm btn-action dropdown-toggle py-1" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="bi bi-three-dots-vertical"></i>
											</button>
											<ul class="dropdown-menu dropdown-menu-end eDropdown-menu-2">
												<li>
													<a class="dropdown-item" onclick="showRightModal('{{route('right_modal', ['view_path'=>'admin.edit_staff', 'user_id' => $inactive_staff->id])}}', '{{__('Edit staff')}}')" href="#">Edit</a>
												</li>
												<li>
													@if($inactive_staff->status == 'active')
														<a class="dropdown-item" onclick="confirmModal('{{route('admin.staff.status', ['status' => 'inactive', 'user_id' => $inactive_staff->id])}}')" href="#">Mark as inactive</a>
													@elseif($inactive_staff->status == 'inactive')
														<a class="dropdown-item" onclick="confirmModal('{{route('admin.staff.status', ['status' => 'active', 'user_id' => $inactive_staff->id])}}')" href="#">Mark as active</a>
													@endif
												</li>
												<li>
													<hr class="dropdown-divider my-1"/>
												</li>
												<li>
													<a onclick="confirmModal('{{route('admin.staff.delete', $inactive_staff->id)}}')" class="dropdown-item" href="#">Delete</a>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection