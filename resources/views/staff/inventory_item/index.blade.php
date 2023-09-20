@extends('index')
@push('title', get_phrase('Inventory Item'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Inventory Item') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{route('admin.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Inventory Item') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">
                    {{ get_phrase('All types of inventory item') }}
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
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $query = \DB::table('inventory_items');
                                
                                $query->where(function ($query) {
                                    $query->where('assigned_user_id', auth()->user()->id)->orWhere('responsible_user_id', auth()->user()->id);
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
        </div>
    </div>
@endsection
