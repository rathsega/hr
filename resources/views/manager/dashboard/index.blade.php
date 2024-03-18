@extends('index')
@push('title', get_phrase('Dashboard'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Dashboard') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        @if(auth()->user()->email != 'it@zettamine.com' && auth()->user()->email != 'accounts@zettamine.com')
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="dashboard_ShortListItem">
                        <div class="dsHeader d-flex justify-content-between align-items-center">
                            <h5 class="title">{{ get_phrase('Total leave application') }}</h5>
                            <a href="{{route('manager.leave.report')}}" class="ds_link ds_teacher">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.146" height="4.764" viewBox="0 0 10.146 4.764">
                                    <path id="Read_more_icon" data-name="Read more icon" d="M11.337,5.978l-.84.84.941.947H3.573V8.955h7.865L10.5,9.9l.84.846L13.719,8.36Z"
                                        transform="translate(-3.573 -5.978)" fill="#000000"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="dsBody d-flex justify-content-between align-items-center">
                            <div class="ds_item_details">
                                @php
                                    $leave_request_in_this_month = App\Models\Leave_application::where('from_date', '>=', strtotime(date('1 M Y 00:00:00')))
                                        ->where('from_date', '<=', strtotime(date('t M Y 23:59:59')))->where('user_id', auth()->user()->id);
                                @endphp
                                <h4 class="total_no">{{ $leave_request_in_this_month->count() }}</h4>
                                <p class="total_info">{{ get_phrase('This month') }}</p>
                            </div>
                            <div class="ds_item_icon success">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="50" height="50" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M229.657 306.343a8 8 0 0 0-11.314 0l-32 32A8 8 0 0 0 184 344v32a8 8 0 0 0 8 8h64a8 8 0 0 0 8-8v-32a8 8 0 0 0-2.343-5.657ZM248 368h-16v-16a8 8 0 0 0-16 0v16h-16v-20.687l24-24 24 24ZM224 264a32 32 0 1 0-32-32 32.036 32.036 0 0 0 32 32Zm0-48a16 16 0 1 1-16 16 16.019 16.019 0 0 1 16-16ZM128 200a32 32 0 1 0 32 32 32.036 32.036 0 0 0-32-32Zm0 48a16 16 0 1 1 16-16 16.019 16.019 0 0 1-16 16ZM344 224a8 8 0 0 0-8 8 16 16 0 0 1-26.665 11.928 8 8 0 0 0-10.671 11.922A32 32 0 0 0 352 232a8 8 0 0 0-8-8ZM128 320a32 32 0 1 0 32 32 32.036 32.036 0 0 0-32-32Zm0 48a16 16 0 1 1 16-16 16.019 16.019 0 0 1-16 16ZM320 320a32 32 0 1 0 32 32 32.036 32.036 0 0 0-32-32Zm0 48a16 16 0 1 1 16-16 16.019 16.019 0 0 1-16 16Z" fill="#000000" data-original="#000000" class=""></path><path d="M465.306 114.005a28.1 28.1 0 0 0-27.929-26H392V72a24 24 0 0 0-48 0v16h-48V72a24 24 0 0 0-48 0v16h-48V72a24 24 0 0 0-48 0v16h-48V72a24 24 0 0 0-48 0v16H34a18.021 18.021 0 0 0-18 18v332a18.021 18.021 0 0 0 18 18h380a18.021 18.021 0 0 0 17.882-16H480a8 8 0 0 0 7.979-8.57ZM360 72a8 8 0 0 1 16 0v32a8 8 0 0 1-16 0Zm-96 0a8 8 0 0 1 16 0v32a8 8 0 0 1-16 0Zm-96 0a8 8 0 0 1 16 0v32a8 8 0 0 1-16 0Zm-96 0a8 8 0 0 1 16 0v32a8 8 0 0 1-16 0Zm-38 32h22a24 24 0 0 0 48 0h48a24 24 0 0 0 48 0h48a24 24 0 0 0 48 0h48a24 24 0 0 0 48 0h24v32H32v-30a2 2 0 0 1 2-2Zm382 334a2 2 0 0 1-2 2H34a2 2 0 0 1-2-2V152h384Zm16-14V104h5.377a12.043 12.043 0 0 1 11.97 11.146L471.408 424Z" fill="#000000" data-original="#000000" class=""></path><path d="M344 408h-40a8 8 0 0 0 0 16h40a8 8 0 0 0 0-16ZM384 408h-8a8 8 0 0 0 0 16h8a8 8 0 0 0 0-16ZM365.122 177.854a8 8 0 0 0-11.268 1.025l-34.392 41.269-9.805-9.805a8 8 0 0 0-11.314 11.314l16 16A8 8 0 0 0 320 240c.121 0 .241 0 .362-.008a8 8 0 0 0 5.784-2.871l40-48a8 8 0 0 0-1.024-11.267Z" fill="#000000" data-original="#000000" class=""></path></g></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="dashboard_ShortListItem">
                        <div class="dsHeader d-flex justify-content-between align-items-center">
                            <h5 class="title">{{ get_phrase('Total attendances') }}</h5>
                            <a href="{{route('manager.attendance')}}" class="ds_link ds_sutdent">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.146" height="4.764" viewBox="0 0 10.146 4.764">
                                    <path id="Read_more_icon" data-name="Read more icon" d="M11.337,5.978l-.84.84.941.947H3.573V8.955h7.865L10.5,9.9l.84.846L13.719,8.36Z"
                                        transform="translate(-3.573 -5.978)" fill="#000000"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="dsBody d-flex justify-content-between align-items-center">
                            <div class="ds_item_details">
                                @php
                                    $total_presents_in_this_month = App\Models\Attendance::where('checkin', '>=', strtotime(date('1 M Y 00:00:00')))
                                        ->where('checkin', '<=', strtotime(date('t M Y 23:59:59')))->where('user_id', auth()->user()->id);
                                @endphp
                                <h4 class="total_no">{{ $total_presents_in_this_month->count() }}</h4>
                                <p class="total_info">{{ get_phrase('This month') }}</p>
                            </div>
                            <div class="ds_item_icon primary">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="50" height="50" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M32 62a9 9 0 1 0-9-9 9 9 0 0 0 9 9zm-1-8.54V48h2v6a1 1 0 0 1-.45.83l-3 2-1.1-1.66zM56 49v3H46v4h10v3l6-5zM8 55h10v-4H8v-3l-6 5 6 5zM32 2a11.15 11.15 0 0 0-9.73 16.59L32 36l9.73-17.41A11.15 11.15 0 0 0 32 2zm0 18a7 7 0 1 1 7-7 7 7 0 0 1-7 7z" fill="#000000" data-original="#000000" class=""></path><circle cx="32" cy="10" r="2" fill="#000000" data-original="#000000" class=""></circle><path d="M33 12h-2a2 2 0 0 0-2 2v3a4.92 4.92 0 0 0 6 0v-3a2 2 0 0 0-2-2zM28.41 34.68l-.82-1.83C25.94 33.59 25 34.74 25 36c0 2.28 3 4 7 4s7-1.72 7-4c0-1.26-.94-2.41-2.59-3.15l-.82 1.83c.86.38 1.41.9 1.41 1.32 0 .82-2 2-5 2s-5-1.18-5-2c0-.42.55-.94 1.41-1.32z" fill="#000000" data-original="#000000" class=""></path></g></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="dashboard_ShortListItem">
                <div class="dsHeader d-flex justify-content-between align-items-center">
                    <h5 class="title">{{ get_phrase('Total Employees') }}</h5>
                    <a href="#" class="ds_link ds_parent">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10.146" height="4.764" viewBox="0 0 10.146 4.764">
                            <path id="Read_more_icon" data-name="Read more icon" d="M11.337,5.978l-.84.84.941.947H3.573V8.955h7.865L10.5,9.9l.84.846L13.719,8.36Z"
                                transform="translate(-3.573 -5.978)" fill="#000000"></path>
                        </svg>
                    </a>
                </div>
                <div class="dsBody d-flex justify-content-between align-items-center">
                    <div class="ds_item_details">
						@php
                            $total_employees = App\Models\User::query();
                        @endphp
                        <h4 class="total_no">{{ $total_employees->count() }}</h4>
                        <p class="total_info">{{ get_phrase('Employees') }}</p>
                    </div>
                    <div class="ds_item_icon warning">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="50" height="50" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M430.122 179.421c27.346-15.461 45.854-44.809 45.854-78.405 0-49.619-40.364-89.988-89.987-89.988-52.904 0-95.164 45.873-89.48 99.638-25.422-12.868-55.582-12.873-81.014 0 5.685-53.647-36.468-99.638-89.48-99.638-49.613 0-89.988 40.369-89.988 89.988 0 33.597 18.508 62.944 45.863 78.405C37.5 197.039 6.033 240.407 6.033 290.998v109.984c0 5.522 4.473 10.002 10 10.002h119.982v79.986c0 5.522 4.482 10.001 10 10.001h219.971c5.526 0 10-4.479 10-10.001v-79.986h119.991c5.519 0 9.99-4.479 9.99-10.002V290.998c.001-50.591-31.466-93.959-75.845-111.577zM385.987 31.023c38.598 0 69.985 31.399 69.985 69.992 0 38.597-31.389 69.996-69.985 69.996-18.938 0-36.586-7.433-49.849-20.92a90.615 90.615 0 0 0-13.653-19.67c-4.287-9.239-6.494-19.122-6.494-29.406 0-38.592 31.399-69.992 69.996-69.992zm-60.035 161.67c-1.24 39.11-32.884 68.307-69.947 68.307-38.734 0-69.996-31.58-69.996-69.996 0-38.588 31.398-69.987 69.996-69.987 38.938 0 70.904 32.092 69.947 71.676zM56.026 101.016c0-38.593 31.399-69.992 69.986-69.992 38.598 0 69.996 31.399 69.996 69.992 0 10.284-2.197 20.167-6.494 29.406a90.545 90.545 0 0 0-13.653 19.67c-13.263 13.487-30.901 20.92-49.849 20.92-38.586 0-69.986-31.4-69.986-69.996zM26.024 390.982v-99.984c0-55.137 44.857-99.994 99.988-99.994 14.133 0 27.688 2.861 40.404 8.497 2.822 30.002 20.432 55.767 45.453 69.908-44.389 17.618-75.855 60.991-75.855 111.577v9.996zm329.971 89.994H156.016v-99.989c0-55.137 44.857-99.988 99.989-99.988 55.133 0 99.99 44.854 99.99 99.988zm129.981-89.994h-109.99v-9.996c0-50.586-31.468-93.959-75.855-111.577 25.021-14.142 42.631-39.906 45.453-69.908 12.717-5.636 26.281-8.497 40.404-8.497 55.131 0 99.987 44.857 99.987 99.994v99.984z" fill="#000000" data-original="#000000" class=""></path></g></svg>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->email != 'it@zettamine.com')
        <div class="col-md-12">
            <div class="eSection-wrap table-responsive mt-4">
				<p class="column-title mb-2">
					{{ get_phrase('Inventory items') }}
				</p>
                <table class="table eTable">
					<thead>
						<tr>
							<th class="">#</th>
							<th class="">{{ get_phrase('Image') }}</th>
							<th class="">{{ get_phrase('Identification') }}</th>
							<th class="">{{ get_phrase('Name') }}</th>
							<th class="">{{ get_phrase('Assigned user') }}</th>
							<th class="">{{ get_phrase('Responsible user') }}</th>
							<th class="">{{ get_phrase('Branch') }}</th>
						</tr>
					</thead>
					<tbody>
						@php
							$user = auth()->user();
							$query = \DB::table('inventory_items');
							
							$query->where(function($query) use ($user){
								$query->where('assigned_user_id', $user->id)
								->orWhere('responsible_user_id', $user->id);
							});
						@endphp
						@foreach ($query->get() as $key => $inventory_item)
							<tr>
								<td>
									{{ ++$key }}
								</td>
								<td>
									<img class="w-40-image" src="{{ get_image($inventory_item->photo, true) }}" alt="">
								</td>
								<td>
									{{ $inventory_item->identification }}
								</td>
								<td>
									{{ $inventory_item->name }}
								</td>
								<td>
									{{ App\Models\User::where('id', $inventory_item->assigned_user_id)->first()->name }}
								</td>
								<td>
									{{ App\Models\User::where('id', $inventory_item->responsible_user_id)->first()->name }}
								</td>
								<td>
									{{ App\Models\Branch::where('id', $inventory_item->branch_id)->first()->title }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
            </div>
        </div>
        @endif

        @if(auth()->user()->email == 'it@zettamine.com')
        <div class="col-md-12">
            <div class="eSection-wrap table-responsive mt-4">
                <p class="column-title mb-2">
                    {{ get_phrase('Inventory items') }}
                </p>
                <table class="table eTable">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="">{{get_phrase('Type')}}</th>
                            <th class="">{{get_phrase('Quantity')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Inventory::get() as $key => $inventory)
                            <tr>
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $inventory->title }}
                                </td>
                                <td>
                                    {{ App\Models\Inventory_item::orderBy('title')->where('type_id', $inventory->id)->count() }} {{ $inventory->title }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('manager.inventory.item', ['item_type' => $inventory->id]) }}" class="btn btn p-0 px-1" title="{{ get_phrase('Item list') }}"
                                        data-bs-toggle="tooltip">
                                        <i class="fi-rr-clipboard-list"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
@endsection