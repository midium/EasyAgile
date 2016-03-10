<form action="{{url('task/set_subject')}}" method="post" id="task_subject_form">
  <div class="modal fade" id="subjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Edit Task Subject</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
            <input type="hidden" id="id" name="id" value="{{$task->id}}" />

            <div class="form-group">
                <label class="control-label">Subject:</label>
                <input class="form-control" type="text" id="subject" name="subject" value="{{$task->subject}}" required/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="log_close" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>
