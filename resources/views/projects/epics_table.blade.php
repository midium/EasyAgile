<table class="table table-bordered table-hover table-condensed table-striped">
  <thead>
    <tr>
      <th class="hidden">ID</th>
      <th>Name</th>
      <th>Description</th>
      @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
      <th class="epic-tools"></th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach($epics as $epic)
    <tr>
      <td class="hidden" id="epic_id">{{$epic->id}}</td>
      <td>{{$epic->name}}<div class="epic_color" style="background: {{$epic->color}};">&nbsp;</div></td>
      <td>{{$epic->description}}</td>
      @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
      <td class="text-center">
        <a href="{{url('project/get_epic')}}" class="btn btn-default btn-xs" title="Edit" id="edit_epic" data-toggle="tooltip" data-placement="right"><i class="picon picon-pencil-3"></i></a>
        <a href="{{url('project/remove_epic')}}" class="btn btn-default btn-xs" title="Remove" id="remove_epic" data-toggle="tooltip" data-placement="right"><i class="picon picon-cup"></i></a>
      </td>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>
