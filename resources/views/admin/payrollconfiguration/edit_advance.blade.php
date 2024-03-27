@php
	$users = DB::table('users')->where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();
@endphp
<h4 class="column-title">{{ get_phrase('Edit Advances') }}</h4>
    <form action="{{ route('admin.payrollconfiguration.update_advances', $advance_id) }}" method="post" class="current-location-form">
    @php $advance_details = DB::table('advances')->find($advance_id); @endphp        
    @Csrf
        <div class="row">
            <div class="col-md-12">
                @if (auth()->user()->role != 'admin')
                    <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                @else
                    <div class="fpb-7">
                        <label class="eForm-label">{{get_phrase('Selected User')}}</label>
                        <select name="user_id" class="form-select eForm-select select2" required>
                            <option value="">{{ get_phrase('Select a user') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if ($user->id == $advance_details->user_id) selected @endif>
                                    {{ $user->name }}

                                    @if ($user->id == auth()->user()->id)
                                        <small>({{get_phrase('Me')}})</small>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Selected Year')}}</label>
                    <select name="year" class="form-select eForm-select select2">
                        @for ($year = date('Y'); $year >= 2022; $year--)
                            <option value="{{ $year }}"  @if ($advance_details->year == $year) selected @endif>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Selected Month')}}</label>
                    <select name="month" class="form-select eForm-select select2">
                        @for ($month = 1; $month <= 12; $month++)
                            <option value="{{ $month }}" @if ($advance_details->month == $month) selected @endif>
                                {{ date('F', strtotime($year . '-' . $month . '-20')) }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Advance Amount')}}</label>
                    <input type="text" name="amount" class="form-control eForm-control" value="{{$advance_details->amount}}" required>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Installements Amount')}}</label>
                    <input type="text" name="installments_count" class="form-control eForm-control" value="{{$advance_details->installments_count}}" required>
                </div>
            </div>
            <div class="col-md-12">
                
                <button type="submit" class="btn-form mt-2 mb-3 w-100" >{{get_phrase('Submit')}}</button>
                
            </div>
        </div>
    </form>
