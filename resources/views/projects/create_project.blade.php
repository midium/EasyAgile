@extends('app')

@section('content')
<div class="container">
  <div class="row">
    &nbsp;
  </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{$title}} Project</div>

                <div class="panel-body">
                    <div class="container-fluid">
                    @include('projects.project_details_form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('beforebodyend')
<script>
$('body').on('click', 'button#cancel', function(event){
  event.preventDefault();

  window.location = '/projects';
});
</script>
@endsection
