@foreach($tasks as $task_item)
    @include('tasks.items.card')
@endforeach
<?php echo View::make('personal.paginator')->with('paginator', $tasks); ?>
