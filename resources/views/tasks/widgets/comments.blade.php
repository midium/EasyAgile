<section class="comments">
  @if($task->task_comments != null && $task->task_comments()->count() > 0)
    @foreach($task->task_comments as $comment)
  <div class="comment">
    <div class="comment-avatar pull-left clearfix">
      <img src="{{$comment->user->getAvatarURI()}}" onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}" />
    </div>
    <div class="comment-content inline clearfix">
      <div class="comment-header">
        <span class="comment-user">
          {{$comment->user->name}}
        </span>
        <time class="comment-date pull-right">
          {{$comment->created_at}}
        </time>
      </div>
      <div class="comment-body">
        <?php echo html_entity_decode($comment->body,ENT_HTML5,'UTF-8'); ?>
      </div>
      <div class="comment-tools pull-right">
        @if($task->project->status->id == 1 || $task->project->status->id == 2 || $task->project->status->id == 3)
        @if((Auth::check() && $comment->user_id == Auth::user()->id))
        <button type="button" id="edit_comment" class="btn btn-default btn-xs" data-id="{{$comment->id}}"><i class="picon picon-pencil">&nbsp;</i>Edit</button>
        @endif
        <button type="button" id="quote_comment" class="btn btn-default btn-xs"><i class="picon picon-quote-1">&nbsp;</i>Quote</button>
        <button type="button" id="add_comment" class="btn btn-default btn-xs"><i class="picon picon-reply">&nbsp;</i>Reply</button>
        @endif
      </div>
    </div>
  </div>
    @endforeach
  @else
  <p>There are no comments yet on this issue.</p>
  @endif

</section>
<div class="comment-tools pull-right">
  @if($task->project->status->id == 1 || $task->project->status->id == 2 || $task->project->status->id == 3)
  <button type="button" id="add_comment" class="btn btn-default btn-sm">New Comment</button>
  @endif
</div>
