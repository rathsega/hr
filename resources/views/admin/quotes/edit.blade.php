<h4 class="column-title">{{ get_phrase('Edit Quote') }}</h4>
<form action="{{ route('admin.quotes.update', $quote_id) }}" method="post" class="current-location-form">
    @php $quote_details = DB::table('quotes')->find($quote_id);
	$users = DB::table('users')->where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();
    @endphp
    @Csrf
    <div class="row">

        <div class="col-md-12">
            @if (auth()->user()->role != 'admin')
                <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
            @else
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Selected Quote By')}}</label>
                    <select name="user_id" class="form-select eForm-select select2" required>
                        <option value="">{{ get_phrase('Select a user') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if ($user->id == $quote_details->user_id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="col-md-12">
            <div class="fpb-7">
                <label for="date" class="eForm-label">{{get_phrase('From Date')}}</label>
                <input type="date" value="{{ date('Y-m-d', strtotime($quote_details->from_date)) }}" min="<?php echo date('Y-m-d'); ?>" name="from_date" class="form-control eForm-control" id="from_date" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="date" class="eForm-label">{{get_phrase('To Date')}}</label>
                <input type="date" value="{{ date('Y-m-d', strtotime($quote_details->to_date)) }}" min="<?php echo date('Y-m-d'); ?>" name="to_date" class="form-control eForm-control" id="to_date" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="fpb-7">
                <label for="quote" class="eForm-label">{{get_phrase('Quote')}}</label>
                <textarea type="quote" name="quote" class="form-control eForm-control" id="edit_quote" required rows="6"  maxlength="150">{{$quote_details->quote}}</textarea>
                <div id="charCount"></div>
            </div>
        </div>
        <div class="col-md-12">

            <button type="submit" class="btn-form mt-2 mb-3 w-100">{{get_phrase('Submit')}}</button>

        </div>
    </div>
</form>

<script>
    // Get the textarea element
    var textarea = document.getElementById("edit_quote");
    
    // Get the element where character count will be displayed
    var charCount = document.getElementById("charCount");
    
    // Add event listener for input on the textarea
    textarea.addEventListener("input", function() {
        // Get the current character count
        var count = textarea.value.length;
        
        // Calculate remaining characters
        var remaining = 150 - count;
        
        // Display the count
        charCount.textContent = count + " characters entered, " + remaining + " remaining.";
    });
</script>