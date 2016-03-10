$('[data-toggle="tooltip"]').tooltip();

$('body').on('click', '.ajax-paginator a', function(event){
  event.preventDefault();

  var uri = $(this).attr('href');
  var page = uri.split("=")[1];
  var token = $('input#token').val();
  var string = $('input#search_string').val();

  $('div.loading').show();

  $.post('/tasks/quick_search', {'_token': token, 'string': string, 'page': page, 'json': true}, function(response){
    if(response.success == true){
      $('.founded-tasks-container').html(response.value);
      $('.paginator-container').html(response.nav);

    } else {
      swal('Error', response.value, 'error');
    }
  });

});
