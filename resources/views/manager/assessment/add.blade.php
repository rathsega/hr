<form action="{{ route('manager.assessment.store') }}" method="POST">
    @Csrf
    <div class="row">
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="staffId" class="eForm-label">{{get_phrase('Select an employee')}}</label>
                <select name="user_id" class="form-select eForm-select select2" id="staffId" required>
                    <option value="">{{ get_phrase('Select a user') }}</option>
                    @foreach (App\Models\User::where('status', 'active')->where('manager', auth()->user()->id)->orWhere('id', auth()->user()->id)->where('role', '!=', 'admin')->orderBy('sort')->get() as $staff)
                        <option value="{{ $staff->id }}"  @if ($staff->id == auth()->user()->id) selected @endif>{{ $staff->name }} 
                                @if ($staff->id == auth()->user()->id)
                                    <small>({{get_phrase('Me')}})</small>
                                @endif
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="fpb-7">
                <label for="eInputText" class="eForm-label">{{get_phrase('Description of incident')}}</label>
                <textarea rows="2" class="form-control" name="description" required>{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <small class="text-danger">
                        {{ __($errors->first('description')) }}
                    </small>
                @endif
            </div>
        </div>

        <div class="col-md-12">
            <div class="fpb-7">
                <label for="toDate" class="eForm-label">{{get_phrase('Date')}}</label>
                <input type="datetime-local" value="{{ date('Y-m-d H:i') }}" class="form-control eForm-control" name="date_time" id="toDate" />
            </div>
            <button type="submit" class="btn-form mt-2 mb-3">{{get_phrase('Add incident')}}</button>
        </div>
    </div>
</form>