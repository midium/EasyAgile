$('[data-toggle="tooltip"]').tooltip();

$('body').on('click', 'button#role', function(event){
	event.preventDefault();

	$('#roleModal').modal();
});

$('body').on('submit', 'form#role_form', function(event){
	event.preventDefault();

	var uri = $(this).attr('action');

	$('div.role-loading').show();

	$.post(uri, {'id': $('form#role_form input#role_id').val(), 'name': $('form#role_form input#name').val(),  '_token': $('form#role_form input#token').val()}, function(response){

		if(response.success !== false){
			$('div#roles_container').html(response.value);

		} else {
			swal('Error', response.error, 'error');
		}

	});

	$('form#role_form input#name').val('');
	$('div.role-loading').hide();

	$('#roleModal').modal('hide');

});

$('body').on('click', 'button#cancel_role', function(){
	$('form#role_form input#name').val('');
	$('form#role_form input#role_id').val('');
});

$('#roleModal').on('shown.bs.modal', function () {
  $('form#role_form input#name').focus();
})

$('body').on('click', 'a#role_delete', function(event){
	event.preventDefault();

	$('div.role-loading').show();

	var uri = $(this).attr('href');
	var role_id = $(this).parent().parent().find('#role_id').html();

	$.post(uri, {'id': role_id,  '_token': $('input#token').val()}, function(response){

		if(response.success !== false){
			$('div#roles_container').html(response.value);

		} else {
			swal('Error', response.error, 'error');
		}

	});

	$('div.role-loading').hide();
});

$('body').on('click', 'a#edit_role', function(event){
	event.preventDefault();

	var uri = $(this).attr('href');
	var role_id = $(this).parent().parent().find('#role_id').html();

	$.post(uri, {'id': role_id,  '_token': $('input#token').val()}, function(response){

		if(response.success !== false){
			$('form#role_form input#name').val(response.value.name);
			$('form#role_form input#role_id').val(response.value.id);

			$('#roleModal').modal();

		} else {
			swal('Error', response.error, 'error');
		}

	});

});

$('body').on('click', 'a#user_privilege_role', function(event){
	event.preventDefault();

	var uri = $(this).attr('href');
	var user_id = $(this).parent().parent().find('#user_id').html();

	$.post(uri, {'id': user_id,  '_token': $('input#token').val()}, function(response){
		if(response.success !== false){
			$('div#users_form_container').html(response.value);
			$('#userModal').modal('show');
		} else {
			swal('Error', response.error, 'error');
		}
	});

});

$('body').on('click', 'a#remove_user', function(event){
	event.preventDefault();

	$('div.user-loading').show();

	var uri = $(this).attr('href');
	var user_id = $(this).parent().parent().find('#user_id').html();

	$.post(uri, {'id': user_id,  '_token': $('input#token').val()}, function(response){
		if(response.success !== false){
			$('div#users_container').html(response.value);

		} else {
			swal('Error', response.error, 'error');
		}
	});

	$('div.user-loading').hide();

});

$('body').on('submit', 'form#user_form', function(event){
	event.preventDefault();

	var uri = $(this).attr('action');

	$('div.user-loading').show();

	$.post(uri, {'user_id': $('form#user_form input#user_id').val(),
							 'privilege_id': $('form#user_form select#privilege_id').val(),
							 'role_id': $('form#user_form select#role_id').val(),
							 '_token': $('form#user_form input#token').val()}, function(response){

		if(response.success !== false){
			$('div#users_container').html(response.value);

		} else {
			swal('Error', response.error, 'error');
		}

	});

	$('form#role_form input#name').val('');
	$('div.user-loading').hide();

	$('#roleModal').modal('hide');

});

$('body').on('click', 'button#project', function(event){
	event.preventDefault();

	$.post('setup/get_project', {'prj_id': null, '_token': $('input#token').val()}, function(response){
		if(response.success !== false){
			$('div#prj_form_body').html(response.value);
		}
	});

	$('#prjModal').modal();
});

$('body').on('submit', 'form#prj_form', function(event){
	event.preventDefault();

	var uri = $(this).attr('action');

	$('div.project-loading').show();

	var data = new FormData($(this)[0]);

	jQuery.ajax({
    url: uri,
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(response){
			if(response.success !== false){
				$('div#project_container').html(response.value);

			} else {
				swal('Error', response.error, 'error');
			}
    }
	});

	$('div.project-loading').hide();

	$('#prjModal').modal('hide');

});

$('body').on('click', 'a#delete_prj', function(event){
	event.preventDefault();

	$('div.project-loading').show();

	var uri = $(this).attr('href');
	var prj_id = $(this).parent().parent().find('#prj_id').html();

	$.post(uri, {'id': prj_id,  '_token': $('input#token').val()}, function(response){

		if(response.success !== false){
			$('div#project_container').html(response.value);

		} else {
			swal('Error', response.error, 'error');
		}

	});

	$('div.project-loading').hide();
});

$('body').on('click', 'a#edit_prj', function(event){
	event.preventDefault();

	var uri = $(this).attr('href');
	var prj_id = $(this).parent().parent().find('#prj_id').html();

	$.post(uri, {'prj_id': prj_id, '_token': $('input#token').val()}, function(response){
		if(response.success !== false){
			$('div#prj_form_body').html(response.value);
		}
	});

	$('#prjModal').modal();

});


$('body').on('click', 'button#create_team', function(event){
	event.preventDefault();

	$.post('setup/get_team', {'team_id': null, '_token': $('input#token').val()}, function(response){
		if(response.success !== false){
			$('div#team_form_modal_content').html(response.value);
		}
	});

	$('#teamCreateModal').modal();
});

$('body').on('submit', 'form#team_form', function(event){
	event.preventDefault();

	$('div.teams-loading').show();

	var uri = $(this).attr('action');
	var id = $('form#team_form input#id').val();
	var name = $('form#team_form input#name').val();
	var description = $('form#team_form textarea#description').val();

	var users = '';
	$('ul#team_users li').each(function(){
		users = users + $(this).attr('data-uid') + ',';
	});

	users = users.substr(0,users.length-1);

	$.post(uri, {'id': id, 'name': name, 'description': description, 'users': users,  '_token': $('input#token').val()}, function(response){

		if(response.success !== false){
			$('div#teams_container').html(response.value);

		} else {
			swal('Error', response.error, 'error');
		}

	});

	$('div.teams-loading').hide();

});

$('body').on('click', 'a#remove_team', function(event){
	event.preventDefault();

	$('div.teams-loading').show();

	var team_id = $(this).parent().parent().find('#team_id').html();
	var uri = $(this).attr('href');

	$.post(uri, {'id': team_id,  '_token': $('input#token').val()}, function(response){

		if(response.success !== false){
			$('div#teams_container').html(response.value);

		} else {
			swal('Error', response.error, 'error');
		}

	});

	$('div.teams-loading').hide();
});

$('body').on('click', 'a#edit_team', function(event){
	event.preventDefault();

	var uri = $(this).attr('href');
	var team_id = $(this).parent().parent().find('#team_id').html();

	$.post(uri, {'team_id': team_id, '_token': $('input#token').val()}, function(response){
		if(response.success !== false){
			$('div#team_form_modal_content').html(response.value);
		}
	});

	$('#teamCreateModal').modal();

});

$('body').on('click', 'a#reset_user_password', function(event){
	event.preventDefault();

	var uri = $(this).attr('href');
	var user_email = $(this).parent().parent().find('#user_email').html();

	$.post(uri, {'email': user_email, '_token': $('input#token').val()}, function(response){
		if(response.success == false){
			swal('Error', response.error, 'error');
		} else {
			swal('Success', response.value, 'success');
		}
	});

});
