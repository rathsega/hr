<form action="{{ route('admin.assessment.store') }}" method="POST">
    @Csrf
    <div class="row">
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="staffId" class="eForm-label">Select an employee</label>
                <select name="user_id" class="form-select eForm-select select2" id="staffId" required>
                    <option value="">{{ get_phrase('Select a user') }}</option>
                    @foreach (App\Models\User::where('status', 'active')->where('role', 'staff')->orderBy('sort')->get() as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="fpb-7">
                <label for="eInputText" class="eForm-label">Description of incident</label>
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
                <label for="toDate" class="eForm-label">Date</label>
                <input type="datetime-local" value="{{ date('Y-m-d H:i') }}" class="form-control eForm-control" name="date_time" id="toDate" />
            </div>
            <button type="submit" class="btn-form mt-2 mb-3">Add incident</button>
        </div>
    </div>
</form>