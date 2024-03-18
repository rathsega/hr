@extends('index')
@push('title', get_phrase('Inventory'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Inventory') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('manager.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Inventory') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area d-flex ">
                <a href="{{ route('manager.inventory.item') }}" class="export_btn me-2">
                    <i class="fi-rr-clipboard-list me-2"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('View all items') }}</span>
                </a>
                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'manager.inventory.add']) }}', '{{ get_phrase('Add new type of inventory items') }}')"
                    class="export_btn">
                    <i class="bi bi-plus me-2"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new type of item') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Inventory item types')}}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{get_phrase('Type')}}</th>
                                <th class="">{{get_phrase('Quantity')}}</th>
                                <th class="text-center">{{get_phrase('Action')}}</th>
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

                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'manager.inventory_item.add', 'type_id' => $inventory ? $inventory->id : '']) }}', '{{ get_phrase('Add new type of inventory items') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Add new ____', $inventory->title) }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-plus text-15px"></i>
                                        </a>

                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'manager.inventory.edit', 'id' => $inventory->id]) }}', '{{ get_phrase('Edit type of inventory items') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('manager.inventory.delete', $inventory->id) }}')" class="btn btn p-0 px-1"
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
