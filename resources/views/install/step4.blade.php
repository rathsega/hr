@extends('install.index')
   
@section('content')
<?php if(isset($error)) { ?>
  <div class="row justify-content-center ins-seven">
    <div class="col-md-8 col-md-offset-2">
      <div class="alert alert-danger">
        <strong>{{ $error }}</strong>
      </div>
    </div>
  </div>
<?php } ?>
<div class="row justify-content-center ins-two">
  <div class="col-md-6 col-md-offset-2">
    <div class="card">
      <div class="card-body">
        <div class="panel panel-default ins-three" data-collapsed="0">
          <!-- panel body -->
          <div class="panel-body ins-four">
            <p class="ins-four">
              <strong>{{ __('Your database is successfully connected') }}</strong>. {{ __('All you need to do now is') }}
              <strong>{{ __("hit the 'Install' button") }}</strong>.
              {{ __('The auto installer will run a sql file, will do all the tiresome works and set up your application automatically.') }}
            </p>
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="button" id="install_button" class="btn btn-primary">
                    <i class="fi-br-shield-check"></i> &nbsp; {{ __('Confirm Import') }}
                </button>
                <small id="loader" class="ins-seven text-muted">
                  &nbsp; {{ __('Importing database....') }}
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  "use strict";

  $(document).ready(function() {
    $('#loader').hide();
    $('#install_button').on('click', function() {
      $('#loader').fadeIn();
      setTimeout(
      function()
      {
        window.location.href = "{{ route('install.confirm.import') }}";
      }, 5000);
    });
  });
</script>
@endsection