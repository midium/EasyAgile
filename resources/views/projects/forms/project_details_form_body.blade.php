<input type="hidden" name="id" value="{{ (isset($project))?$project->id:'' }}" id="project_id" />
<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />

<div class="row">
    <div class="form-group">
        <label>Name:</label>
        <input id="name" value="{{ (isset($project))?$project->name:'' }}" type="text" name="name" class="form-control" autocomplete="off" placeholder="ex. Easy Agile" required />
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4 no-left-padding">
        <label>Code:</label>
        <input id="code" value="{{ (isset($project))?$project->code:'' }}" type="text" name="code" maxlength="10" class="form-control text-uppercase" autocomplete="off" placeholder="ex. EAGILE" required />
    </div>
    <div class="form-group col-md-8 no-right-padding">
        <label>Status:</label>
        <!--<input id="code" value="{{ (isset($project))?$project->code:'' }}" type="text" name="code" maxlength="10" class="form-control text-uppercase" autocomplete="off" placeholder="ex. EAGILE" required />-->
        <select class="form-control selectpicker" name="status_id" id="status_id" required>
            @foreach($project_statuses as $status)
            <option value="{{$status->id}}" {{( isset($project) && $status->id == $project->status->id)?'selected="selected"':''}} data-content="<img class='project-icon' src='{{asset("/assets/project_status_icons/".$status->id.".png")}}' /></span><span style='display:inline-block;'>&nbsp;{{$status->name}}</span>"</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Description:</label>
        <input id="description" value="{{ (isset($project))?$project->description:'' }}" type="text" name="description" class="form-control" autocomplete="off" placeholder="ex. Easy Agile is an application which will simply allow you to manage Agile groups." />
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Project Manager:</label>
        <div class="form-control-wrapper">
          <select class="form-control selectpicker" name="manager_id" id="manager_id" required>
              @foreach($users as $user)
            <option value="{{$user->id}}" {{( isset($project) && ($user->id == $project->manager->id))?'selected="selected"':''}} data-content="<img class='option-img project-icon' height='16' src='{{$user->getAvatarURI()}}' onerror='this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}' /></span><span style='display:inline-block;'>&nbsp;{{$user->name}}</span>"</option>
              @endforeach
          </select>

        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Project Icon:</label>
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-addon">Current</span>
              <span class="input-group-addon"><img class="project-icon-no-padding-no-margin" src="{{(isset($project))?$project->getProjectIcon():asset('storage/app/projects_icons/default.png') }}" /></span>
            </div>
          </div>
          <div class="col-md-8">
            <div class="input-group">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                <div class="fileinput-tools">
                  <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input id="image" name="image" type="file" accept="image/*"></span>
                  <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<script>
  $('.selectpicker').selectpicker();
</script>
