$('[data-toggle="tooltip"]').tooltip();

$('body').on('click', 'a#create_team', function(event){
	event.preventDefault();

	$.post('/project/get_team', {'team_id': null, '_token': $('input#token').val()}, function(response){
		if(response.success !== false){
			$('div#team_form_modal_content').html(response.value);
			$('#teamCreateModal').modal();
		}
	});

});

$('body').on('submit', 'form#team_form', function(event){
	event.preventDefault();

	var uri = $(this).attr('action');
	var id = $('form#team_form input#id').val();
	var name = $('form#team_form input#name').val();
	var description = $('form#team_form textarea#description').val();
	var project_id = $('input#project_id').val();

	var users = '';
	$('ul#team_users li').each(function(){
		users = users + $(this).attr('data-uid') + ',';
	});

	users = users.substr(0,users.length-1);

	$.post(uri, {'id': id, 'project_id': project_id, 'name': name, 'description': description, 'users': users,  '_token': $('input#token').val()}, function(response){

		if(response.success !== false){
			$('div#teams_container').html(response.value);
			$('#teamCreateModal').modal('hide');

		} else {
			swal('Error', response.error, 'error');
		}

	});

});

$('body').on('click', 'button#create_epic', function(event){
	event.preventDefault();

	var token = $('input#token').val();

	$.post('/project/get_epic', {'_token': token}, function(response){
		if(response.success == true){
			$('div#epic_form_body').html(response.value);

			$('#epicModal').modal();
		}
	});

});

$('body').on('click', 'a#edit_epic', function(event){
	event.preventDefault();

	var uri = $(this).attr('href');
	var token = $('input#token').val();
	var epic_id = $(this).parent().parent().find('#epic_id').html();
	var project_id = $('input#project_id').val();

	$.post(uri, {'_token': token, 'id': epic_id, 'project_id': project_id}, function(response){
		if(response.success){
			$('div#epic_form_body').html(response.value);

			$('#epicModal').modal();

		} else {
			swal('Error', response.error, 'error');
		}

	});

});

$('body').on('submit', 'form#epic_form', function(event){
	event.preventDefault();

	var uri = $(this).attr('action');

	$.post(uri, $(this).serialize(), function(response){
		if(response.success){
			$('div#epics_list').html(response.value);

			$('#epicModal').modal('hide');

		} else {
			swal('Error', response.error, 'error');
		}
	});
});

$('body').on('click', 'a#remove_epic', function(event){
	event.preventDefault();

	var uri = $(this).attr('href');
	var token = $('input#token').val();
	var epic_id = $(this).parent().parent().find('#epic_id').html();
	var project_id = $('input#project_id').val();

	$.post(uri, {'_token': token, 'epic_id': epic_id, 'project_id': project_id}, function(response){
		if(response.success){
			$('div#epics_list').html(response.value);

		} else {
			swal('Error', response.error, 'error');
		}

	});

});

$('body').on('click', 'span.add_project_team', function(event){
	event.preventDefault();

	var tid = $(this).attr('data-tid');
	var token = $('input#token').val();
	var project_id = $('input#project_id').val();

	var thisObj = $(this);

	$.post('/project/add_team', {'_token': token, 'project_id': project_id, 'team_id': tid}, function(response){
		if(response.success){
			thisObj.removeClass('add_project_team').addClass('remove_project_team');
			thisObj.find('i').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');

			$('div.panel_project_teams').find('.no-teams').remove();
			$('div.panel_project_teams').append(thisObj.parent().parent().parent()).fadeIn(1000);
/*			thisObj.parent().parent().parent().fadeOut(1000).delay(1000, function(obj){
				thisObj.parent().parent().parent().appendTo('div.panel_project_teams').fadeIn(1000);
			});*/

		} else {
			swal('Error', response.error, 'error');
		}
	});

});

$('body').on('click', 'span.remove_project_team', function(event){
	event.preventDefault();

	var tid = $(this).attr('data-tid');
	var token = $('input#token').val();
	var project_id = $('input#project_id').val();

	var thisObj = $(this);

	$.post('/project/remove_team', {'_token': token, 'project_id': project_id, 'team_id': tid}, function(response){
		if(response.success){
			thisObj.removeClass('remove_project_team').addClass('add_project_team');
			thisObj.find('i').removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');

			$('div.panel_available_teams').find('.no-teams').remove();
			$('div.panel_available_teams').append(thisObj.parent().parent().parent()).fadeIn(1000);

		} else {
			swal('Error', response.error, 'error');
		}
	});

});
