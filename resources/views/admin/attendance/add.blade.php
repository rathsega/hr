<h4 class="column-title">{{ get_phrase('Give attendance') }}</h4>
    <form action="{{ route('admin.attendance.store') }}" method="post" class="current-location-form">
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
                    <label for="eInputTextarea" class="eForm-label">{{ get_phrase('Type') }}</label>
                    <select class="form-select eForm-select select2" name="check_in_out">
                        <option value="checkin">{{ get_phrase('Check in') }}</option>
                        <option value="checkout">{{ get_phrase('Check out') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="fpb-7">
                    <label for="eInputTextarea" class="eForm-label">{{get_phrase('Date & time')}}</label>
                    <input type="datetime-local" name="time" value="{{ date('Y-m-d H:i') }}" class="form-control eForm-control date-time-picker"
                        id="eInputDateTime" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="fpb-7">
                    <label for="eInputTextarea" class="eForm-label">{{get_phrase('Note')}} <small class="text-muted">({{get_phrase('Optional')}})</small></label>
                    <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                </div>
                <button type="submit" class="btn-form mt-2 mb-3 w-100" disabled>{{get_phrase('Submit')}}</button>
            </div>
        </div>
    </form>