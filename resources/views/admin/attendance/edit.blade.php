<h4 class="column-title">
    {{ get_phrase('Edit attendance') }}
    <a class="float-end text-primary" href="{{ route('admin.attendance') }}">Back</a>
</h4>
@php
    $attendance = App\Models\Attendance::where('id', $_GET['id'])->first();
@endphp
<form action="{{ route('admin.attendance.update', $_GET['id']) }}" method="post" class="current-location-form">
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
                            <option value="{{ $user->id }}" @if ($user->id == $attendance->user_id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="col-md-12">
            <div class="fpb-7">
                <label for="eInputTextarea" class="eForm-label">{{ get_phrase('Login time') }}</label>
                <input type="datetime-local" name="check_in_time" value="{{ date('Y-m-d H:i', $attendance->checkin) }}"
                    class="form-control eForm-control date-time-picker" id="eInputDateTime" />
            </div>
        </div>

        @if ($attendance->checkout)
            <div class="col-md-12">
                <div class="fpb-7">
                    <label for="eInputTextarea" class="eForm-label">{{ get_phrase('Logout time') }}</label>
                    <input type="datetime-local" name="check_out_time" value="{{ date('Y-m-d H:i', $attendance->checkout) }}"
                        class="form-control eForm-control date-time-picker" id="eInputDateTime" />
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="fpb-7">
                <label for="eInputTextarea" class="eForm-label">{{get_phrase('Note')}} <small class="text-muted">({{get_phrase('Optional')}})</small></label>
                <textarea name="note" class="form-control" rows="2">{{ $attendance->note }}</textarea>
            </div>
            <button type="submit" class="btn-form mt-2 mb-3 w-100" disabled>{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>