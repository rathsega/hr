@php
	$users = DB::table('users')->where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();
@endphp
<h4 class="column-title">{{ get_phrase('Add Allowances') }}</h4>
    <form action="{{ route('admin.payrollconfiguration.add_allowances') }}" method="post" class="current-location-form">
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
                                <option value="{{ $user->id }}" @if ($user->id == auth()->user()->id) selected @endif>
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
                            <option value="{{ $year }}" @if (isset($selected_year) && $selected_year == $year) selected @endif>
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
                            <option value="{{ $month }}" @if (isset($selected_month) && $selected_month == $month) selected @endif>
                                {{ date('F', strtotime($year . '-' . $month . '-20')) }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Allowance Type')}}</label>
                    <select name="allowance_type" id="allowance_type" class="form-select eForm-select select2" required>
                        <option value="">{{ get_phrase('Select allowance type') }}</option>
                        <option value="Hostel Allowance">{{ get_phrase('Hostel Allowance') }}</option>
                        <option value="Meal Allowances">{{ get_phrase('Meal Allowances') }}</option>
                        <option value="Motor Vehicle Perq">{{ get_phrase('Motor Vehicle Perq') }}</option>
                        <option value="Motor Vehicle All">{{ get_phrase('Motor Vehicle All') }}</option>
                        
                    </select>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Allowance Amount')}}</label>
                    <input type="text" name="amount" class="form-control eForm-control" required>
                </div>
            </div>
            <div class="col-md-12">
                
                <button type="submit" class="btn-form mt-2 mb-3 w-100" >{{get_phrase('Submit')}}</button>
                
            </div>
        </div>
    </form>
