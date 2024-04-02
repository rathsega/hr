@extends('index')
@push('title', get_phrase('Advances'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Advances') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Advances') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.payrollconfiguration.add_advance']) }}', '{{ get_phrase('Add advance') }}')" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add advance') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Advances')}}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Employee') }}</th>
                                <th class="">{{ get_phrase('Amount') }}</th>
                                <th class="">{{ get_phrase('Installments') }}</th>
                                <th class="">{{ get_phrase('Due Amount') }}</th>
                                <th class="">{{ get_phrase('Date') }}</th>
                                <th class="">{{ get_phrase('Status') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($advances as $key => $advance)
                                @php
                                    $installments = $advance->installments ? json_decode($advance->installments) : [];
                                    $paid_installments_count = count($installments);
                                    
                                @endphp
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $advance->name }}
                                    </td>
                                    <td>
                                        {{ $advance->amount }}
                                    </td>
                                    <td>
                                        {{$paid_installments_count}}/{{ $advance->installments_count }}
                                    </td>
                                    <td>
                                        {{ $advance->amount - (($advance->amount/$advance->installments_count)*$paid_installments_count) }}
                                    </td>
                                    <td>
                                    {{ date("F", mktime(0, 0, 0, $advance->month, 10)); }}, {{ $advance->year }}
                                    </td>
                                    <td>
                                        {{ $advance->status }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.payrollconfiguration.edit_advance', 'advance_id' => $advance->id]) }}', '{{ get_phrase('Edit advance') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('admin.payrollconfiguration.delete_advance', $advance->id) }}')" class="btn btn p-0 px-1"
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
