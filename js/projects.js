$('[data-toggle="tooltip"]').tooltip();

var linkage = $(".linked").sortable({
  group: 'linked',
	containerSelector: '.tasks-container',
	itemSelector: '.task-card',
  distance: 10,
	placeholder: '<div class="drag-placeholder"/>',
  pullPlaceholder: false,
  // animation on drop
  onDrop: function  ($item, container, _super) {

    var data = linkage.sortable("serialize").get();
    var jsonString = JSON.stringify(data, null, ' ');
    var token = $('input#token').val();

    if ( $('.sprint-tasks-container').length && $('.sprint-tasks-container').hasClass('linked') ) {
      var sprint_id = $('.sprint-tasks-container').attr('data-id');

  		$.post('/project/task_to_sprint', {'data': jsonString, '_token': token, 'sprint_id': sprint_id}, function(response){
  			if(response.success === false){
          swal({
            title: "Error",
            text: response.error,
            type: "error"
          },
          function(){
            location.reload();
          });

  			} else {
          $('h4.sprint > .issues-count').html(response.value.sprint_tasks + ' issues');
          $('h4.tasks > .issues-count').html(response.value.backlog_tasks + ' issues');

        }
  		});

    } else {
      $.post('/project/sort_tasks', {'data': jsonString, '_token': token}, function(response){
  			if(response.success === false){
          swal({
            title: "Error",
            text: response.error,
            type: "error"
          },
          function(){
            location.reload();
          });
        }
  		});

    }

    _super($item, container);

  },

  // set $item relative to cursor position
  onDragStart: function ($item, container, _super) {
    var offset = $item.offset(),
        pointer = container.rootGroup.pointer;

    adjustment = {
      left: pointer.left - offset.left,
      top: pointer.top - offset.top
    };

    _super($item, container);
  },
  onDrag: function ($item, position, _super) {
    $item.css({
      left: position.left - adjustment.left,
      top: position.top - adjustment.top
    });
  }
});

var alone_linkage = $(".standalone").sortable({
	containerSelector: '.tasks-container',
	itemSelector: '.task-card',
  distance: 10,
	placeholder: '<div class="drag-placeholder"/>',
  pullPlaceholder: false,
  // animation on drop
  onDrop: function  ($item, container, _super) {

    var data = alone_linkage.sortable("serialize").get();
    var jsonString = JSON.stringify(data, null, ' ');
    var token = $('input#token').val();

    if ( $('.standalone').length) {
      $.post('/project/sort_tasks', {'data': jsonString, '_token': token}, function(response){
  			if(response.success === false){
          swal({
            title: "Error",
            text: response.error,
            type: "error"
          },
          function(){
            location.reload();
          });
        }
  		});

    }

    _super($item, container);

  },

  // set $item relative to cursor position
  onDragStart: function ($item, container, _super) {
    var offset = $item.offset(),
        pointer = container.rootGroup.pointer;

    adjustment = {
      left: pointer.left - offset.left,
      top: pointer.top - offset.top
    };

    _super($item, container);
  },
  onDrag: function ($item, position, _super) {
    $item.css({
      left: position.left - adjustment.left,
      top: position.top - adjustment.top
    });
  }
});

$('body').on('change', '.epics-container > .checkbox', function(event){
  event.preventDefault();

  if ( $("input[type='checkbox']").is(':checked') ) {
    $('.task-card.completed').addClass('hidden');
  } else {
    $('.task-card.completed').removeClass('hidden');
  }

});

$('body').on('click', '.epics-container > .list-group > .list-group-item.small', function(event){
	event.preventDefault();

	var epic_id = $(this).attr('data-id');

	if(epic_id == 'all'){
		$('.task-card').show();
	} else {
		$('.task-card[data-epic-id!="'+ epic_id +'"]').hide();
		$('.task-card[data-epic-id="'+ epic_id +'"]').show();
	}
});

/* SPRINT RELATED */
$('body').on('click', '#create_sprint', function(event){
  event.preventDefault();

  var project_id = $('#project_id').val();
  var token = $('#token').val();

  $.post('/project/get_sprint', {'prj_id': project_id, '_token': token}, function(response){
    if(response.success !== true){
      swal('Error', response.error, 'error');
    } else {
      $('div#sprintModal').html(response.value);
      $('div#sprintModal').modal();
    }
  });

});

$('body').on('submit', 'form#sprint_form', function(event){
	event.preventDefault();

	var uri = $(this).attr('action');

	$.post(uri, $('form#sprint_form').serialize(), function(response){

			if(response.success == true){
				location.reload();

			} else {
				swal('Error', response.error, 'error');
			}
	});
});

$('body').on('click', '#sort_newer', function(event){
  event.preventDefault();

  tinysort.defaults.order = 'desc';
  tinysort('.tasks-container > .task-card',{attr:"data-create"}, {attr:"data-id"});
});

$('body').on('click', '#sort_older', function(event){
  event.preventDefault();

  tinysort.defaults.order = 'asc';
  tinysort('.tasks-container > .task-card',{attr:"data-create"}, {attr:"data-id"});
});

$('body').on('click', '#sprint_status_change', function(event){
  event.preventDefault();

  var sprint_id = $(this).attr('data-id');
  var status_id = $(this).attr('data-status-id');
  var token = $('#token').val();

  if(status_id == 1){
    swal({
      title: "Are you sure?",
      text: "You are going to close the current sprint.\nThis operation can't be undone.\nDo you want to continue?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes",
      closeOnConfirm: false
    },
    function(){

        //In progress, I first need to check if there still are open tasks.
        $.post('/project/check_sprint_open_tasks', {'_token': token, 'sprint_id': sprint_id}, function(response){
          if(response.value == true){
            swal({
              title: "Still open tasks",
              text: "There are still open tasks or subtasks for this sprint.\nIf you continue closing the sprint those tasks will be moved into the backlog.\nDo you want to continue?",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes",
              closeOnConfirm: false
            },
            function(){
              $.post('/project/move_sprint_open_tasks_to_backlog', {'_token': token, 'sprint_id': sprint_id}, function(response){
                $.post('/project/change_sprint_status', {'_token': token, 'sprint_id': sprint_id, 'status_id': status_id}, function(response){
                  if(response.success !== true){
                    swal('Error', response.error, 'error');
                  } else {
                    location.reload();
                  }
                });
              });

            });
          } else {
            $.post('/project/change_sprint_status', {'_token': token, 'sprint_id': sprint_id, 'status_id': status_id}, function(response){
              if(response.success !== true){
                swal('Error', response.error, 'error');
              } else {
                location.reload();
              }
            });
          }

        });

    });

  } else {
    $.post('/project/change_sprint_status', {'_token': token, 'sprint_id': sprint_id, 'status_id': status_id}, function(response){
      if(response.success !== true){
        swal('Error', response.error, 'error');
      } else {
        location.reload();
      }
    });
  }

});

$('body').on('click', '#sprint_delete', function(event){
  event.preventDefault();

  var sprint_id = $(this).attr('data-id');
  var token = $('#token').val();

  $.post('/project/delete_sprint', {'_token': token, 'sprint_id': sprint_id}, function(response){
    if(response.success !== true){
      swal('Error', response.error, 'error');
    } else {
      location.href = response.value;
    }
  });

});

$('body').on('click', '#sprint_edit', function(event){
  event.preventDefault();

  var sprint_id = $(this).attr('data-id');
  var token = $('#token').val();

  $.post('/project/get_sprint', {'_token': token, 'sprint_id': sprint_id}, function(response){
    if(response.success !== true){
      swal('Error', response.error, 'error');
    } else {
      $('div#sprintModal').html(response.value);
      $('div#sprintModal').modal();
    }
  });

});
/*----------------*/

jQuery(window).load(function () {
    var message = $('input#messages').val();
    var message_type = $('input#message_type').val();
    var message_title = $('input#message_title').val();

    if(message != ''){
      swal(message_title, message, message_type);
    }
});
