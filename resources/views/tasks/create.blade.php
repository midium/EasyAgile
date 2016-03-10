@extends('app')

@section('content')
<div class="container-fluid task-create-scroller">
  <input type="hidden" id="project_id" value="{{($project != null)?$project->id:''}}" />
    <div class="row">&nbsp;</div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$title.((isset($parent_task) || $parent_task != null)?$parent_task->getCode():'')}}</div>

                <div class="panel-body">
                  <form action="{{url('task/save')}}" method="post" id="task_form" enctype="multipart/form-data">
                    <div class="container-fluid form-horizontal">
                      <input type="hidden" name="id" value="{{(isset($edit_project))?$edit_project->id:''}}" />
                      <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
                      <input type="hidden" id="parent_task_id" name="parent_task_id" value="{{(isset($parent_task))?$parent_task->id:''}}" />

                      @if(isset($parent_task))
                      <input type="hidden" name="project_id" value="{{$project->id}}" />
                      <input type="hidden" name="task_type_id" value="6" />
                      @else
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Project:</label>
                        <div class="form-control-wrapper col-sm-5">
                          <select class="form-control selectpicker" name="project_id" id="project_id" required>
                          @if(isset($projects))
                            @foreach($projects as $prj)
                            <option value="{{$prj->id}}" {{(isset($project) && $project->id == $prj->id)?'selected="selected"':''}} data-content="<img class='project-icon' src='{{$prj->getProjectIcon()}}' /></span><span style='display:inline-block;'>&nbsp;{{$prj->name}}</span>"</option>
                            @endforeach
                          @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 control-label">Issue Type:</label>
                          <div class="form-control-wrapper col-sm-5">
                              <select class="form-control selectpicker" name="task_type_id" id="task_type_id" required>
                              @if(isset($task_types))
                                @foreach($task_types as $task_type)
                                  @if($task_type->id != 6)
                                <option value="{{$task_type->id}}" data-content="<img class='project-icon' src='{{asset('/assets/task_type_icons/'.$task_type->id.'.png')}}' /></span><span style='display:inline-block;'>&nbsp;{{$task_type->name}}</span>"</option>
                                  @endif
                                @endforeach
                              @endif
                              </select>
                          </div>
                      </div>

                      <hr>

                      @endif

                      <div class="form-group">
                          <label class="col-sm-2 control-label">Subject:</label>
                          <div class="form-control-wrapper col-sm-10">
                              <input type="text" class="form-control" name="subject" id="subject" required />
                          </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Task Priority:</label>
                        <div class="form-control-wrapper col-sm-5">
                          <select class="form-control selectpicker" name="priority_id" id="priority_id" required>
                          <?php $default = 4; //Medium ?>
                          @if(isset($priorities))
                            @foreach($priorities as $priority)
                            <option value="{{$priority->id}}" {{($priority->id == $default)?'selected="selected"':''}} data-content="<img class='project-icon' src='{{asset('/assets/task_priority_icons/'.$priority->id.'.png')}}' /></span><span style='display:inline-block;'>&nbsp;{{$priority->name}}</span>"</option>
                            @endforeach
                          @endif
                          </select>
                        </div>
                      </div>

                      @if(isset($parent_task))
                      <input type="hidden" name="epic_id" value="{{$parent_task->epic_id}}" />
                      @else
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Epic:</label>
                          <div class="form-control-wrapper col-sm-10">
                            <select class="form-control selectpicker" name="epic_id" id="epic_id">
                              @if(isset($epics))
                              <option value="-1">None</option>
                                @foreach($epics as $epic)
                              <option value="{{$epic->id}}">({{$epic->project->code}}) {{$epic->name}}</option>
                                @endforeach
                              @endif
                            </select>
                          </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Estimates:</label>
                            <div class="form-control-wrapper col-sm-3">
                                <input type="text" class="form-control" name="estimates" id="estimates" />
                                <span>ie: 3w 12d 13h</span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-2 control-label">Assigned to:</label>
                          <div class="form-control-wrapper col-sm-5">
                            <select class="form-control selectpicker" name="owned_by" id="owned_by" required>
                              <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/unassigned.png')}}' /></span><span style='display:inline-block;'>&nbsp;Unassigned</span>"</option>
                              @if(isset($users))
                                @foreach($users as $user)
                              <option value="{{$user->id}}" data-content="<img class='option-img project-icon' height='16' src='{{$user->getAvatarURI()}}' onerror='this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}' /></span><span style='display:inline-block;'>&nbsp;{{$user->name}}</span>"</option>
                                @endforeach
                              @endif
                            </select>
                          </div>
                          <div class="clearfix centered">
                            <a href="#" id="assign_to_me">Assign to me</a>
                          </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description:</label>
                            <div class="form-control-wrapper col-sm-10">
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Attachments:</label>
                            <div class="form-control-wrapper col-sm-10">
                              <input type="file" id="attachment" name="attachment" class="dropify" data-default-file="" data-max-file-size="3M" />
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-2 control-label">&nbsp;</label>
                          <div class="form-control-wrapper col-sm-10">
                            <button class="btn btn-default pull-left" type="button" id="task_cancel">Cancel</button>
                            <button class="btn btn-primary pull-right" type="submit" id="task_save">Save</button>
                          </div>
                        </div>

                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-includes')
<script src="{{ asset('/js/trumbowyg.min.js') }}"></script>
<script src="{{ asset('/js/plugins/colors/trumbowyg.colors.js') }}"></script>
<script src="{{ asset('/js/plugins/upload/trumbowyg.upload.js') }}"></script>
<script src="{{ asset('/js/plugins/base64/trumbowyg.base64.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>
@endsection

@section('css-includes')
<link rel="stylesheet" href="{{ asset('/css/trumbowyg.min.css') }}">
<link rel="stylesheet" href="{{ asset('/css/plugins/colors/trumbowyg.colors.css') }}">
<link rel="stylesheet" href="{{ asset('/css/dropify.min.css') }}">
@endsection

@section('beforebodyend')
<script>
  $('.selectpicker').selectpicker();

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

  $('.dropify').dropify();

  $('body').on('click', '#assign_to_me', function(event){
    event.preventDefault();

    $('#owned_by').selectpicker('val', '{{Auth::user()->id}}');
  });

  $('body').on('click', 'button#task_cancel', function(event){
    event.preventDefault();
    var prj_id = $('#project_id').val();
    var parent_task_id = $('#parent_task_id').val();

    if(typeof(parent_task_id) != 'undefined' && parent_task_id != ''){
      window.location = '/task/'+parent_task_id;
    } else {
      if(typeof(prj_id) != 'undefined'){
        window.location = '/project/'+prj_id;
      } else {
        window.location = '/projects/all';
      }
    }

  });
</script>
@endsection
