@extends('layouts.default')
@include('includes.navbar')

@section('container')

<!-- Container -->
<div class="content-wrapper">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header text-center">User Login Panel</div>
      <div class="card-body">
        
        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}">
          @csrf
            
          <div class="form-group form-row">
            <label for="email"><b style="color:red;">*</b>Email Address</label>
            @if ($errors->has('email')) { <span style="color:red" class="error">{{ $errors->first('email') }}</span> } @endif
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Enter Email Address" value="{{ old('email') }}" required autofocus>
          </div>

          <div class="form-group" style="text-align:center;">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
          </div>  
        </form>
        <!-- End Of Form -->
        
        <div class="text-center card-footer">
          <a href="{{ route('register') }}">Register Here</a> | 
          <a href="{{ route('login') }}">Login Here</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of container -->
@endsection