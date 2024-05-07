@php
	$users = DB::table('users')->where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();
@endphp
<h4 class="column-title">{{ get_phrase('Add Long Service Employee') }}</h4>
    <form action="{{ route('admin.lse.store') }}" method="post" class="current-location-form">
        @Csrf
        <div class="row">
            <div class="col-md-12">
                @if (auth()->user()->role != 'admin')
                    <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                @else
                    <div class="fpb-7">
                        <label class="eForm-label">{{get_phrase('Selected User')}}</label>
                        <select name="user_id" class="form-select eForm-select select2" required>
                            <option value="">{{ get_phrase('Select a user') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if ($user->id == auth()->user()->id) selected @endif>
                                    {{ $user->name }}

                                    @if ($user->id == auth()->user()->id)
                                        <small>({{get_phrase('Me')}})</small>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="col-md-12">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Service In Years : ')}}&nbsp;</label>
                    <input type="text" name="service" id="service" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="fpb-7">
                    <label class="eForm-label">{{get_phrase('Visibility : ')}}&nbsp;</label>
                    <input type="checkbox" name="visibility" id="visibility">
                </div>
            </div>

            <div class="col-md-12">
                
                <button type="submit" class="btn-form mt-2 mb-3 w-100" >{{get_phrase('Submit')}}</button>
                
            </div>
        </div>
    </form>
