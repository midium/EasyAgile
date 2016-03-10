$('[data-toggle="tooltip"]').tooltip();

$('#from_date_picker').datetimepicker({
  format: 'YYYY-MM-DD'
}).on("dp.change", function (e) {
    $('#to_date_picker').data("DateTimePicker").minDate(e.date);
});

$('#to_date_picker').datetimepicker({
	useCurrent: false,
  format: 'YYYY-MM-DD'
}).on("dp.change", function (e) {
    $('#from_date_picker').data("DateTimePicker").maxDate(e.date);
});

$('body').on('click', 'i.show-hide-filters', function(event){
  event.preventDefault();

  if($(this).hasClass('picon-chevron-down')) {
    $('.tasks-filters-container').slideDown();
    $(this).removeClass('picon-chevron-down').addClass('picon-chevron-up');

  } else {
    $('.tasks-filters-container').slideUp();
    $(this).removeClass('picon-chevron-up').addClass('picon-chevron-down');

  }
});

$('body').on('submit', 'form#filters_form', function(event){
  event.preventDefault();

  $('.projects-updating').show();

  var action = $(this).attr('action');

  $.post(action, $(this).serialize(), function(response){
    if(response.success == true){
      $('.tasks-container').html(response.value);
      $('.paginator-container').html(response.nav);

    } else {
      swal('Error', response.error, 'error');

    }

    $('.projects-updating').hide();
  });
});

$('body').on('click', '.ajax-paginator a', function(event){
  event.preventDefault();

  var uri = $(this).attr('href');
  var page = uri.split("=")[1];

  $('div.loading').show();

  $.ajax({
    type: 'POST',
    url: '/tasks/filter',
    data: $('#filters_form').serialize() + '&page=' + page,
    success: function(response){
      $('.tasks-container').html(response.value);
      $('.paginator-container').html(response.nav);
    },
    error: function(response){
      swal('Error', response.value, 'error');
    }
  });

});
