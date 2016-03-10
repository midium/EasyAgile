@foreach($projects as $project)
  @include('projects.items.card')
@endforeach

<?php echo View::make('personal.paginator')->with('paginator', $projects); ?>
