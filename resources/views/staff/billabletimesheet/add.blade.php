<h4 class="column-title">{{ get_phrase('Add Timesheets') }}</h4>
<form action="{{ route('staff.billabletimesheet.store') }}" method="post"  enctype="multipart/form-data" id="timesheetForm" class="current-location-form">
    @Csrf
    <div class="row">


        <div class="col-md-12">
            <div class="fpb-7">
                <label for="date" class="eForm-label">{{get_phrase('From Date')}}</label>
                <input type="date" value="{{ date('Y-m-d') }}" max="<?php echo date('Y-m-d'); ?>" name="from_date" class="form-control eForm-control" id="from_date" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="date" class="eForm-label">{{get_phrase('To Date')}}</label>
                <input type="date" value="{{ date('Y-m-d') }}" max="<?php echo date('Y-m-d'); ?>" name="to_date" class="form-control eForm-control" id="to_date" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="leave_dates" class="eForm-label">{{get_phrase('Leave Dates')}}</label>
                <textarea type="leave_dates" name="leave_dates" class="form-control eForm-control" id="leave_dates" required rows="6" maxlength="150"></textarea>
                <div id="charCount"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="timehseet" class="eForm-label">{{get_phrase('Timesheet')}}</label>
                <input type="file" name="file" class="form-control eForm-control-file" id="fileUpload" accept=".doc, .docx, .pdf, .txt, .jpg, .png, .gif, .jpeg, .csv, .xlsx, .zip, .rar">
                <div  class="eForm-label"> Max allowed file size is 1MB, and allowed file formats are .doc, .docx, .pdf, .txt, .jpg, .png, .gif, .jpeg, .csv, .xlsx, .zip, .rar</div>
            </div>
        </div>
        <div class="col-md-12">

            <button type="submit" class="btn-form mt-2 mb-3 w-100">{{get_phrase('Submit')}}</button>

        </div>
    </div>
</form>
<script>
    // Get the textarea element
    var textarea = document.getElementById("leave_dates");

    // Get the element where character count will be displayed
    var charCount = document.getElementById("charCount");

    // Add event listener for input on the textarea
    textarea.addEventListener("input", function() {
        // Get the current character count
        var count = textarea.value.length;

        // Calculate remaining characters
        var remaining = 250 - count;

        // Display the count
        charCount.textContent = count + " characters entered, " + remaining + " remaining.";
    });

    /*document.getElementById('timesheetForm').onsubmit = function(event) {
        var fileInput = document.getElementById('fileUpload');
        var file = fileInput.files[0];
        if (file.size > 1000000) { // size is in bytes, 1MB
            alert('File is too large. Maximum file size is 1MB.');
            event.preventDefault(); // Stop form submission
        }
    };*/
</script>