@php
    $client = App\Models\Clients::where('id', $id)->first();
@endphp

<form action="{{ route('admin.clients.update', $client->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{get_phrase('Name')}}</label>
            <input type="text" value="{{$client->name}}" name="name" class="form-control eForm-control" id="name" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="reminder_type" class="eForm-label">{{get_phrase('Reminder end day')}}</label>
            <select name="reminder_type" class="form-select eForm-select" required>
                <option value=""></option>
                @for ($i=1; $i<=31; $i++)
                    <option  @if ($client->reminder_type == $i) selected @endif; value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>