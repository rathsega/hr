@php
    $branch = App\Models\Branch::where('id', $id)->first();
@endphp

<form action="{{ route('admin.branch.update', $branch->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" value="{{$branch->title}}" name="title" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="description" class="eForm-label">{{get_phrase('Description')}}<small class="text-muted">(Optional)</small></label>
            <textarea name="description" class="form-control eForm-control" rows="2">{{$branch->description}}</textarea>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>