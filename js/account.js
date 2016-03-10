$('body').on('click', '.selectable', function(event){
  event.preventDefault();

  $('.selected-avatar').removeClass('selected-avatar');
  $(this).addClass('selected-avatar');

});

$("input:file").change(function (){
   $('form#upload_avatar').submit();
});

$('body').on('submit', 'form#upload_avatar', function(event){
	event.preventDefault();

	var uri = $(this).attr('action');
	var data = new FormData($(this)[0]);

	jQuery.ajax({
    url: uri,
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(response){
			if(response.success == false){
				swal('Error', response.error, 'error');
			} else {
        $('img#header_avatar').attr('src', response.value);
        $('img#top_header_avatar').attr('src', response.value);
      }
    }
	});

});

$('body').on('click', '#use_gravatar', function(event){
  event.preventDefault();

  $.post('account/use_gravatar',{'_token': $('input#token').val()} , function(response){
    if(response.success == false){
      swal('Error', response.error, 'error');
    } else {
      $('img#header_avatar').attr('src', response.value);
      $('img#top_header_avatar').attr('src', response.value);
    }
  })
});

$('body').on('click', 'a#change_password', function(event){
  event.preventDefault();

  $('#passwordModal').modal();

});

$('body').on('submit', 'form#password_form', function(event){
  event.preventDefault();

  var action = $(this).attr('action');

  $.post(action, $(this).serialize(), function(response){
    if(response.success == false){
      swal('Error', response.error, 'error');
    } else {
      swal('Success', 'Password correctly updated', 'success');

      $('input#current').val('');
      $('input#new').val('');
      $('input#confirm').val('');

      $('#passwordModal').modal('hide');
    }
  });
});

$('body').on('click', 'button#cancel_password', function(event){
  $('input#current').val('');
  $('input#new').val('');
  $('input#confirm').val('');
});

$('body').on('click', 'a#edit_username', function(event){
  event.preventDefault();

  $('#username_holder>div#view').hide();
  $('#username_holder>div#edit').show();

});

$('body').on('click', 'a#edit_user_theme', function(event){
  event.preventDefault();

  $('#themes_holder>div#view').hide();
  $('#themes_holder>div#edit').show();

});

$('body').on('click', 'button#username_cancel', function(event){
  event.preventDefault();

  $('#username_holder>div#view').show();
  $('#username_holder>div#edit').hide();

});

$('body').on('click', 'a#edit_email', function(event){
  event.preventDefault();

  $('#email_holder>div#view').hide();
  $('#email_holder>div#edit').show();

});

$('body').on('click', 'button#email_cancel', function(event){
  event.preventDefault();

  $('#email_holder>div#view').show();
  $('#email_holder>div#edit').hide();

});

$('body').on('click', 'button#themes_cancel', function(event){
  $('#themes_holder>div#view').show();
  $('#themes_holder>div#edit').hide();
});


$('body').on('submit', 'form#update_username', function(event){
  event.preventDefault();

  var action = $(this).attr('action');

  $.post(action, $(this).serialize(), function(response){
    if(response.success == false){
      swal('Error', response.error, 'error');
    } else {

      $('#username_holder>div#view>span').html(response.value);
      $('#username_holder>div#view').show();
      $('#username_holder>div#edit').hide();
    }
  });
});

$('body').on('submit', 'form#update_user_theme', function(event){
  event.preventDefault();

  var action = $(this).attr('action');

  $.post(action, $(this).serialize(), function(response){
    if(response.success == false){
      swal('Error', response.error, 'error');
    } else {

      $('#themes_holder>div#view>span').html(response.value);
      $('#themes_holder>div#view').show();
      $('#themes_holder>div#edit').hide();

      location.reload();
    }
  });
});

$('body').on('submit', 'form#update_email', function(event){
  event.preventDefault();

  var action = $(this).attr('action');

  $.post(action, $(this).serialize(), function(response){
    if(response.success == false){
      swal('Error', response.error, 'error');
    } else {

      $('#email_holder>div#view>span').html(response.value);
      $('#email_holder>div#view').show();
      $('#email_holder>div#edit').hide();
    }
  });
});
