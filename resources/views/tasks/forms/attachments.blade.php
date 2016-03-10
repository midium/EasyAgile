
<form action="{{url('task/save_attachment')}}" method="post" id="attachment_form" enctype="multipart/form-data">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <input type="hidden" id="task_id" name="task_id" value="{{$task_id}}" />
  <input type="hidden" id="view_mode" name="view_mode" value="{{$view_mode}}" />

  <div class="form-group">
      <div class="form-control-wrapper">
        <input type="file" id="attachment" name="attachment" class="dropify" data-default-file="" data-max-file-size="3M" />
      </div>
  </div>
  <div class="form-group">
    <button type="button" class="btn btn-default btn-sm" id="cancel">Cancel</button>
    <button type="submit" class="btn btn-default btn-sm pull-right" id="save">Save</button>
  </div>
</form>

<script>
$('.dropify').dropify();
</script>
