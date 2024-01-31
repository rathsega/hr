@extends('index')
@push('title', get_phrase('Performance Criteria'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Performance Criteria') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('manager.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Performance Criteria') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area d-flex">
                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'manager.performance_criteria.add']) }}', '{{ get_phrase('Add new criteria') }}')"
                    class="export_btn">
                    <i class="bi bi-plus me-2"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new Criteria') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Performance Criteria') }}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Criteria') }}</th>
                                <th class="">{{ get_phrase('Description') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\Performance_type::get() as $key => $performance_type)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $performance_type->title }}
                                    </td>
                                    <td>
                                        {{ $performance_type->description }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'manager.performance_criteria.edit', 'id' => $performance_type->id]) }}', '{{ get_phrase('Add new criteria') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit Criteria') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-blog-pencil"></i>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('manager.performance.criteria.delete', ['id' => $performance_type->id]) }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="18" height="18" viewBox="0 0 24 24">
                                                <path
                                                    d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
                                                </path>
                                                <path d="M20,4H16V2a1,1,0,0,0-1-1H9A1,1,0,0,0,8,2V4H4A1,1,0,0,0,4,6H20a1,1,0,0,0,0-2ZM10,4V3h4V4Z">
                                                </path>
                                                <path d="M11,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                <path d="M15,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                            </svg>
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
