var scrolled = 0;

$('div.task-overflowed').scroll(function(e){
  scrolled = $(this).scrollTop();

});

  $('[data-toggle="tooltip"]').tooltip();

  $('.selectpicker').selectpicker();

/* LOGS RELATED */
$('body').on('click', 'a#add_log', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_log',{'_token': token, 'task_id': task_id},function(response){
    if(response.success == true){
      $('#modal_container').html(response.value);

      $('#logModal').modal();
    } else {
      swal('Error', response.error, 'error');
    }
  });
});

$('body').on('click', '#edit_log > a', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var log_id = $(this).attr('data-id');

  $.post('/task/get_log',{'_token': token, 'task_id': task_id, 'log_id': log_id},function(response){
    if(response.success == true){
      $('#modal_container').html(response.value);

      $('#logModal').modal();
    } else {
      swal('Error', response.error, 'error');
    }
  });
});

function updateLogAndTimeWidgets(log_widget){
  $('#task_worklogs_container').html(log_widget);

  //Updating the estimates
  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_estimates',{'_token': token, 'task_id': task_id, 'type': 'widgets'},function(response){
    if(response.success == true){
      $('#time_traking').html(response.value);
    } else {
      swal('Error', response.error, 'error');
    }
  });

}

$('body').on('click', '#remove_log > a', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var log_id = $(this).attr('data-id');

  $.post('/task/remove_log',{'_token': token, 'task_id': task_id, 'log_id': log_id},function(response){
    if(response.success == true){
      updateLogAndTimeWidgets(response.value);

    } else {
      swal('Error', response.error, 'error');
    }
  });
});

$('body').on('submit', 'form#task_log_form', function(event){
  event.preventDefault();

  $.post('/task/save_log', $('form#task_log_form').serialize(), function(response){
    if(response.success == true){
      $('#logModal').modal('hide');
      updateLogAndTimeWidgets(response.value);

    } else {
      swal('Error', response.error, 'error');
    }
  });
});
/*--------------*/

/* PEOPLE RELATED*/
$('body').on('click', '#task_people_container a#assign_to_me', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/assign_to_me',{'_token': token, 'task_id': task_id},function(response){
    if(response.success == true){
      $('#task_people_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('click', 'a#edit_people', function(event){
  event.preventDefault();

  $(this).hide();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_people',{'_token': token, 'task_id': task_id, 'type': 'forms'},function(response){
    if(response.success == true){
      $('#task_people_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');
      $('a#edit_people').show();
    }
  });

});

$('body').on('click', '#people_form #cancel', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_people',{'_token': token, 'task_id': task_id, 'type': 'widgets'},function(response){
    if(response.success == true){
      $('#task_people_container').html(response.value);
      $('a#edit_people').show();
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('click', '#people_form #save', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var uri = $('#people_form').attr('action');

  $.post(uri, $('#people_form').serialize(),function(response){
    if(response.success == true){
      $('#task_people_container').html(response.value);
      $('a#edit_people').show();
    } else {
      swal('Error', response.error, 'error');
    }
  });

});
/*----------------------*/

/* DETAILS RELATED */
$('body').on('click', 'a#edit_details', function(event){
  event.preventDefault();

  $(this).hide();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_details',{'_token': token, 'task_id': task_id, 'type': 'forms'},function(response){
    if(response.success == true){
      $('#task_details_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');

      $('a#edit_details').show();
    }
  });

});

$('body').on('click', '#details_form #cancel', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_details',{'_token': token, 'task_id': task_id, 'type': 'widgets'},function(response){
    if(response.success == true){
      $('#task_details_container').html(response.value);
      $('a#edit_details').show();
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('click', '#details_form #save', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var uri = $('#details_form').attr('action');

  $.post('/task/get_task_sprint_status', {'_token': token, 'task_id': task_id}, function(response){
    if(response.success == false) {
      swal('Error', response.error, 'error');

    } else {
      if(response.value == ''){
        //No Sprint
        UpdateDetails(uri);

      } else {
        //Sprint, checking its status
        if(response.value == 3 &&
          (status_id != 3 && status_id != 5 && status_id != 7 &&
           status_id != 8 && status_id != 10 && status_id != 11)){
          swal({
            title: "Closed Sprint",
            text: "You are trying to reopen a task associated to a finished Sprint.\nThis will cause the task to be moved to the backlog.\nDo you want to continue?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            closeOnConfirm: true
          },
          function(){
            $.post('/task/move_task_to_backlog', {'_token': token, 'task_id': task_id}, function(response){
              if(response.success !== true){
                swal('Error', response.error, 'error');
              }

              UpdateDetails(uri);
            });
          });

        } else {
          UpdateDetails(uri);

        }
      }
    }
  });

});

function UpdateDetails(uri){
  $.post(uri, $('#details_form').serialize(),function(response){
    if(response.success == true){
      $('#task_details_container').html(response.value);
      $('a#edit_details').show();
    } else {
      swal('Error', response.error, 'error');
    }
  });
}

function ChangeTaskStatus(token, task_id, status_id){
  $.post('/task/set_status', {'_token': token, 'task_id': task_id, 'status_id': status_id}, function(response){
    if(response.success == true){
      $('#task_details_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');
    }
  });

}

$('body').on('click', 'button#quick_action', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var status_id = $(this).attr('data-action-type');

  $.post('/task/get_task_sprint_status', {'_token': token, 'task_id': task_id}, function(response){
    if(response.success == false) {
      swal('Error', response.error, 'error');

    } else {
      if(response.value == ''){
        //No Sprint
        ChangeTaskStatus(token, task_id, status_id);

      } else {
        //Sprint, checking its status
        if(response.value == 3 &&
          (status_id != 3 && status_id != 5 && status_id != 7 &&
           status_id != 8 && status_id != 10 && status_id != 11)){
          swal({
            title: "Closed Sprint",
            text: "You are trying to reopen a task associated to a finished Sprint.\nThis will cause the task to be moved to the backlog.\nDo you want to continue?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            closeOnConfirm: true
          },
          function(){
            $.post('/task/move_task_to_backlog', {'_token': token, 'task_id': task_id}, function(response){
              if(response.success !== true){
                swal('Error', response.error, 'error');
              }

              ChangeTaskStatus(token, task_id, status_id);
            });
          });

        } else {
          ChangeTaskStatus(token, task_id, status_id);

        }
      }
    }
  });
});
/*----------------------*/

/* ESTIMATES RELATED */
$('body').on('click', 'a#edit_estimates', function(event){
  event.preventDefault();

  $(this).hide();
  $(this).prev().hide();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_estimates',{'_token': token, 'task_id': task_id, 'type': 'forms'},function(response){
    if(response.success == true){
      $('#time_traking').html(response.value);
    } else {
      swal('Error', response.error, 'error');

      $('a#edit_estimates').show();
      $('a#edit_estimates').prev().show();
    }
  });

});

$('body').on('click', '#estimates_form #cancel', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_estimates',{'_token': token, 'task_id': task_id, 'type': 'widgets'},function(response){
    if(response.success == true){
      $('#time_traking').html(response.value);
      $('a#edit_estimates').show();
      $('a#edit_estimates').prev().show();
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('submit', 'form#estimates_form', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var estimates = $('input#estimates').val();

  $.post('/task/set_estimates', {'_token': token, 'task_id': task_id, 'estimates': estimates}, function(response){
    if(response.success == true){
      $('#time_traking').html(response.value);
      $('a#edit_estimates').show();
      $('a#edit_estimates').prev().show();
    } else {
      swal('Error', response.error, 'error');
    }
  });
});
/*-------------------*/

/* DESCRIPTION RELATED */
$('body').on('click', 'a#edit_description', function(event){
  event.preventDefault();

  $(this).hide();
  $(this).prev().hide();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_description',{'_token': token, 'task_id': task_id, 'type': 'forms'},function(response){
    if(response.success == true){
      $('#task_description_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');

      $('a#edit_description').show();
    }
``  });

});

$('body').on('click', '#description_form #cancel', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_description',{'_token': token, 'task_id': task_id, 'type': 'widgets'},function(response){
    if(response.success == true){
      $('#task_description_container').html(response.value);
      $('a#edit_description').show();
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('submit', 'form#description_form', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var description = $('textarea#description').val();

  $.post('/task/set_description', {'_token': token, 'task_id': task_id, 'description': description}, function(response){
    if(response.success == true){
      $('#task_description_container').html(response.value);
      $('a#edit_description').show();
    } else {
      swal('Error', response.error, 'error');
    }
  });
});
/*-------------------*/

/* SUBJECT RELATED */
$('body').on('click', '#edit_subject', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_subject',{'_token': token, 'task_id': task_id},function(response){
    if(response.success == true){
      $('#subject_modal_holder').html(response.value);

      $('#subjectModal').modal();
    } else {
      swal('Error', response.error, 'error');
    }
  });
});

$('body').on('submit', 'form#task_subject_form', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/set_subject',$('form#task_subject_form').serialize(),function(response){
    if(response.success == true){
      $('#subjectModal').modal('hide');

      $('#subject_view > h3').html(response.value + '<a href="#" class="edit-subject" id="edit_subject"><i class="picon picon-pencil"></i></a>');
    } else {
      swal('Error', response.error, 'error');
    }
  });
});
/*-----------------*/

/* ATTACHMENTS RELATED */
$('body').on('click', '#view_mode', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var view_mode = $(this).attr('data-view-mode');

  $.post('/task/get_attachments_view',{'_token': token, 'task_id': task_id, 'view_mode': view_mode},function(response){
    if(response.success == true){
      $('#task_attachments_container').html(response.value);

      $('.'+view_mode).addClass('active');
      if(view_mode == 'view'){
        $('.list').removeClass('active');
      } else {
        $('.view').removeClass('active');
      }

    } else {
      swal('Error', response.error, 'error');
    }
  });
});

$('body').on('click', '#add_attachment', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var view_mode = $(this).attr('data-view-mode');

  $.post('/task/get_attachments_form',{'_token': token, 'task_id': task_id, 'view_mode': view_mode},function(response){
    if(response.success == true){
      $('#task_attachments_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('click', 'a#remove_file', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var view_mode = $(this).attr('data-view-mode');
  var file_id = $(this).attr('data-id');

  $.post('/task/delete_attachment',{'_token': token, 'task_id': task_id, 'view_mode': view_mode, 'file_id': file_id},function(response){
    if(response.success == true){
      $('#task_attachments_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');
    }
  });

})

$('body').on('click', '#attachment_form #cancel', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var view_mode = $('#attachment_form input#view_mode').val();

  $.post('/task/get_attachments_view',{'_token': token, 'task_id': task_id, 'view_mode': view_mode},function(response){
    if(response.success == true){
      $('#task_attachments_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');
    }
  });
});

$('body').on('submit', 'form#attachment_form', function(event){
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
        $('#task_attachments_container').html(response.value);
        $('.view').removeClass('hidden');
        $('.list').removeClass('hidden');
      }
    }
	});

});
/*---------------------*/

/* COMMENTS RELATED */
$('body').on('click', '#add_comment', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_comment',{'_token': token, 'task_id': task_id, 'type': 'forms'},function(response){
    if(response.success == true){
      $('#modal_container').html(response.value);
      $('#commentModal').modal();
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('click', '#quote_comment', function(event){
  event.preventDefault();

  var quote = $(this).parent().parent().find('.comment-body').html();
  var token = $('input#token').val();
  var task_id = $('input#task_id').val();

  $.post('/task/get_comment',{'_token': token, 'task_id': task_id, 'type': 'forms', 'quote': quote},function(response){
    if(response.success == true){
      $('#modal_container').html(response.value);
      $('#commentModal').modal();
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('click', '#edit_comment', function(event){
  event.preventDefault();

  var token = $('input#token').val();
  var task_id = $('input#task_id').val();
  var comment_id = $(this).attr('data-id');

  $.post('/task/get_comment',{'_token': token, 'task_id': task_id, 'type': 'forms', 'comment_id': comment_id},function(response){
    if(response.success == true){
      $('#modal_container').html(response.value);
      $('#commentModal').modal();
    } else {
      swal('Error', response.error, 'error');
    }
  });

});

$('body').on('submit', '#comment_form', function(event){
  event.preventDefault();

  var uri = $(this).attr('action');

  $.post(uri, $('form#comment_form').serialize(), function(response){
    if(response.success == true){
      $('#commentModal').modal('hide');

      $('#task_comments_container').html(response.value);
    } else {
      swal('Error', response.error, 'error');
    }
  });

});
/*------------------*/

/* SUBTASK CONTEXT MENU */
$("html").on("contextmenu",function(e){
  //prevent default context menu for right click
  e.preventDefault();

  if(typeof($(e.target).attr('data-allow')) == 'undefined' || $(e.target).attr('data-allow') != 'context'){
    $(".subtask-menu").hide();
    return false;
  }

  var task_id = getParentDataValue($(e.target), 'task-card', 'data-id');
  var prj_id = getParentDataValue($(e.target), 'task-card', 'data-project-id');

  if(typeof(task_id) == 'undefined' || task_id <= 0)
    return false;

  var menu = $(".subtask-menu");

  //changing the menu link adding the task id reference
  menu.find('.convert').attr('href', '/task/convert_to_normal/'+task_id+'/'+prj_id);

  //hide menu if already shown
  menu.hide();

  //get x and y values of the click event
  var pageX = e.pageX;
  var pageY = e.pageY - 157 + scrolled;

  //position menu div near mouse cliked area
  menu.css({top: pageY , left: pageX});

  var mwidth = menu.width();
  var mheight = menu.height();
  var screenWidth = $(window).width();
  var screenHeight = $(window).height();

  //if window is scrolled
  var scrTop = $(window).scrollTop();

  //if the menu is close to right edge of the window
  if(pageX+mwidth > screenWidth){
  menu.css({left:pageX-mwidth});
  }

  //if the menu is close to bottom edge of the window
  if(pageY+mheight > screenHeight+scrTop){
  menu.css({top:pageY-mheight});
  }

  //finally show the menu
  menu.show();
 });

 $("html").on("click", function(){
   $(".subtask-menu").hide();
 });

 function getParentDataValue(nodeItm, targetParentClass, dataItem){
   if($(nodeItm).attr('class').indexOf( targetParentClass ) != -1 )
     return $(nodeItm).attr(dataItem);
   else
     return getParentDataValue($(nodeItm).parent(), targetParentClass, dataItem);

 }
/*--------------------*/
