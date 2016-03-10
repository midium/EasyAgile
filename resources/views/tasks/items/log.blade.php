<div class="log-item transition">
  <div class="inline user text-center">
    <img title="{{$log->user->name}}" data-toggle="tooltip" data-placement="right" src="{{$log->user->getAvatarURI()}}" onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}" />
  </div>
  <time class="inline text-middle date">{{substr($log->log_date,0,-9)}}</time>
  <description class="inline text-middle description">{{$log->log_description}}</description>
  <time class="inline text-middle worked">{{$log->getLoggedTime()}}</time>
  @if($log->task->project->status->id == 1 || $log->task->project->status->id == 2 || $log->task->project->status->id == 3)
    @if(!isset($hide_tools) || $hide_tools == false)
      @if(Auth::check() && $log->user_id == Auth::user()->id)
  <div class="inline pull-right remove" id="remove_log"><a href="#" class="dark-link" data-id="{{$log->id}}" data-toggle="tooltip" data-placement="right" title="Remove Log"><i class="picon picon-trash-bin"></i></a></div>
      @endif
  <div class="inline pull-right edit" id="edit_log"><a href="#" class="dark-link" data-id="{{$log->id}}" data-toggle="tooltip" data-placement="left" title="Edit Log"><i class="picon picon-pencil"></i></a></div>
    @endif
  @endif
</div>
