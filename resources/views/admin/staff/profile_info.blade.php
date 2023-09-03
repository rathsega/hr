<form action="{{ route('admin.staff.profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="fpb-7">
        <label for="eInputName" class="eForm-label">{{ get_phrase('Name') }}</label>
        <input value="{{ $user->name }}" name="name" type="text" class="form-control eForm-control" id="eInputName" placeholder="Enter your name"
            aria-label="Enter your name" required />
    </div>

    <div class="fpb-7">
        <label for="eInputEmail" class="eForm-label">{{ get_phrase('Email') }}</label>
        <input value="{{ $user->email }}" name="email" type="email" class="form-control eForm-control" id="eInputEmail"
            placeholder="Enter your email address" aria-label="Enter your email address" required />
    </div>

    <div class="fpb-7">
        <label for="eClassList" class="eForm-label">{{ get_phrase('Role') }}</label>
        <select name="role" class="form-select eForm-select eChoice-multiple-without-remove" required>
            <option value="staff" @if ($user->role == 'staff') selected @endif>{{ get_phrase('Staff') }}</option>
        </select>
    </div>

    <div class="fpb-7">
        <label for="designation" class="eForm-label">{{get_phrase('Designation')}}</label>
        <input type="text" name="designation" value="{{ $user->designation }}" class="form-control" id="designation">
    </div>


    <div class="fpb-7">
        <label for="eSectionList" class="eForm-label">{{ get_phrase('Blood group') }}</label>
        <select name="blood_group" class="form-select eForm-select select2" data-placeholder="Selecte a blood group">
            <option value="">{{ get_phrase('Select a blood group') }}</option>
            <option value="A+" @if ($user->blood_group == 'A+') selected @endif>A Positive (A+)</option>
            <option value="A-" @if ($user->blood_group == 'A-') selected @endif>A Negative (A-)</option>
            <option value="B+" @if ($user->blood_group == 'B+') selected @endif>B Positive (B+)</option>
            <option value="B-" @if ($user->blood_group == 'B-') selected @endif>B Negative (B-)</option>
            <option value="O+" @if ($user->blood_group == 'O+') selected @endif>O Positive (O+)</option>
            <option value="O-" @if ($user->blood_group == 'O-') selected @endif>O Negative (O-)</option>
            <option value="AB+" @if ($user->blood_group == 'AB+') selected @endif>AB Positive (AB+)</option>
            <option value="AB-" @if ($user->blood_group == 'AB-') selected @endif>AB Negative (AB-)</option>
        </select>
    </div>
    <div class="fpb-7">
        <label for="eBrithDay" class="eForm-label">{{ get_phrase('Birthday') }}</label>
        <input type="text" class="form-control eForm-control date-range-picket" id="eInputDate" name="birthday" value="{{ date('m/d/Y', strtotime($user->birthday)) }}" />
    </div>
    <div class="fpb-7">
        <label for="eGenderList" class="eForm-label">{{ get_phrase('Gender') }}</label>
        <select name="gender" class="form-select eForm-select eChoice-multiple-without-remove" required>
            <option value="male" @if ($user->gender == 'Male') selected @endif>{{ get_phrase('Male') }}</option>
            <option value="female" @if ($user->gender == 'Female') selected @endif>{{ get_phrase('Female') }}</option>
        </select>
    </div>

    <div class="fpb-7">
        <label for="eInputPhone" class="eForm-label">{{ get_phrase('Phone Number') }}</label>
        <input value="{{ $user->phone }}" name="phone" type="text" class="form-control eForm-control" id="eInputPhone" placeholder="01XXXXXXXXX"
            aria-label="01XXXXXXXXX" />
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="alternative_phone" class="eForm-label">{{ get_phrase('Relationship of Contact person') }}</label>
                <input value="{{ $user->alternative_phone }}" name="alternative_phone" type="text" class="form-control eForm-control"
                    id="alternative_phone" placeholder="01XXXXXXXXX" aria-label="01XXXXXXXXX" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="rel_of_alternative_phone" class="eForm-label">{{ get_phrase('Relationship of Contact person') }}</label>
                <input value="{{ $user->rel_of_alternative_phone }}" name="rel_of_alternative_phone" type="text" class="form-control eForm-control"
                    id="alternative_phone" placeholder="01XXXXXXXXX" aria-label="01XXXXXXXXX" />
            </div>
        </div>
    </div>

    <div class="fpb-7">
        <label for="eInputAddress" class="eForm-label">{{ get_phrase('Present Address') }}</label>
        <input value="{{ $user->present_address }}" name="present_address" type="text" class="form-control eForm-control" id="eInputAddress"
            placeholder="Enter your present address" aria-label="Enter your present address" />
    </div>
    <div class="fpb-7">
        <label for="eInputAddress2" class="eForm-label">{{ get_phrase('Permanent Address') }}</label>
        <input value="{{ $user->permanent_address }}" name="permanent_address" type="text" class="form-control eForm-control" id="eInputAddress2"
            placeholder="Enter your permanent address" aria-label="Enter your permanent address" />
    </div>
    <div class="fpb-7">
        <label for="eInputTextarea" class="eForm-label">{{ get_phrase('Bio') }}</label>
        <textarea name="bio" class="form-control eForm-control" id="eInputTextarea">{{ $user->bio }}</textarea>
    </div>
    <div class="fpb-7">
        <label for="photo" class="eForm-label">Photo</label>
        <input type="file" name="photo" class="form-control eForm-control-file" id="photo" accept="image/*">
    </div>

    <div class="fpb-7 mt-4">
        <button type="submit" class="eBtn btn-primary">{{ get_phrase('Save Changes') }}</button>
    </div>
</form>