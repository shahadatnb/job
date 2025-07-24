<x-guest-layout>
  <div id="errorMsg"></div>
    <p class="login-box-msg">Sign in to start your session</p>
    <form method="POST" action="{{ route('student.login') }}">
        @csrf
        @if (isset(request()->redirect))
            <input type="hidden" name="redirect" value="{{ request()->redirect }}">
        @endif
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email or Phone">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        <div class="input-group mb-3">
            <input type="password" class="form-control" name="password"
            required autocomplete="current-password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
    {{-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> --}}
      <!-- /.social-auth-links -->
      @if (Route::has('password.request'))
      <p class="mb-1">
        {{-- <a href="{{ route('password.request') }}">I forgot my password</a> --}}
        <a href="#" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#forgetPasswordModal" >I forgot my password</a>
      </p>
      @endif
      <p class="mb-0">
        <a href="{{ route('student.register') }}" class="text-center btn btn-sm btn-info">Register a new applicant</a>
      </p>
<!-- /.login-box -->
</x-guest-layout>
{{-- <link href="{{asset('/assets/frontend')}}/css/bootstrap.min.css" rel="stylesheet"> --}}
<script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="modal fade" id="forgetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgetPasswordModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="forgetPasswordModalLabel">Forget Password</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
						<div id="errorMsgBasic"></div>
						<form action="{{route('student.password.reset.phone')}}" id="passwordResetForm" method="post">
								@csrf
								<div class="input-group">
										{{-- <label for="phone_number">Phone</label> --}}
										<input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-primary" id="send_otp">Send Otp</button>
                    </div>                    
								</div>
								<div id="set_password" style="display: none">
                  <div class="form-group">
                      <label for="otp">Otp</label>
                      <input type="number" name="otp" id="otp" class="form-control">
                  </div>
                  <div class="form-group">
                      <label for="new_password">New Password</label>
                      <input type="password" name="password" id="new_password" class="form-control">
                  </div>
                  <div class="form-group">
                      <label for="password_confirmation">Confirm Password</label>
                      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                  </div>

                  <button type="submit" class="btn btn-primary">Set Password</button>
                </div>
						</form>
				</div>
			</div>
		</div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
$(document).ready(function() {
  $('#send_otp').click(function() {
      $.LoadingOverlay("show");
      $("#errorMsgBasic").html('');
      let phone = $('#phone_number').val();
      $.ajax({
          url: "{{route('student.password.reset.phone')}}",
          method: "POST",
          data: {
              phone: phone,
              _token: "{{ csrf_token() }}"
          },
          success: function(response) {
            //console.log(response);
              if (response.status == true) {
                  //$('#set_password').removeClass('d-none');
                  $("#set_password").css({ 'display': 'block' });
                  $("#errorMsgBasic").append(`<div class="alert alert-success"><strong>Success: </strong>${response.message}</div>`);
              }else{
                  if(response.message){
										$("#errorMsgBasic").append(`<div class="alert alert-danger"><strong>Warning: </strong>${response.message}</div>`);
                  }
                  if(response.errors){
                    response.errors.forEach(function(element){
                      $("#errorMsgBasic").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
                    });                    
                  }
              }
          }
      });
      $.LoadingOverlay("hide");
  });

  $("#passwordResetForm").submit(function(e) {
      e.preventDefault();
      $.LoadingOverlay("show");
      $("#errorMsgBasic").html('');
      $.ajax({
          url: "{{route('student.password.store.phone')}}",
          method: "POST",
          data: $(this).serialize(),
          success: function(response) {
              if (response.status == true) {
                  //$('#set_password').removeClass('d-none');
                  $("#errorMsg").append(`<div class="alert alert-success"><strong>Success: </strong>${response.message}</div>`);
                  $("#set_password").css({ 'display': 'none' });
                  $('#forgetPasswordModal').modal('hide');
              }else{
                  if(response.message){
                    $("#errorMsgBasic").append(`<div class="alert alert-danger"><strong>Warning: </strong>${response.message}</div>`);
                  }
                  if(response.errors){
                    response.errors.forEach(function(element){
                      $("#errorMsgBasic").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
                    });
                  }
              }
          }
      });
      $.LoadingOverlay("hide");
  });
  
});
</script>