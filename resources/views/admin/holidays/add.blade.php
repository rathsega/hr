
<form action="{{ route('admin.holidays.store') }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" name="name" class="form-control eForm-control" id="title" />
        </div>
        

        <div class="col-md-12 mt-3">
            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Date')}}</label>
            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control eForm-control date-picker"
                        id="eInputDateTime" />
        </div>

        <div class="col-md-12 mt-3">
            <input type="checkbox" data-bs-toggle="tooltip" name="optional" class="task-checkbox" />
            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Optional')}}</label>

        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Add')}}</button>
        </div>
    </div>
</form>