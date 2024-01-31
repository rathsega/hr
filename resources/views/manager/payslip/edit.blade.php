@php
    $payslip = App\Models\Payslip::where('id', $_GET['id'])->first();
    $pay_to = \App\Models\User::where('id', $payslip->user_id)->first();
@endphp
<div class="eSection-wrap">
    <div class="row">
        <div class="col-md-12">


            <form action="{{ route('manager.payslip.update', $payslip->id) }}" method="post" enctype="multipart/form-data">
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
                            <label for="net_salary" class="eForm-label">{{get_phrase('Net Salary')}} ({{ currency() }})</label>
                            <input value="{{$payslip->net_salary}}" type="number" name="net_salary" class="form-control eForm-control" id="net_salary" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label for="bonus" class="eForm-label">{{get_phrase('Bonus')}} ({{ currency() }})</label>
                            <input value="{{$payslip->bonus}}" type="number" name="bonus" class="form-control eForm-control" id="bonus" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label for="penalty" class="eForm-label">{{get_phrase('Penalty')}} ({{ currency() }})</label>
                            <input value="{{$payslip->penalty}}" type="number" name="penalty" class="form-control eForm-control" id="penalty" />
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
                            <label class="eForm-label">{{ get_phrase('Payslip : allows pdf,png,jpg,doc,docx') }}</label>
                            @if(!$payslip->attachment)<input type="file" name="attachment"
                                accept="image/*,.pdf,.doc,.docx"
                                class="eForm-control eForm-control-file">@endif
                            @if($payslip->attachment)<br><a download="" href="../public/uploads/payslip-attachment/{{$payslip->attachment}}"><svg xmlns="http://www.w3.org/2000/svg" height="18" version="1.1" viewBox="-53 1 511 511.99906" width="18"
                                                            id="fi_1092004">
                                                            <g id="surface1">
                                                                <path
                                                                    d="M 276.410156 3.957031 C 274.0625 1.484375 270.84375 0 267.507812 0 L 67.777344 0 C 30.921875 0 0.5 30.300781 0.5 67.152344 L 0.5 444.84375 C 0.5 481.699219 30.921875 512 67.777344 512 L 338.863281 512 C 375.71875 512 406.140625 481.699219 406.140625 444.84375 L 406.140625 144.941406 C 406.140625 141.726562 404.65625 138.636719 402.554688 136.285156 Z M 279.996094 43.65625 L 364.464844 132.328125 L 309.554688 132.328125 C 293.230469 132.328125 279.996094 119.21875 279.996094 102.894531 Z M 338.863281 487.265625 L 67.777344 487.265625 C 44.652344 487.265625 25.234375 468.097656 25.234375 444.84375 L 25.234375 67.152344 C 25.234375 44.027344 44.527344 24.734375 67.777344 24.734375 L 255.261719 24.734375 L 255.261719 102.894531 C 255.261719 132.945312 279.503906 157.0625 309.554688 157.0625 L 381.40625 157.0625 L 381.40625 444.84375 C 381.40625 468.097656 362.113281 487.265625 338.863281 487.265625 Z M 338.863281 487.265625 "
                                                                    style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;"></path>
                                                                <path
                                                                    d="M 305.101562 401.933594 L 101.539062 401.933594 C 94.738281 401.933594 89.171875 407.496094 89.171875 414.300781 C 89.171875 421.101562 94.738281 426.667969 101.539062 426.667969 L 305.226562 426.667969 C 312.027344 426.667969 317.59375 421.101562 317.59375 414.300781 C 317.59375 407.496094 312.027344 401.933594 305.101562 401.933594 Z M 305.101562 401.933594 "
                                                                    style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;"></path>
                                                                <path
                                                                    d="M 194.292969 357.535156 C 196.644531 360.007812 199.859375 361.492188 203.320312 361.492188 C 206.785156 361.492188 210 360.007812 212.347656 357.535156 L 284.820312 279.746094 C 289.519531 274.796875 289.148438 266.882812 284.203125 262.308594 C 279.253906 257.609375 271.339844 257.976562 266.765625 262.925781 L 215.6875 317.710938 L 215.6875 182.664062 C 215.6875 175.859375 210.121094 170.296875 203.320312 170.296875 C 196.519531 170.296875 190.953125 175.859375 190.953125 182.664062 L 190.953125 317.710938 L 140 262.925781 C 135.300781 257.980469 127.507812 257.609375 122.5625 262.308594 C 117.617188 267.007812 117.246094 274.800781 121.945312 279.746094 Z M 194.292969 357.535156 "
                                                                    style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;"></path>
                                                            </g>
                                                        </svg></a>@endif
                            @if($payslip->attachment)<a href="#" onclick="confirmModal('{{ route('manager.payslip.deleteAttachment', ['id' => $payslip->value('id'), 'attachment'=> $payslip->attachment]) }}')"
                                                        class="btn btn p-0 px-1" title="{{ get_phrase('Discard') }}" data-bs-toggle="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="18" height="18"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
                                                            </path>
                                                            <path d="M20,4H16V2a1,1,0,0,0-1-1H9A1,1,0,0,0,8,2V4H4A1,1,0,0,0,4,6H20a1,1,0,0,0,0-2ZM10,4V3h4V4Z">
                                                            </path>
                                                            <path d="M11,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                            <path d="M15,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                        </svg>
                                                    </a>@endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label for="eInputTextarea" class="eForm-label">{{get_phrase('Note')}} <small class="text-muted">({{get_phrase('Optional')}})</small></label>
                            <textarea name="note" class="form-control" rows="2">{{ $payslip->note }}</textarea>
                        </div>
                        <button type="submit" class="btn-form mt-2 mb-3 w-100">{{get_phrase('Save Changes')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>