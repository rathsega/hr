@extends('index')
@push('title', get_phrase('Allowances'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Allowances') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Allowances') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.payrollconfiguration.add_allowance']) }}', '{{ get_phrase('Add Allowance') }}')" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add Allowance') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Allowances')}}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Employee') }}</th>
                                <th class="">{{ get_phrase('Allowance Type') }}</th>
                                <th class="">{{ get_phrase('Amount') }}</th>
                                <th class="">{{ get_phrase('Date') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allowances as $key => $allowance)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $allowance->name }}
                                    </td>
                                    <td>
                                        {{ $allowance->allowance_type }}
                                    </td>
                                    <td>
                                        {{ $allowance->amount }}
                                    </td>
                                    <td>
                                    {{ date("F", mktime(0, 0, 0, $allowance->month, 10)); }}, {{ $allowance->year }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.payrollconfiguration.edit_allowance', 'allowance_id' => $allowance->id]) }}', '{{ get_phrase('Edit Allowance') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('admin.payrollconfiguration.delete_allowance', $allowance->id) }}')" class="btn btn p-0 px-1"
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
