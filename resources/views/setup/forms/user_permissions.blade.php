<input type="hidden" name="user_id" value="{{$user->id}}" id="user_id" />
<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />

<div class="row">
    <div class="form-group">
        <label>Privileges:</label>
        <div class="form-control-wrapper">
            <select class="form-control" name="privilege_id" id="privilege_id" required>
                @foreach($privileges as $privilege)
                <option value="{{$privilege->id}}" {{($user->privilege_id == $privilege->id)?'selected="selected"':''}}>{{$privilege->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Roles:</label>
        <div class="form-control-wrapper">
            <select class="form-control" name="role_id" id="role_id" required>
                <option value="-1">NONE</option>
                @foreach($roles as $role)
                <option value="{{$role->id}}" {{($user->role_id == $role->id)?'selected="selected"':''}}>{{$role->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
