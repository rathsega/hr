@extends('index')
@push('title', get_phrase('IT Deductions'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('IT Deductions') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('IT Deductions') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.payrollconfiguration.add_itdeduction']) }}', '{{ get_phrase('Add IT Deduction') }}')" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add IT Deduction') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('IT Deductions')}}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Employee') }}</th>
                                <th class="">{{ get_phrase('Amount') }}</th>
                                <th class="">{{ get_phrase('Date') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itdeductions as $key => $itdeduction)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $itdeduction->name }}
                                    </td>
                                    <td>
                                        {{ $itdeduction->amount }}
                                    </td>
                                    <td>
                                    {{ date("F", mktime(0, 0, 0, $itdeduction->month, 10)); }}, {{ $itdeduction->year }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.payrollconfiguration.edit_itdeduction', 'itdeduction_id' => $itdeduction->id]) }}', '{{ get_phrase('Edit IT Deduction') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('admin.payrollconfiguration.delete_itdeduction', $itdeduction->id) }}')" class="btn btn p-0 px-1"
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
