$('[data-toggle="tooltip"]').tooltip({
  container: 'body'
});

$('body').on('click', 'a#change_month', function(event){
  event.preventDefault();

  $('.timesheet-updating').show();

  var year = $(this).parent().attr('data-year');
  var month = $(this).parent().attr('data-month');
  var direction = $(this).attr('data-direction');

  var token = $('input#token').val();
  var uid = $('input#uid').val();

  $.post('/timesheet/change_month', {'_token': token, 'uid': uid, 'year': year, 'month': month, 'direction': direction}, function(response){
    if(response.success == false){
      swal('Error', response.error, 'error');

    } else {
      $('#timesheet_content').html(response.value);
      $('#month_navigator').html(response.nav);
      $('#timesheet_export').html(response.export);

    }

    $('.timesheet-updating').hide();
  });

});

$('body').on('click', 'td.day-col', function(event){
  event.preventDefault();

  if(typeof($(this).attr('data-log-id')) != 'undefined'){
    var log_id = $(this).attr('data-log-id');
    var token = $('input#token').val();
    var task_id = $(this).attr('data-task-id');
    var date = $(this).attr('data-date');
    var year = $('div.date-navigator').attr('data-year');
    var month = $('div.date-navigator').attr('data-month');

    $.post('/timesheet/get_log',{'_token': token, 'task_id': task_id, 'log_id': log_id, 'date': date, 'year': year, 'month': month},function(response){
      if(response.success == true){
        $('#modal_container').html(response.value);

        $('#logModal').modal();
      } else {
        swal('Error', response.error, 'error');
      }
    });
  }

});

$('body').on('submit', 'form#timesheet_log_form', function(event){
  event.preventDefault();

  $('.timesheet-updating').show();

  $('#logModal').modal('hide');

  $.post('/timesheet/save_log', $('form#timesheet_log_form').serialize(), function(response){
    if(response.success == true){
      $('#timesheet_content').html(response.value);
      $('#month_navigator').html(response.nav);
      $('#timesheet_export').html(response.export);

    } else {
      swal('Error', response.error, 'error');
    }

    $('.timesheet-updating').hide();
  });
});

/*.header-fixed {
    position: fixed;
    top: 160px;
    //display:none;
}
</style>
<script>
var tableOffset = $(".timesheet-table").offset().top;
var $header = $(".timesheet-table > thead").clone();
var $fixedHeader = $(".header-fixed").append($header);

$(window).bind("scroll", function() {
    var offset = $(this).scrollTop();

    if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
        $fixedHeader.show();
    }
    else if (offset < tableOffset) {
        $fixedHeader.hide();
    }
});*/
