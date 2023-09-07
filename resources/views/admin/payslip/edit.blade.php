@php
    $payslip = App\Models\Payslip::where('id', $_GET['id'])->first();
    $pay_to = \App\Models\User::where('id', $payslip->user_id)->first();
@endphp
<div class="eSection-wrap">
    <div class="row">
        <div class="col-md-12">


            <form action="{{ route('admin.payslip.update', $payslip->id) }}" method="post">
                @Csrf
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
                            <label for="net_salary" class="eForm-label">Net Salary ({{ currency() }})</label>
                            <input value="{{$payslip->net_salary}}" type="number" name="net_salary" value="0" class="form-control eForm-control" id="net_salary" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label for="bonus" class="eForm-label">Bonus ({{ currency() }})</label>
                            <input value="{{$payslip->bonus}}" type="number" name="bonus" value="0" class="form-control eForm-control" id="bonus" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label for="penalty" class="eForm-label">Penalty ({{ currency() }})</label>
                            <input value="{{$payslip->penalty}}" type="number" name="penalty" value="0" class="form-control eForm-control" id="penalty" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{get_phrase('Payment Status')}}</label>
                            <select name="status" class="form-select eForm-select select2" required>
                                <option value="">{{get_phrase('Select a invoice type')}}</option>
                                <option value="1" @if($payslip->status == '1') selected @endif>{{get_phrase('Paid')}}</option>
                                <option value="0" @if($payslip->status == '0') selected @endif>{{get_phrase('Unpaid')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Brief of monthly salary') }}</label>
                            <input type="text" name="brief_of_monthly_salary"
                                value="{{ date('m/d/y', strtotime($payslip->month_of_salary)) }} - {{ date('m/t/y', strtotime($payslip->month_of_salary)) }}"
                                class="eForm-control date-range-picker">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label for="eInputTextarea" class="eForm-label">Note <small class="text-muted">(Optional)</small></label>
                            <textarea name="note" class="form-control" rows="2">{{ $payslip->note }}</textarea>
                        </div>
                        <button type="submit" class="btn-form mt-2 mb-3 w-100">{{get_phrase('Save Changes')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>