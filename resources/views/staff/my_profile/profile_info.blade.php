<form action="{{ route('staff.my.profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eInputName" class="eForm-label">{{ get_phrase('Name') }}</label>
                <input value="{{ $user->name }}" name="name" type="text" class="form-control eForm-control" id="eInputName" placeholder="Enter your name" aria-label="Enter your name" required />
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eInputEmail" class="eForm-label">{{ get_phrase('Email') }}</label>
                <input value="{{ $user->email }}" name="email" type="email" class="form-control eForm-control" id="eInputEmail" placeholder="Enter your email address" aria-label="Enter your email address" required />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eClassList" class="eForm-label">{{ get_phrase('Role') }}</label>
                <select name="role" class="form-select eForm-select select2" required>
                    <option value="staff" @if ($user->role == 'staff') selected @endif>{{ get_phrase('Staff') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="designation" class="eForm-label">{{get_phrase('Designation')}}</label>
                <input type="text" name="designation" value="{{ $user->designation }}" class="form-control eForm-control" id="designation">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eSectionList" class="eForm-label">{{ get_phrase('Blood group') }}</label>
                <select name="blood_group" class="form-select eForm-select select2" data-placeholder="Selecte a blood group">
                    <option value="">{{ get_phrase('Select a blood group') }}</option>
                    <option value="A+" @if ($user->blood_group == 'A+') selected @endif>{{get_phrase('A Positive')}} (A+)</option>
                    <option value="A-" @if ($user->blood_group == 'A-') selected @endif>{{get_phrase('A Negative')}} (A-)</option>
                    <option value="B+" @if ($user->blood_group == 'B+') selected @endif>{{get_phrase('B Positive')}} (B+)</option>
                    <option value="B-" @if ($user->blood_group == 'B-') selected @endif>{{get_phrase('B Negative')}} (B-)</option>
                    <option value="O+" @if ($user->blood_group == 'O+') selected @endif>{{get_phrase('O Positive')}} (O+)</option>
                    <option value="O-" @if ($user->blood_group == 'O-') selected @endif>{{get_phrase('O Negative')}} (O-)</option>
                    <option value="AB+" @if ($user->blood_group == 'AB+') selected @endif>{{get_phrase('AB Positive')}} (AB+)</option>
                    <option value="AB-" @if ($user->blood_group == 'AB-') selected @endif>{{get_phrase('AB Negative')}} (AB-)</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eBrithDay" class="eForm-label">{{ get_phrase('Birthday') }}</label>
                <input type="text" class="form-control eForm-control date-range-picket" id="eInputDate" name="birthday" value="{{ date('m/d/Y', strtotime($user->birthday)) }}" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="actual_birthday" class="eForm-label">{{ get_phrase('Actual Birthday') }}</label>
                <input type="text" class="form-control eForm-control date-range-picket" id="eInputDate" name="actual_birthday" value="{{ date('m/d/Y', strtotime($user->actual_birthday)) }}" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eGenderList" class="eForm-label">{{ get_phrase('Gender') }}</label>
                <select name="gender" class="form-select eForm-select select2" required>
                    <option value="male" @if ($user->gender == 'male') selected @endif>{{ get_phrase('Male') }}</option>
                    <option value="female" @if ($user->gender == 'female') selected @endif>{{ get_phrase('Female') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eInputPhone" class="eForm-label">{{ get_phrase('Phone Number') }}</label>
                <input value="{{ $user->phone }}" name="phone" type="text" class="form-control eForm-control" id="eInputPhone" placeholder="01XXXXXXXXX" aria-label="01XXXXXXXXX" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="aadhar_number" class="eForm-label">{{get_phrase('Aadhar Number')}}</label>
                <input type="text" name="aadhar_number" class="form-control eForm-control" value="{{$user->aadhar_number}}" id="aadhar_number">
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="pan_number" class="eForm-label">{{get_phrase('PAN Number')}}</label>
                <input type="text" name="pan_number" class="form-control eForm-control" value="{{$user->pan_number}}" id="pan_number">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="uan_number" class="eForm-label">{{get_phrase('UAN Number')}}</label>
                <input type="text" name="uan_number" class="form-control eForm-control" value="{{$user->uan_number}}" id="uan_number">
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="pf_number" class="eForm-label">{{get_phrase('PF Number')}}</label>
                <input type="text" name="pf_number" class="form-control eForm-control" value="{{$user->pf_number}}" id="pf_number">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="passport_number" class="eForm-label">{{get_phrase('Passport Number')}}</label>
                <input type="text" name="passport_number" class="form-control eForm-control" value="{{$user->passport_number}}" id="passport_number">
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="passport_expiry_date" class="eForm-label">{{ get_phrase('Passport Expiry Date') }}</label>
                <input type="date" class="form-control eForm-control date-picker" id="eInputDate1" name="passport_expiry_date" value="{{ date('Y-m-d', strtotime($user->passport_expiry_date)) }}" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="bank_name" class="eForm-label">{{get_phrase('Bank Name')}}</label>
                <input type="text" name="bank_name" class="form-control eForm-control" id="bank_name" value="{{$user->bank_name}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="bank_account_number" class="eForm-label">{{get_phrase('Bank Account Number')}}</label>
                <input type="text" name="bank_account_number" class="form-control eForm-control" id="bank_account_number" value="{{$user->bank_account_number}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="ifsc_code" class="eForm-label">{{get_phrase('IFSC Code')}}</label>
                <input type="text" name="ifsc_code" class="form-control eForm-control" id="ifsc_code" value="{{$user->ifsc_code}}">
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>









    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="alternative_phone" class="eForm-label">{{ get_phrase('Alternative phone number') }}</label>
                <input value="{{ $user->alternative_phone }}" name="alternative_phone" type="text" class="form-control eForm-control" id="alternative_phone" placeholder="01XXXXXXXXX" aria-label="01XXXXXXXXX" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="rel_of_alternative_phone" class="eForm-label">{{ get_phrase('Relationship of Contact person') }}</label>
                <input value="{{ $user->rel_of_alternative_phone }}" name="rel_of_alternative_phone" type="text" class="form-control eForm-control" id="alternative_phone" />
            </div>
        </div>
    </div>

    <div class="fpb-7">
        <label for="eInputAddress" class="eForm-label">{{ get_phrase('Present Address') }}</label>
        <input value="{{ $user->present_address }}" name="present_address" type="text" class="form-control eForm-control" id="eInputAddress" placeholder="Enter your present address" aria-label="Enter your present address" />
    </div>
    <div class="fpb-7">
        <label for="eInputAddress2" class="eForm-label">{{ get_phrase('Permanent Address') }}</label>
        <input value="{{ $user->permanent_address }}" name="permanent_address" type="text" class="form-control eForm-control" id="eInputAddress2" placeholder="Enter your permanent address" aria-label="Enter your permanent address" />
    </div>
    <div class="fpb-7">
        <label for="eInputTextarea" class="eForm-label">{{ get_phrase('Bio') }}</label>
        <textarea name="bio" class="form-control eForm-control" id="eInputTextarea">{{ $user->bio }}</textarea>
    </div>
    <div class="fpb-7">
        <label for="photo" class="eForm-label">{{get_phrase('Photo')}}</label>
        <input type="file" name="photo" class="form-control eForm-control-file" id="photo" accept="image/*">
    </div>

    <div class="fpb-7 mt-4">
        <button type="submit" class="eBtn btn-primary">{{ get_phrase('Save Changes') }}</button>
    </div>
</form>