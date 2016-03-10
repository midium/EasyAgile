<div class="container-fluid">
  <div class="row">
      <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
      <input type="hidden" id="id" name="id" value="{{isset($team)?$team->id:''}}" />
      <div class="form-group">
        <label for="name" class="control-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="{{isset($team)?$team->name:''}}" />
      </div>
      <div class="form-group">
        <label for="description" class="control-label">Description:</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" value="{{isset($team)?$team->description:''}}"></textarea>
      </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h5 class="underline">Available Users</h5>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search user..." id="available_user_search">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
        </span>
      </div>
      <div class="users-available-container">
        <ul class="list-group" id="available_user_content">
          @foreach($users as $user)
          <li class="list-group-item" data-uid="{{$user->id}}">{{$user->name}}<i class="glyphicon glyphicon-chevron-right pull-right add_team_user"></i></li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <h5 class="underline">Team Users</h5>
      <div class="users-team-container">
        <ul class="list-group" id="team_users">
          @if($team != null && $team->users()->count() > 0)
            @foreach($team->users as $user)
            <li class="list-group-item" data-uid="{{$user->id}}">{{$user->name}}<i class="glyphicon glyphicon-chevron-left pull-right remove_team_user"></i></li>
            @endforeach
          @endif
        </ul>
      </div>
    </div>
  </div>
</div>


<script>
var teams_ = new Jets({
  searchTag: '#available_user_search',
  contentTag: '#available_user_content'
});

$('body').on('click', 'i.add_team_user', function(event){
  event.preventDefault();

  var uid = $(this).parent().attr('data-uid');

  $('ul#team_users').append($(this).parent());

  $('li[data-uid='+uid+'] i.add_team_user').removeClass('add_team_user').addClass('remove_team_user').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');

});

$('body').on('click', 'i.remove_team_user', function(event){
  event.preventDefault();

  var uid = $(this).parent().attr('data-uid');

  $('ul#available_user_content').append($(this).parent());

  $('li[data-uid='+uid+'] i.remove_team_user').removeClass('remove_team_user').addClass('add_team_user').removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');

});

</script>
