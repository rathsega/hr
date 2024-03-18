@extends('index')
@push('title', get_phrase('Inventory Items'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    @php
        $item_type = isset($_GET['item_type']) ? $_GET['item_type'] : '';
        $assigned_user_id = isset($_GET['assigned_user']) ? $_GET['assigned_user'] : '';
        $responsible_user_id = isset($_GET['responsible_user']) ? $_GET['responsible_user'] : '';
        $branch_id = isset($_GET['branch']) ? $_GET['branch'] : '';
    @endphp

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Inventory Items') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('manager.dashboard') }}}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('manager.inventory') }}">{{ get_phrase('Inventory') }}</a></li>
                    <li><a href="#">
                        @if($inventory)
                            {{ $inventory->title }}
                        @else
                            {{ get_phrase('All type of item') }}
                        @endif
                    </a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'manager.inventory_item.add', 'type_id' => ($inventory) ? $inventory->id:'']) }}', '{{ get_phrase('Add new type of inventory items') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new item') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="eSection-wrap pb-4">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('manager.inventory.item') }}" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="item_type" class="eForm-label">{{ get_phrase('Item type') }}</label>
                            <select onchange="$(this).parent().parent().parent().submit()" name="item_type" class="form-select eForm-select select2" id="item_type">
                                <option value="">{{ get_phrase('All type of item') }}</option>
                                @foreach (App\Models\Inventory::orderBy('title')->get() as $inventory_item_type)
                                    <option @if ($item_type == $inventory_item_type->id) selected @endif value="{{ $inventory_item_type->id }}">{{ $inventory_item_type->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="assigned_user_id" class="eForm-label">{{ get_phrase('Assigned user') }}</label>
                            <select onchange="$(this).parent().parent().parent().submit()" name="assigned_user" class="form-select eForm-select select2" id="assigned_user_id" tabindex="-1">
                                <option value="">{{ get_phrase('All user') }}</option>
                                @foreach (App\Models\User::where('status', 'active')->where('role', 'staff')->orWhere('role','manager')->orderBy('sort')->get() as $staff)
                                    <option @if ($assigned_user_id == $staff->id) selected @endif value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="responsible_user_id" class="eForm-label">{{ get_phrase('Responsible user') }}</label>
                            <select onchange="$(this).parent().parent().parent().submit()" name="responsible_user" class="form-select eForm-select select2" id="responsible_user_id">
                                <option value="">{{ get_phrase('All user') }}</option>
                                @foreach (App\Models\User::where('status', 'active')->where('role', 'staff')->orWhere('role','manager')->orderBy('sort')->get() as $staff)
                                    <option @if ($responsible_user_id == $staff->id) selected @endif value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="branch_id" class="eForm-label">{{ get_phrase('Branch') }}</label>
                            <select onchange="$(this).parent().parent().parent().submit()" name="branch" class="form-select eForm-select select2" id="branch_id">
                                <option value="">{{ get_phrase('All branch') }}</option>
                                @foreach (App\Models\Branch::orderBy('title')->get() as $branch)
                                    <option @if ($branch_id == $branch->id) selected @endif value="{{ $branch->id }}">{{ $branch->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">
                    @if($inventory)
                        {{ $inventory->title }}
                    @else
                        {{ get_phrase('All types of inventory item') }}
                    @endif    
                </p>
                <div class="table-responsive">
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
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $query = App\Models\Inventory_item::query();
                                
                                if ($item_type) {
                                    $query->where('type_id', $item_type);
                                }
                                
                                if ($assigned_user_id) {
                                    $query->where('assigned_user_id', $assigned_user_id);
                                }
                                
                                if ($responsible_user_id) {
                                    $query->where('responsible_user_id', $responsible_user_id);
                                }
                                
                                if ($branch_id) {
                                    $query->where('branch_id', $branch_id);
                                }
                                
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
                                        {{ $inventory_item->assigned_user->name }}
                                    </td>
                                    <td>
                                        {{ $inventory_item->responsible_user->name }}
                                    </td>
                                    <td>
                                        {{ $inventory_item->branch->title }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'manager.inventory_item.edit', 'id' => $inventory_item->id]) }}', '{{ get_phrase('Edit inventory item') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('manager.inventory.item.delete', $inventory_item->id) }}')" class="btn btn p-0 px-1"
                                            title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-trash"></i>
                                        </a>
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
