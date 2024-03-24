<h4 class="column-title">{{ get_phrase('Add Employee Of The Month') }}</h4>
<form action="{{ route('admin.quotes.store') }}" method="post" class="current-location-form">
    @Csrf
    <div class="row">


        <div class="col-md-12">
            <div class="fpb-7">
                <label for="date" class="eForm-label">{{get_phrase('Date')}}</label>
                <input type="date" value="{{ date('Y-m-d') }}"  min="<?php echo date('Y-m-d'); ?>" name="date" class="form-control eForm-control" id="date" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="quote" class="eForm-label">{{get_phrase('Quote')}}</label>
                <textarea type="quote" name="quote" class="form-control eForm-control" id="quote" required rows="6"></textarea>
            </div>
        </div>
        <div class="col-md-12">

            <button type="submit" class="btn-form mt-2 mb-3 w-100">{{get_phrase('Submit')}}</button>

        </div>
    </div>
</form>