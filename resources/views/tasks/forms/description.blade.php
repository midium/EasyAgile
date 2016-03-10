<form action="{{url('/task/set_description')}}" method="post" id="description_form">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <input type="hidden" id="task_id" name="task_id" value="{{$task->id}}" />
  <input type="hidden" id="type" name="type" value="widgets" />

  <div class="form-group">
    <textarea id="description" class="form-control">{{$task->description}}</textarea>
  </div>

  <div class="form-group">
    <button type="button" class="btn btn-default btn-sm" id="cancel">Cancel</button>
    <button type="submit" class="btn btn-default btn-sm pull-right" id="save">Save</button>
  </div>

</form>
<script>
$('#description').trumbowyg({
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
