<form action="{{url('/task/assign_to_user')}}" method="post" id="people_form">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <input type="hidden" id="task_id" name="task_id" value="{{$task->id}}" />
  <input type="hidden" id="type" name="type" value="widgets" />

<div class="form-group">
  <label class="control-label">Assigned to:</label>
  <div class="form-control-wrapper">
    <select class="form-control selectpicker" name="owned_by" id="owned_by" required>
      <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/unassigned.png')}}' /></span><span style='display:inline-block;'>&nbsp;Unassigned</span>"</option>
      @if(isset($users))
        @foreach($users as $user)
      <option value="{{$user->id}}" {{($task->owner != null && $user->id == $task->owner->id)?'selected=selected':''}} data-content="<img class='option-img project-icon' height='16' src='{{$user->getAvatarURI()}}' onerror='this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}' /></span><span style='display:inline-block;'>&nbsp;{{$user->name}}</span>"</option>
        @endforeach
      @endif
    </select>
  </div>
</div>

<div class="form-group">
  <label>Reported by:</label>
  <div class="form-control-wrapper">
    <span class="task-creator"><img class="creator-img" src="{{$task->creator->getAvatarURI()}}" onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}" />{{$task->creator->name}}</span>
  </div>
</div>

<div class="form-group">
  <button type="button" class="btn btn-default btn-sm" id="cancel">Cancel</button>
  <button type="submit" class="btn btn-default btn-sm pull-right" id="save">Save</button>
</div>

</form>

<script>
  $('.selectpicker').selectpicker();
</script>
