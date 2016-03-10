<form action="{{url('/task/set_estimates')}}" method="post" id="estimates_form">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <input type="hidden" id="task_id" name="task_id" value="{{$task->id}}" />
  <input type="hidden" id="type" name="type" value="widgets" />

<div class="form-group clearfix">
  <div class="col-md-6 no-left-padding">
    <label class="control-label">Estimates:</label>
    <div class="form-control-wrapper">
      <input type="text" class="form-control" name="estimates" id="estimates" value="{{SecondsToTimeString($task->estimates)}}" required />
      <span>ie: 3w 12d 13h</span>
    </div>
  </div>
</div>

<div class="form-group">
  <button type="button" class="btn btn-default btn-sm" id="cancel">Cancel</button>
  <button type="submit" class="btn btn-default btn-sm pull-right" id="save">Save</button>
</div>

</form>
