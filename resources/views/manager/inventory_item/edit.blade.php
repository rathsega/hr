@php
    $inventory_item = App\Models\Inventory_item::where('id', $id)->first();
@endphp
<form action="{{ route('manager.inventory.item.update', $inventory_item->id) }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="name" class="eForm-label">{{get_phrase('Name')}}</label>
            <input type="text" value="{{$inventory_item->name}}" name="name" class="form-control eForm-control" id="name" />
        </div>

        <div class="col-md-12 mb-3">
            <label for="type_id" class="eForm-label">{{get_phrase('Item type')}}</label>
            <select name="type_id" class="form-select eForm-select select2" id="type_id">
                <option value="">{{ get_phrase('Select a type') }}</option>
                @foreach (App\Models\Inventory::orderBy('title')->get() as $inventory_item_type)
                    <option @if($inventory_item_type->id == $inventory_item->type_id) selected @endif value="{{ $inventory_item_type->id }}">{{ $inventory_item_type->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="assigned_user_id" class="eForm-label">{{get_phrase('Assign user')}}</label>
            <select name="assigned_user_id" class="form-select eForm-select select2" id="assigned_user_id">
                <option value="">{{ get_phrase('Select a user') }}</option>
                @foreach (App\Models\User::where('status', 'active')->where('role', 'staff')->orWhere('role','manager')->orderBy('sort')->get() as $staff)
                    <option @if($staff->id == $inventory_item->assigned_user_id) selected @endif value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="responsible_user_id" class="eForm-label">{{get_phrase('Responsible user')}}</label>
            <select name="responsible_user_id" class="form-select eForm-select select2" id="responsible_user_id">
                <option value="">{{ get_phrase('Select a user') }}</option>
                @foreach (App\Models\User::where('status', 'active')->where('role', 'staff')->orWhere('role','manager')->orderBy('sort')->get() as $staff)
                    <option @if($staff->id == $inventory_item->responsible_user_id) selected @endif value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="branch_id" class="eForm-label">{{get_phrase('Branch')}}</label>
            <select name="branch_id" class="form-select eForm-select select2" id="branch_id" required>
                <option value="">{{ get_phrase('Select a branch') }}</option>
                @foreach (App\Models\Branch::orderBy('title')->get() as $branch)
                    <option @if($branch->id == $inventory_item->branch_id) selected @endif value="{{ $branch->id }}">{{ $branch->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="description" class="eForm-label">{{get_phrase('Description')}}<small class="text-muted">({{get_phrase('Optional')}})</small></label>
            <textarea name="description" class="form-control eForm-control" rows="2">{{$inventory_item->description}}</textarea>
        </div>

        <div class="col-md-12 mb-3">
            <label for="image" class="eForm-label">{{get_phrase('Image')}}</label>
            <input type="file" name="photo" class="form-control eForm-control-file mb-0" id="image">
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>

@include('init')
