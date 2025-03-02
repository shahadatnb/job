<x-guest-layout>
    <p class="login-box-msg">Sign in to start your session</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
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
        <a href="{{ route('password.request') }}">I forgot my password</a>
      </p>
      @endif
      {{-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> --}}
<!-- /.login-box -->
</x-guest-layout>
