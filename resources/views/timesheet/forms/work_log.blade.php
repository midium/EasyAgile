<form action="{{url('timesheet/save_log')}}" method="post" id="timesheet_log_form">
  <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Log Work</h4>
        </div>
        <div class="modal-body">

  <div class="container-fluid form-horizontal">
    <input type="hidden" name="id" value="{{(isset($edit_log))?$edit_log->id:''}}" />
    <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
    <input type="hidden" name="task_id" value="{{$task->id}}" />
    <input type="hidden" name="year" value="{{$year}}" />
    <input type="hidden" name="month" value="{{$month}}" />

    <div class="form-group">
        <label class="col-sm-4 control-label">Worked:</label>
        <div class="form-control-wrapper col-sm-3">
            <input type="text" class="form-control" name="time_logged" id="time_logged" value="{{(isset($edit_log))?SecondsToTimeString($edit_log->time_logged):''}}" required />
            <span>ie: 3w 12d 13h</span>
        </div>
        <label class="col-sm-2 control-label">Logged:</label>
        <div class="form-control-wrapper col-sm-3">
          <label class="control-label">{{SecondsToTimeString($task->getThisTaskLoggedTime())}}</label>
        </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4 control-label">Date:</label>
      <div class='input-group col-sm-5 date work-log-date' id='from_date_picker'>
        <input type="text" class="form-control" name="log_date" id="log_date" value="{{(isset($edit_log))?$edit_log->log_date:$date}}" required>
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4 control-label">Remaining Estimate:</label>
      <div class="form-control-wrapper col-sm-3">
          <label class="control-label">{{SecondsToTimeString($task->getThisTaskRemainingTime())}}</label>
      </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Description:</label>
        <div class="form-control-wrapper col-sm-8">
            <textarea type="text" class="form-control" rows="5" name="log_description" id="log_description" required>{{(isset($edit_log))?$edit_log->log_description:''}}</textarea>
        </div>
    </div>
  </div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" id="log_close" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-primary">Log Work</button>
</div>
</div>
</div>
</div>

  </form>

<script>
$('#log_date').datetimepicker({
  format: 'YYYY-MM-DD'
});
</script>
