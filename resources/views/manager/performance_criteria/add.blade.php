<form action="{{ route('manager.performance.criteria.store') }}" method="post">
    @Csrf
    <div class="row">
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="criteria_title" class="eForm-label">{{get_phrase('Criteria')}}</label>
                <input type="text" name="title" id="criteria_title" class="form-control eForm-control" />
            </div>

            <div class="fpb-7">
                <label for="criteria_description" class="eForm-label">{{get_phrase('Description')}}</label>
                <textarea name="description" rows="4" id="criteria_description" class="form-control eForm-control"></textarea>
            </div>
        
            <div class="fpb-7">
                <button type="submit" class="btn-form mt-2 mb-3 w-100">{{get_phrase('Add')}}</button>
            </div>
        </div>
    </div>
</form>