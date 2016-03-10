<section class="attachments">
  <section class="attachments-header">
    <div class="inline name">Name</div>
    <div class="inline date">Date</div>
    <div class="inline size">Size</div>
    <div class="inline tools">Tools</div>
  </section>
  <section class="attachments-content">
    @foreach($task->attachments as $attachment)
    <article class="attachment-item transition">
      <div class="inline name">{{$attachment->filename}}</div>
      <time class="inline date">{{substr($attachment->created_at,0,10)}}</time>
      <div class="inline size">{{formatBytes($attachment->size)}}</div>
      <div class="inline tools">
        @if($task->project->status->id == 1 || $task->project->status->id == 2 || $task->project->status->id == 3)
        <a href="{{$attachment->getAttachedFile()}}" download="{{$attachment->filename}}" target="_blank" class="dark-link" id="download" data-toggle="tooltip" data-placement="top" title="Download"><i class="picon picon-download"></i></a>
        @if(IsImageFile($attachment->filename))
        <a href="{{$attachment->getAttachedFile()}}" target="_blank" class="dark-link" id="view" data-toggle="tooltip" data-placement="top" title="Preview"><i class="picon picon-eye"></i></a>
        @endif
        <a href="#" class="dark-link" id="remove_file" data-id="{{$attachment->id}}" data-view-mode="list" data-toggle="tooltip" data-placement="top" title="Delete"><i class="picon picon-trash-bin"></i></a>
        @endif
      </div>
    </article>
    @endforeach
  </section>
</section>

<script>
$('[data-toggle="tooltip"]').tooltip();
</script>
