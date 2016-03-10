@extends('app')

@section('content')
<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />

<div class="timesheet-updating">
  <div class="spinner">
    <div class="spinner-container container1">
      <div class="circle1"></div>
      <div class="circle2"></div>
      <div class="circle3"></div>
      <div class="circle4"></div>
    </div>
    <div class="spinner-container container2">
      <div class="circle1"></div>
      <div class="circle2"></div>
      <div class="circle3"></div>
      <div class="circle4"></div>
    </div>
    <div class="spinner-container container3">
      <div class="circle1"></div>
      <div class="circle2"></div>
      <div class="circle3"></div>
      <div class="circle4"></div>
    </div>
  </div>
</div>

<article class="timesheet-container center-block">
  <div class="spacer">&nbsp;</div>
  <section id="timesheet_content">
    @include('timesheet.table')
  </section>
</article>
@endsection

@section('beforebodyend')
<div id="modal_container"></div>
<script src="{{ asset('/js/timesheet.js') }}"></script>
@endsection
