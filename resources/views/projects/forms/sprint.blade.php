<form action="{{url('project/save_sprint')}}" method="post" id="sprint_form" class="form">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title text-center" id="exampleModalLabel">Create/Edit Project Sprint</h4>
    </div>
    <div class="modal-body">
      <div class="container-fluid">
        <input type="hidden" name="id" value="{{(isset($sprint))?$sprint->id:''}}" />
        <input type="hidden" name="project_id" value="{{(isset($project_id))?$project_id:''}}" />
        <input type="hidden" name="sprint_status_id" value="2" />
        <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />

        <div class="row">
            <div class="form-group">
              <label class="control-label">Name:</label>
              <div class="form-control-wrapper">
                <input type="text" class="form-control" autocomplete="off" name="name" id="name" value="{{(isset($sprint))?$sprint->name:''}}" required>
              </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
              <label class="control-label">From Date:</label>
              <div class='input-group date' id='from_date_picker'>
                <input type="text" class="form-control" name="from_date" id="from_date" value="{{(isset($sprint))?$sprint->from_date:''}}" required>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>

        </div>

        <div class="row">
            <div class="form-group">
              <label class="control-label">To Date:</label>
              <div class='input-group date' id='to_date_picker'>
                <input type="text" class="form-control" name="to_date" id="to_date" value="{{(isset($sprint))?$sprint->to_date:''}}" required>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
        </div>

    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="cancel_sprint">Cancel</button>
    <button type="submit" class="btn btn-primary" id="save_sprint">Save Sprint</button>
  </div>
</div>
</div>
</form>

<script>
$('.selectpicker').selectpicker();
$('#from_date_picker').datetimepicker({
  format: 'YYYY-MM-DD'
}).on("dp.change", function (e) {
    $('#to_date_picker').data("DateTimePicker").minDate(e.date);
});

$('#to_date_picker').datetimepicker({
	useCurrent: false,
  format: 'YYYY-MM-DD'
}).on("dp.change", function (e) {
    $('#from_date_picker').data("DateTimePicker").maxDate(e.date);
});
</script>
