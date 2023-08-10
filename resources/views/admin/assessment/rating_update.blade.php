<form action="{{route('admin.assessment.rating.update', $user_id)}}" method="post">
    @Csrf
    
    @php $rateable_types = ['performance','punctuality','discipline','leadership','remarks']; @endphp
    @foreach($rateable_types as $rateable_type)
        <div class="fpb-7">
            <label class="eForm-label">{{ucfirst($rateable_type)}}</label>
            <select name="rating[{{$rateable_type}}]" class="form-select  eForm-select eChoice-multiple-without-remove">
                <option value="5">5 Star</option>
                <option value="4">4 Star</option>
                <option value="3">3 Star</option>
                <option value="2">2 Star</option>
                <option value="1">1 Star</option>
            </select>
        </div>
    @endforeach

    <div class="fpb-7">
        <label class="eForm-label">Remarks</label>
        <textarea rows="2" class="form-control" name="description" required></textarea>
    </div>

    <div class="fpb-7">
        <label for="toDate" class="eForm-label">Date</label>
        <input type="date" value="{{date('Y-m-d', $timestamp)}}" class="form-control eForm-control" name="date_time" id="toDate" />
    </div>
    
    <div class="fpb-7 mt-2">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>