
<form action="{{ route('manager.inventory.store') }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" name="title" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="description" class="eForm-label">{{get_phrase('Description')}}<small class="text-muted">({{get_phrase('Optional')}})</small></label>
            <textarea name="description" class="form-control eForm-control" rows="2"></textarea>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Add')}}</button>
        </div>
    </div>
</form>