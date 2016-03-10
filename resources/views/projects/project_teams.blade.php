<div class="panel-heading"><i class="picon picon-torsos-all">&nbsp;</i>Project Teams</div>

<div class="panel-body">
  <div class="row">
    <div class="col-md-6">
      <h5 class="underline">Available Teams</h5>

      <div class="panel-group panel_available_teams" id="accordion" role="tablist" aria-multiselectable="true">
      @if($available_teams->count()>0)
          @foreach($available_teams as $value => $team)
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="available{{$value}}">
              <h4 class="panel-title">
                <span class="move-item pull-right add_project_team" data-tid="{{$team->id}}"><i class="glyphicon glyphicon-chevron-right"></i></span>
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAvailable{{$value}}" aria-expanded="false" aria-controls="collapseAvailable{{$value}}">
                  {{$team->name}}
                  <span class="badge pull-right" title="Users on Group">{{$team->users->count()}}</span>
                </a>
              </h4>
            </div>
            <div id="collapseAvailable{{$value}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
              <div class="panel-body">
                <ul class="list-group">
                  @foreach($team->users as $user)
                  <li class="list-group-item"><small>{{$user->name}}</small></li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          @endforeach

    @else

      <div class="no-teams">There are no teams available.</div>

    @endif
      </div>
    </div>
    <div class="col-md-6">
      <h5 class="underline">Project Teams
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" id="create_team" class="pull-right" data-toggle="tooltip" data-placement="top" title="Create a new team"><i class="glyphicon glyphicon-plus"></i></a>
        @endif
      </h5>

      <div class="panel-group panel_project_teams" id="accordion" role="tablist" aria-multiselectable="true">
      @if($project->teams->count()>0)
          @foreach($project->teams as $value => $team)
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{$value}}">
              <h4 class="panel-title">
                @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
                <span class="move-item pull-right remove_project_team" data-tid="{{$team->id}}"><i class="glyphicon glyphicon-chevron-left"></i></span>
                @endif
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$value}}" aria-expanded="false" aria-controls="collapse{{$value}}">
                  {{$team->name}}
                  <span class="badge pull-right" title="Users on Group">{{$team->users->count()}}</span>
                </a>
              </h4>
            </div>
            <div id="collapse{{$value}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$value}}">
              <div class="panel-body">
                <ul class="list-group">
                  @foreach($team->users as $user)
                  <li class="list-group-item"><small>{{$user->name}}</small></li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          @endforeach
      @else

      <div class="no-teams">There are no teams for this project.</div>

      @endif
      </div>
    </div>
  </div>
</div>
