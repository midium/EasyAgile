<form method="post" class="form" action="/projects/filter" id="filters_form">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />

  <div class="form-group">
      <label>Name:</label>
      <input id="name" value="" type="text" name="name" class="form-control" autocomplete="off" placeholder="ex. Easy Agile" />
  </div>

  <div class="form-group">
      <label>Code:</label>
      <input id="code" value="" type="text" name="code" maxlength="10" class="form-control text-uppercase" autocomplete="off" placeholder="ex. EAGILE" />
  </div>

  <div class="form-group">
      <label>Project Manager:</label>
      <div class="form-control-wrapper">
        <select class="form-control selectpicker" name="manager_id" id="manager_id">
          <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/unassigned.png')}}' /></span><span style='display:inline-block;'>&nbsp;All</span>"</option>
            @foreach($users as $user)
          <option value="{{$user->id}}" data-content="<img class='option-img project-icon' height='16' src='{{$user->getAvatarURI()}}' onerror='this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}' /></span><span style='display:inline-block;'>&nbsp;{{$user->name}}</span>"</option>
            @endforeach
        </select>

      </div>
  </div>

  <div class="form-group">
      <label>Status:</label>
      <select class="form-control selectpicker" name="status_id" id="status_id">
          <option value="-1" data-content="<img class='project-icon' src='{{asset('/assets/question.png')}}' /></span><span style='display:inline-block;'>&nbsp;All</span>"</option>
          @foreach($project_statuses as $status)
          <option value="{{$status->id}}" data-content="<img class='project-icon' src='{{asset("/assets/project_status_icons/".$status->id.".png")}}' /></span><span style='display:inline-block;'>&nbsp;{{$status->name}}</span>"</option>
          @endforeach
      </select>
  </div>

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

  <div class="form-group pull-right">
    <button type="submit" class="btn btn-primary" id="search_projects"><i class="glyphicon glyphicon-search">&nbsp;</i>Search</button>
  </div>

</form>
