<form action="{{ route('admin.leave.report.update_leaves_count') }}" method="post">
    @csrf
    @php
        $leaves_count = App\Models\Leaves_count::get()->First();
    @endphp
    <div class="fpb-7">
        <label for="sick" class="eForm-label">{{get_phrase('Sick Leaves Count')}}</label>
        <input name="sick" type="number" class="form-control eForm-control" id="sick" value="{{$leaves_count->sick}}" placeholder="{{get_phrase('Enter Sick Leaves Count')}}">
    </div>

    <div class="fpb-7">
        <label for="casual" class="eForm-label">{{get_phrase('Casual Leaves Count')}}</label>
        <input name="casual" type="number" class="form-control eForm-control" id="casual" value="{{$leaves_count->casual}}" placeholder="{{get_phrase('Enter Casual Leaves Count')}}">
    </div>

    <div class="fpb-7">
        <label for="meternity" class="eForm-label">{{get_phrase('Meternity Leaves Count')}}</label>
        <input name="meternity" type="number" class="form-control eForm-control" id="meternity"  value="{{$leaves_count->meternity}}" placeholder="{{get_phrase('Enter Meternity Leaves Count')}}">
    </div>

    <div class="fpb-7">
        <label for="feternity" class="eForm-label">{{get_phrase('Feternity Leaves Count')}}</label>
        <input name="feternity" type="number" class="form-control eForm-control" id="feternity"  value="{{$leaves_count->feternity}}" placeholder="{{get_phrase('Enter Feternity Leaves Count')}}">
    </div>

    <div class="fpb-7">
        <label for="carry_forward" class="eForm-label">{{get_phrase('Carry Forward Leaves Count')}}</label>
        <input name="carry_forward" type="number" class="form-control eForm-control" id="carry_forward"  value="{{$leaves_count->carry_forward}}" placeholder="{{get_phrase('Enter Carry Forward Feternity Leaves Count')}}">
    </div>

    <div class="fpb-7">
        <button class="btn-form mt-2 mb-3 px-3">{{get_phrase('Update')}}</button>
    </div>
</form>