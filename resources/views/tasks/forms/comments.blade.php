<form action="{{url('task/save_comment')}}" method="post" id="comment_form">
  <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Task Comment</h4>
        </div>
        <div class="modal-body">

          <div class="container-fluid">
            <input type="hidden" name="id" value="{{(isset($edit_comment))?$edit_comment->id:''}}" />
            <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
            <input type="hidden" name="task_id" value="{{$task->id}}" />

            <div class="form-group">
                <label class="control-label">Comment:</label>
                <div class="form-control-wrapper">
                  <textarea class="form-control" id="body" name="body" required>{{(isset($edit_comment))?$edit_comment->body:(isset($quote)?$quote:'')}}</textarea>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="comment_close" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
$('#body').trumbowyg({
  fullscreenable: false,
  btnsDef: {
          // Customizables dropdowns
          align: {
              dropdown: ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
              ico: 'justifyLeft'
          },
          image: {
              dropdown: ['insertImage', 'base64'],
              ico: 'insertImage'
          }
      },
  btns: ['formatting', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
         'link', 'image', '|', 'align',
         '|', 'unorderedList', 'orderedList', '|', 'foreColor', 'backColor']
});
</script>
