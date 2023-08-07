
<form action="{{route('admin.assessment.incident.store')}}" method="POST">
    @Csrf
    <input type="hidden" name="user_id" value="{{$user_id}}">
    <div class="row">
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="toDate" class="eForm-label">Date</label>
                <input type="datetime-local" value="{{date('Y-m-d H:i')}}"
                class="form-control eForm-control" name="date_time"
                id="toDate" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="eInputText" class="eForm-label">Description of incident</label>
                <textarea rows="2" class="form-control" name="description" required>{{old('description')}}</textarea>
                @if($errors->has('description'))
                    <small class="text-danger">
                        {{__($errors->first('description'))}}
                    </small>
                @endif
            </div>
            <button type="submit" class="btn-form mt-2 mb-3">Add incident</button>
        </div>
    </div>
</form>