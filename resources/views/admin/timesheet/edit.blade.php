@php
    $timesheet = App\Models\Timesheet::where('id', $_GET['id'])->first();
    $users = App\Models\User::where('status', 'active')->orderBy('id', 'asc')->get();
@endphp

<form class="current-location-form" action="{{ route('admin.timesheet.update', $_GET['id']) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            @if (auth()->user()->role == 'admin')
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Select User')}}</label>
                    <select name="user_id" class="form-select eForm-select select2" required>
                        <option value="">{{ get_phrase('Select a user') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if ($user->id == $timesheet['user_id']) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="user_id" value="{{$timesheet->user_id}}">
            @endif
        </div>

        <div class="col-md-12">
            <div class="fpb-7">
                <label for="fromDate" class="eForm-label">{{get_phrase('From')}}</label>
                <input type="datetime-local" max="<?php echo date('Y-m-d\TH:i'); ?>" value="{{ date('Y-m-d H:i', $timesheet->from_date) }}" name="from_date" class="form-control eForm-control" id="fromDate" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="toDate" class="eForm-label">{{get_phrase('To')}}</label>
                <input type="datetime-local" max="<?php echo date('Y-m-d\TH:i'); ?>" value="{{ date('Y-m-d H:i', $timesheet->to_date) }}" class="form-control eForm-control" name="to_date" id="toDate" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="eInputText" class="eForm-label">{{get_phrase('Work description')}}</label>
                <textarea rows="2" class="form-control" name="description" required>{{ $timesheet->description }}</textarea>
                @if ($errors->has('description'))
                    <small class="text-danger">
                        {{ __($errors->first('description')) }}
                    </small>
                @endif
            </div>
            <button type="submit" class="btn-form mt-2 mb-3" disabled>{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>