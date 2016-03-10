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

$('body').on('submit', 'form#filters_form', function(event){
  event.preventDefault();

  $('div.projects-updating').show();

  var uri = $(this).attr('action');

  $.post(uri, $('form#filters_form').serialize(), function(response){

      if(response.success == true){
        $('div.projects-container').html(response.value);

      } else {
        swal('Error', response.error, 'error');
      }

      $('div.projects-updating').hide();
  });

});


$('body').on('click', '.ajax-paginator a', function(event){
  event.preventDefault();

  var uri = $(this).attr('href');
  var page = uri.split("=")[1];

  $('div.loading').show();

  $.ajax({
    type: 'POST',
    url: '/projects/filter',
    data: $('#filters_form').serialize() + '&page=' + page,
    success: function(response){
      $('.projects-container').html(response.value);
      $('.paginator-container').html(response.nav);
    },
    error: function(response){
      swal('Error', response.value, 'error');
    }
  });

});
