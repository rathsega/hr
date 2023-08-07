<form action="{{route('admin.assessment.rating.update', $user_id)}}" method="post">
    @Csrf
    <div class="fpb-7">
        <label class="eForm-label">Rateable type</label>
        <select name="type" class="form-select  eForm-select eChoice-multiple-without-remove">
            <option value="{{$rating_type}}" selected >{{ucfirst($rating_type)}}</option>
            {{-- <option value="performance" @if($rating_type == 'performance') selected @endif>Performance</option>
            <option value="punctuality" @if($rating_type == 'punctuality') selected @endif>Punctuality</option>
            <option value="discipline" @if($rating_type == 'discipline') selected @endif>Discipline</option>
            <option value="leadership" @if($rating_type == 'leadership') selected @endif>Leadership</option>
            <option value="remarks" @if($rating_type == 'remarks') selected @endif>Remarks</option> --}}
        </select>
    </div>

    @if($rating_type == 'remarks')
    <div class="fpb-7">
        <label class="eForm-label">Description</label>
        <textarea rows="2" class="form-control" name="description" required></textarea>
    </div>
    @else
        <div class="fpb-7">
            <label class="eForm-label">Rating</label>
            <select name="rating" class="form-select  eForm-select eChoice-multiple-without-remove">
                <option value="5">5 Star</option>
                <option value="4">4 Star</option>
                <option value="3">3 Star</option>
                <option value="2">2 Star</option>
                <option value="1">1 Star</option>
            </select>
        </div>
    @endif

    <div class="fpb-7 d-none">
        <label for="toDate" class="eForm-label">Date</label>
        <input type="date" value="{{date('Y-m-d', $timestamp)}}" class="form-control eForm-control" name="date_time" id="toDate" />
    </div>
    
    <div class="fpb-7 mt-2">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>