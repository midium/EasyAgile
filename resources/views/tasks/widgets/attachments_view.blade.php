<section class="attachments">
  <section class="attachments-preview-content">
    @foreach($task->attachments as $attachment)
    <article class="attachment transition">
      @if($task->project->status->id == 1 || $task->project->status->id == 2 || $task->project->status->id == 3)
      <a href="#" class="dark-link remove-file" id="remove_file" data-id="{{$attachment->id}}" data-view-mode="view" data-toggle="tooltip" data-placement="top" title="Delete"><i class="picon picon-trash-bin"></i></a>
      @endif
      <a href="{{$attachment->getAttachedFile()}}" target="_blank" {{(!IsImageFile($attachment->filename))?'download="'.$attachment->filename.'"':'' }} class="dark-link no-decoration">
        <div class="preview">
          @if(IsImageFile($attachment->filename))
          <img class="attachment-preview" src="{{$attachment->getAttachedFile()}}" />
          @else
          <i class="picon picon-document"></i>
          @endif
        </div>
        <div class="attachment-name">{{$attachment->filename}}</div>
      </a>
    </article>
    @endforeach
  </section>
</section>
