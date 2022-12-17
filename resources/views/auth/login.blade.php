@extends('layouts.default')
@include('includes.navbar')

@section('container')

<!-- Container -->
<div class="container">
  <div class="card card-login mx-auto mt-5">
    <div class="card-header text-center">User Login Panel</div>
    <div class="card-body">
      
      <!-- Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf
          
        <div class="form-group form-row">
          <label for="email"><b style="color:red;">*</b>Email Address</label>
          @if ($errors->has('email')) { <span style="color:red" class="error">{{ $errors->first('email') }}</span> } @endif
          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Enter Email Address" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group form-row">              
          <label for="password"><b style="color:red;">*</b>Password</label>
          @if ($errors->has('password')) { <span style="color:red" class="error">{{ $errors->first('password') }}</span> } @endif
          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Enter Password (Atleast 6 Characters)" required>
        </div>

        <div class="form-group form-row">     
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
          </div>
        </div>

        <div class="form-group" style="text-align:center;">
          <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
        </div>  
      </form>
      <!-- End Of Form -->
      
      <div class="text-center card-footer">
        <a href="{{ route('register') }}">Register Here</a> | 
        <a href="{{ route('password.request') }}">Forgot Password?</a>
      </div>
    </div>
  </div>
</div>
<!-- End of container -->
@endsection