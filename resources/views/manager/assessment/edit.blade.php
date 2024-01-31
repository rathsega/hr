@php
    $assessment = App\Models\Assessment::where('id', $_GET['id'])->first();
@endphp
<form action="{{ route('manager.assessment.update', $_GET['id']) }}" method="POST">
    @Csrf
    <div class="row">

        @if (auth()->user()->role == 'admin')
            <div class="col-md-12">
                <div class="fpb-7">
                    <label for="staffId" class="eForm-label">Select an employee</label>
                    <select name="user_id" class="form-select eForm-select select2" id="staffId" required>
                        <option value="">{{ get_phrase('Select a user') }}</option>
                        @foreach (App\Models\User::where('status', 'active')->where('role', 'staff')->orderBy('sort')->get() as $staff)
                            <option value="{{ $staff->id }}" @if($assessment->user_id == $staff->id) selected @endif>{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        @endif


        <div class="col-md-12">
            <div class="fpb-7">
                <label for="eInputText" class="eForm-label">Description of incident</label>
                <textarea rows="2" class="form-control" name="description" required>{{ $assessment->description }}</textarea>
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
                <input type="datetime-local" value="{{ date('Y-m-d H:i', $assessment->date_time) }}" class="form-control eForm-control" name="date_time" id="toDate" />
            </div>
            <button type="submit" class="btn-form mt-2 mb-3">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>
