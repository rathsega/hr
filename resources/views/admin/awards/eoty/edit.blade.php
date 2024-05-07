@php
	$users = DB::table('users')->where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();

@endphp
<h4 class="column-title">{{ get_phrase('Update Employee Of The Year') }}</h4>
    <form action="{{ route('admin.eoty.update', $eoty_id) }}" method="post" class="current-location-form">
        @php $eoty_details = DB::table('employee_of_the_year')->find($eoty_id); @endphp
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
                                <option value="{{ $user->id }}" @if ($user->id == $eoty_details->user_id) selected @endif>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="col-md-12">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Selected Year')}}</label>
                    <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select select2">
                        @for ($year = date('Y')-1; $year >= 2022; $year--)
                            <option value="{{ $year }}" @if ($eoty_details->year == $year) selected @endif>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Visibility : ')}}&nbsp;</label>
                    <input type="checkbox" name="visibility" @if($eoty_details->visibility == 1) checked @endif id="visibility">
                </div>
            </div>
            <div class="col-md-12">
                
                <button type="submit" class="btn-form mt-2 mb-3 w-100">{{get_phrase('Update')}}</button>
                
            </div>
        </div>
    </form>
