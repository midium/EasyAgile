<form action="{{URL::to('tasks/quick_search')}}" id="quick_search" method="post" class="navbar-form navbar-left" role="search">
    <div class="form-group">
    	<input type="text" name="string" id="string" class="form-control global-query" placeholder="Quick search Issues..." required />
      <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
    </div>
</form>
