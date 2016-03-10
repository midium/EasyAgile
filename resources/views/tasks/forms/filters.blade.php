<form method="post" class="form" action="/tasks/filter" id="filters_form">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
          <label>Subject:</label>
          <input id="subject" value="" type="text" name="subject" class="form-control" autocomplete="off" />
      </div>

      <div class="form-group">
          <label>Code:</label>
          <input id="code" value="" type="text" name="code" maxlength="10" class="form-control text-uppercase" autocomplete="off" />
      </div>

      <div class="form-group">
          <label>Project:</label>
          <div class="form-control-wrapper">
            <select class="form-control selectpicker" name="project_id" id="project_id" >
            @if(isset($projects))
              <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/question.png')}}' /></span><span style='display:inline-block;'>&nbsp;All</span>"</option>
              @foreach($projects as $prj)
              <option value="{{$prj->id}}" data-content="<img class='project-icon' src='{{$prj->getProjectIcon()}}' /></span><span style='display:inline-block;'>&nbsp;{{$prj->name}}</span>"</option>
              @endforeach
            @endif
            </select>

          </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
          <label>Status:</label>
          <select class="form-control selectpicker" name="status_id" id="status_id">
              <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/question.png')}}' /></span><span style='display:inline-block;'>&nbsp;All</span>"</option>
              @foreach($task_statuses as $status)
              <option value="{{$status->id}}" data-content="<img class='project-icon' src='{{asset("/assets/task_status_icons/".$status->id.".png")}}' /></span><span style='display:inline-block;'>&nbsp;{{$status->name}}</span>"</option>
              @endforeach
          </select>
      </div>

      <div class="form-group">
          <label class="control-label">Issue Type:</label>
          <div class="form-control-wrapper">
              <select class="form-control selectpicker" name="task_type_id" id="task_type_id" >
                <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/question.png')}}' /></span><span style='display:inline-block;'>&nbsp;All</span>"</option>
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

      <div class="form-group">
        <label class="control-label">Task Priority:</label>
        <div class="form-control-wrapper">
          <select class="form-control selectpicker" name="priority_id" id="priority_id" >
          @if(isset($priorities))
            <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/question.png')}}' /></span><span style='display:inline-block;'>&nbsp;All</span>"</option>
            @foreach($priorities as $priority)
            <option value="{{$priority->id}}" data-content="<img class='project-icon' src='{{asset('/assets/task_priority_icons/'.$priority->id.'.png')}}' /></span><span style='display:inline-block;'>&nbsp;{{$priority->name}}</span>"</option>
            @endforeach
          @endif
          </select>
        </div>
      </div>

    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label class="control-label">From Date:</label>
        <div class='input-group date' id='from_date_picker'>
          <input type="text" class="form-control" name="from_date" id="from_date" value="">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label">To Date:</label>
        <div class='input-group date' id='to_date_picker'>
          <input type="text" class="form-control" name="to_date" id="to_date" value="">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label class="control-label">Assigned to:</label>
        <div class="form-control-wrapper">
          <select class="form-control selectpicker" name="owned_by" id="owned_by" >
            <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/unassigned.png')}}' /></span><span style='display:inline-block;'>&nbsp;Unassigned</span>"</option>
            @if(isset($users))
              @foreach($users as $user)
            <option value="{{$user->id}}" data-content="<img class='option-img project-icon' height='16' src='{{$user->getAvatarURI()}}' onerror='this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}' /></span><span style='display:inline-block;'>&nbsp;{{$user->name}}</span>"</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label">Reported by:</label>
        <div class="form-control-wrapper">
          <select class="form-control selectpicker" name="reported_by" id="reported_by" >
            <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/unassigned.png')}}' /></span><span style='display:inline-block;'>&nbsp;All</span>"</option>
            @if(isset($users))
              @foreach($users as $user)
            <option value="{{$user->id}}" data-content="<img class='option-img project-icon' height='16' src='{{$user->getAvatarURI()}}' onerror='this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}' /></span><span style='display:inline-block;'>&nbsp;{{$user->name}}</span>"</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>

      <div class="form-group pull-right task-filter-search">
        <button type="submit" class="btn btn-primary" id="search_projects"><i class="glyphicon glyphicon-search">&nbsp;</i>Search</button>
      </div>

    </div>
  </div>
</form>
