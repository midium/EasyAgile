@extends('app')

@section('content')
<div class="container-fluid account-page">
    <div class="row">&nbsp;</div>
    <div class="row">
        <div class="col-lg-4">
          <div class="panel panel-default">
              <div class="panel-heading"><strong>Account Details</strong></div>

              <div class="panel-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <label class="pull-right">Avatar:</label>
                    </div>
                    <div class="col-md-2 text-center">
                      <div><i>Gravatar</i></div>
                      <img id="use_gravatar" class="thumbnail selectable {{($user->use_gravatar)?'selected-avatar':''}}" width="50" height="50" src="http://gravatar.com/avatar/{{md5( $user->email )}}"  onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}'" />&nbsp;&nbsp;
                    </div>
                    <div class="col-md-3-bigger text-center account-avatar">
                      <div><i>Personal</i></div>
                      <form action="{{url('account/upload_avatar')}}" method="post" id="upload_avatar" enctype="multipart/form-data">
                        <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-preview thumbnail selectable {{($user->use_gravatar == false)?'selected-avatar':''}}" data-trigger="fileinput"><img width="50" height="50" src="{{asset( 'storage/app/users_avatars/'.$user->id.'.png' )}}"  onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}'" /></div>
                          <div class="fileinput-tools">
                            <span class="btn btn-default btn-sm btn-file"><span class="fileinput-new">Choose Avatar</span><span class="fileinput-exists">Change</span><input id="image" name="image" type="file" accept="image/*"></span>
                            <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput">Remove</a>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label class="pull-right">Username:</label>
                    </div>
                    <div class="col-md-9" id="username_holder">
                      <div id="view">
                        <span>{{$user->name}}</span>
                        <a id="edit_username"><i class="picon picon-pencil"></i></a>
                      </div>
                      <div id="edit">
                        <form method="post" action="account/update_username" id="update_username">
                          <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
                          <input type="hidden" id="id" name="id" value="{{$user->id}}" />
                          <div class="input-group input-group-sm">
                            <input class="form-control" type="text" id="name" name="name" value="{{$user->name}}" required/>
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-floppy-save"></i></button>
                              <button class="btn btn-default" type="button" id="username_cancel"><i class="glyphicon glyphicon-remove"></i></button>
                            </span>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label class="pull-right">Email:</label>
                    </div>
                    <div class="col-md-9" id="email_holder">
                      <div id="view">
                        <span>{{$user->email}}</span>
                        <a id="edit_email"><i class="picon picon-pencil"></i></a>
                      </div>
                      <div id="edit">
                        <form method="post" action="account/update_email" id="update_email">
                          <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
                          <input type="hidden" id="id" name="id" value="{{$user->id}}" />
                          <div class="input-group input-group-sm">
                            <input class="form-control" type="text" id="email" name="email" value="{{$user->email}}" required />
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-floppy-save"></i></button>
                              <button class="btn btn-default" type="button" id="email_cancel"><i class="glyphicon glyphicon-remove"></i></button>
                            </span>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label class="pull-right">Password:</label>
                    </div>
                    <div class="col-md-9">
                      <span><a href="#" id="change_password">Change password</a></span>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="panel panel-default">
              <div class="panel-heading"><strong>Account Preferences</strong></div>

              <div class="panel-body">
                <div class="row">
                  <div class="col-md-3">
                    <label class="pull-right">Theme:</label>
                  </div>
                  <div class="col-md-7" id="themes_holder">
                    <div id="view">
                      <span>{{$user->theme}}</span>
                      <a id="edit_user_theme"><i class="picon picon-pencil"></i></a>
                    </div>
                    <div id="edit">
                      <form method="post" action="account/update_user_theme" id="update_user_theme">
                        <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" id="id" name="id" value="{{$user->id}}" />
                        <div class="input-group input-group-sm">
                          <select class="form-control" id="theme" name="theme" required >
                            @foreach($themes as $theme)
                            <option value="{{$theme}}" {{($user->theme == $theme)?'selected="selected"':''}}>{{$theme}}</option>
                            @endforeach
                          </select>
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-floppy-save"></i></button>
                            <button class="btn btn-default" type="button" id="themes_cancel"><i class="glyphicon glyphicon-remove"></i></button>
                          </span>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="panel panel-default">
              <div class="panel-heading"><strong>User Activity</strong></div>

              <div class="panel-body">
                <div class="container-fluid">
                  <div class="row">
                    <span>No activity recorded for this user so far</span>
                  </div>
                </div>
              </div>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModal">
  <form action="{{url('account/update_password')}}" method="post" id="password_form" class="form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="exampleModalLabel">Change your Password</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="id" value="{{$user->id}}" id="id" />
              <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />

              <div class="row">
                  <div class="form-group">
                      <label>Current Password:</label>
                      <input id="current" value="" type="password" name="current" class="form-control" autocomplete="off" required />
                  </div>
                  <div class="form-group">
                      <label>New Password:</label>
                      <input id="new" value="" type="password" name="new" class="form-control" autocomplete="off" required />
                  </div>
                  <div class="form-group">
                      <label>Confirm Password:</label>
                      <input id="confirm" value="" type="password" name="confirm" class="form-control" autocomplete="off" required />
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="cancel_password">Cancel</button>
        <button type="submit" class="btn btn-primary" id="save_role">Change Password</button>
      </div>
    </div>
  </div>
  </form>
</div>
@endsection

@section('js-includes')
<script src="{{ asset('/js/account.js') }}"></script>
@endsection
