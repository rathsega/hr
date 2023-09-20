@extends('index')
@push('title', get_phrase('Branch'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Branches') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Branch') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.branch.add']) }}', '{{ get_phrase('Add new branch') }}')" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new branch') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">Branches</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Branch name') }}</th>
                                <th class="">{{ get_phrase('Description') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\Branch::orderBy('title')->get() as $key => $branch)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $branch->title }}
                                    </td>
                                    <td>
                                        {{ $branch->description }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.branch.edit', 'id' => $branch->id]) }}', '{{ get_phrase('Edit branch') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('admin.branch.delete', $branch->id) }}')" class="btn btn p-0 px-1"
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
