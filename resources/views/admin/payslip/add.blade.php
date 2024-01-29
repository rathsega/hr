<div class="eSection-wrap">
    <div class="row">
        <div class="col-md-12">


            <form action="{{ route('admin.payslip.store') }}" method="post" enctype="multipart/form-data">
                @Csrf
                @php
                    $pay_to = \App\Models\User::where('id', $_GET['user_id'])->first();
                @endphp
                <input type="hidden" value="{{ $_GET['user_id'] }}" name="user_id">

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center mt-3">
                            <img class="rounded-circle" src="{{ get_image('uploads/user-image/' . $pay_to->photo) }}" width="40px">
                            <div class="text-start ps-3">
                                <p class="text-dark text-13px">{{ $pay_to->name }}</p>
                                <small class="badge bg-secondary text-10px">{{ $pay_to->designation }}</small>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label for="net_salary" class="eForm-label">{{get_phrase('Net Salary')}} ({{ currency() }})</label>
                            <input type="number" name="net_salary" value="0" class="form-control eForm-control" id="net_salary" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label for="bonus" class="eForm-label">{{get_phrase('Bonus')}} ({{ currency() }})</label>
                            <input type="number" name="bonus" value="0" class="form-control eForm-control" id="bonus" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label for="penalty" class="eForm-label">{{get_phrase('Penalty')}} ({{ currency() }})</label>
                            <input type="number" name="penalty" value="0" class="form-control eForm-control" id="penalty" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{get_phrase('Payment Status')}}</label>
                            <select name="status" class="form-select eForm-select select2" required>
                                <option value="">{{get_phrase('Select a invoice type')}}</option>
                                <option value="1">{{get_phrase('Paid')}}</option>
                                <option value="0">{{get_phrase('Unpaid')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Brief of monthly salary') }}</label>
                            <input type="text" name="brief_of_monthly_salary"
                                value="{{ date('m/d/y', $timestamp_of_first_date) }} - {{ date('m/t/y', $timestamp_of_first_date) }}"
                                class="eForm-control date-range-picker">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Payslip : allows pdf,png,jpg,doc,docx') }}</label>
                            <input type="file" name="attachment"
                                accept="image/*,.pdf,.doc,.docx"
                                class="eForm-control eForm-control-file">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Note')}} <small class="text-muted">({{get_phrase('Optional')}})</small></label>
                            <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                        </div>
                        <button type="submit" class="btn-form mt-2 mb-3 w-100">{{get_phrase('Submit')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>