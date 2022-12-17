@extends('layouts.default')
@include('includes.navbar')

@section('container')
<!-- Container -->
<div class="container">
  <div class="card card-register mx-auto mt-5">
    <div class="card-header text-center">User Registration Panel</div>
    <div class="card-body">
              
      <!-- Form -->
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group form-row">
          <div class="col-md-6">
            <label for="name"><b style="color:red;">*</b>Full Name</label>
            @if ($errors->has('name')) { <span style="color:red" class="error">{{ $errors->first('name') }}</span> } @endif
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="Enter Unique Name" value="{{ old('name') }}" required autofocus>
          </div>
          <div class="col-md-6">
            <label for="email"><b style="color:red;">*</b>Email Address</label>
            @if ($errors->has('email')) { <span style="color:red" class="error">{{ $errors->first('email') }}</span> } @endif
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Enter Email Address" value="{{ old('email') }}" required autofocus>
          </div>
        </div>

        <div class="form-group form-row">
          <div class="col-md-6">
            <label for="password"><b style="color:red;">*</b>Password</label>
            @if ($errors->has('password')) { <span style="color:red" class="error">{{ $errors->first('password') }}</span> } @endif
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Enter Password (Atleast 6 Characters)" required>
          </div>
          <div class="col-md-6">
            <label for="password-confirm"><b style="color:red;">*</b>Repeat Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Repeat Password" required>
          </div>
        </div>

        <div class="form-group form-row">
          <div class="col-md-6">
            <label for="mobileno"><b style="color:red;">*</b>Mobile No</label>
            @if ($errors->has('mobileno')) { <span style="color:red" class="error">{{ $errors->first('mobileno') }}</span> } @endif
            <input id="mobileno" type="number" class="form-control{{ $errors->has('mobileno') ? ' is-invalid' : '' }}" name="mobileno" placeholder="Enter MobileNo" value="{{ old('mobileno') }}" required autofocus>
          </div>
          <div class="col-md-6">
            <label for="account_type"><b style="color:red;">*</b>Select Account Type</label>
            <select id="account_type" name="account_type" class="form-control">
              <option value="Basic" selected>Basic</option>
              <!-- <option value="Premium">Premium</option>
              <option value="Ultimate">Ultimate</option> -->
            </select>
          </div>
        </div>
      
        <div class="form-group" style="text-align:center;">
          <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
        </div>

      </form>
      <!-- End Of Form -->

      <div class="text-center card-footer">
        <a href="{{ route('login') }}">Login Here</a> | 
        <a href="{{ route('password.request') }}">Forgot Password?</a>
      </div>
    </div>
  </div>
</div>
<!-- End of container -->
@endsection