<form action="/timesheet/export" method="post" class="form">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <input type="hidden" name="year" value="{{$year}}" />
  <input type="hidden" name="month" value="{{$month}}" />

  <button type="submit" class="btn btn-default"><i class="picon picon-page-export-csv">&nbsp;</i>Export</button>
</form>
