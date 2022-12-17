@extends('layouts.default')
@include('includes.navbar')

@section('container')

<!-- Container -->
<div class="container-fluid">
    
  <!-- Breadcrumbs-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
    <a href="/projects">Dashboard / Projects</a>
    </li>
    <li class="breadcrumb-item active">{{strtoupper($project->project_name)}} ( Database Credentials )</li>
  </ol>
  <!-- End Of BreadCrumb -->

  <!-- Progress -->
  <ol class="progtrckr" data-progtrckr-steps="5">
    <li class="progtrckr-done">Select Features</li>
    <li class="progtrckr-todo">Create Database</li>
    <li class="progtrckr-todo">Create Tables</li>
    <li class="progtrckr-todo">Generate</li>
  </ol><br>
  <!-- End Of progress -->

<div class="card card-register mx-auto mt-5">
    <div class="card-header text-center">Database Connectection Credentials</div>
    <div class="card-body">
              
      <!-- Form -->
      <form method="POST" action="{{ route('databases.create') }}">
        @csrf

        <input id="project_uuid" name="project_uuid" style="display:none;" @if(!empty($project->uuid)) value="{{$project->uuid}}" @endif>
        <div class="form-group form-row">
          <div class="col-md-4">
            <label for="Database Connection"><b style="color:red;">*</b>Database Connection</label>
            @if ($errors->has('database_connection')) { <span style="color:red" class="error">{{ $errors->first('database_connection') }}</span> } @endif
            <input id="database_connection" type="text" class="form-control{{ $errors->has('database_connection') ? ' is-invalid' : '' }}" name="database_connection" @if(empty($database->database_connection)) value="mysql" @else value="{{$database->database_connection}}" @endif  style="font-weight:bold;" disabled required>
          </div>                  
          <div class="col-md-4">
            <label for="Database Host"><b style="color:red;">*</b>Database Host</label>
            @if ($errors->has('database_host')) { <span style="color:red" class="error">{{ $errors->first('database_host') }}</span> } @endif
            <input id="database_host" type="text" class="form-control{{ $errors->has('database_host') ? ' is-invalid' : '' }}" name="database_host" @if(empty($database->database_host)) value="127.0.0.1" @else value="{{$database->database_host}}" @endif style="font-weight:bold;" required>
          </div>
          <div class="col-md-4">
            <label for="Database Port"><b style="color:red;">*</b>Database Port No</label>
            @if ($errors->has('database_port')) { <span style="color:red" class="error">{{ $errors->first('database_port') }}</span> } @endif
            <input id="database_port" type="text" class="form-control{{ $errors->has('database_port') ? ' is-invalid' : '' }}" name="database_port" @if(empty($database->database_port)) value="3306" @else value="{{$database->database_port}}" @endif style="font-weight:bold;" required>
          </div>
        </div>

        <div class="form-group form-row">
          <div class="col-md-4">
            <label for="Database Name"><b style="color:red;">*</b>Database Name</label>
            @if ($errors->has('database_name')) { <span style="color:red" class="error">{{ $errors->first('database_name') }}</span> } @endif
            <input id="database_name" type="text" class="form-control{{ $errors->has('database_name') ? ' is-invalid' : '' }}" name="database_name" placeholder="Enter Database Name" @if(!empty($database->database_name)) value="{{$database->database_name}}" @else value="{{ old('database_name') }}" autofocus @endif style="font-weight:bold;" required>
          </div>  
          <div class="col-md-4">
            <label for="Database User name"><b style="color:red;">*</b>Database User name</label>
            @if ($errors->has('database_user_name')) { <span style="color:red" class="error">{{ $errors->first('database_user_name') }}</span> } @endif
            <input id="database_user_name" type="text" class="form-control{{ $errors->has('database_user_name') ? ' is-invalid' : '' }}" name="database_user_name" placeholder="Enter User Name" @if(empty($database->database_user_name)) value="{{ old('database_user_name') }}" autofocus @else value="{{$database->database_user_name}}" @endif style="font-weight:bold;" required>
          </div>
          <div class="col-md-4">
            <label for="database_host"><b style="color:red;">*</b>Database Password</label>
            @if ($errors->has('database_password')) { <span style="color:red" class="error">{{ $errors->first('database_password') }}</span> } @endif
            <input id="database_password" type="password" class="form-control{{ $errors->has('database_password') ? ' is-invalid' : '' }}" name="database_password" placeholder="**********" @if(empty($database->database_password)) value="{{ old('database_password') }}" autofocus @else value="{{$database->database_password}}" @endif style="font-weight:bold;">
          </div>
        </div>
      
        <div class="form-group" style="text-align:center;">
          <a href="/features/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;"><i class="fa fa-arrow-circle-left"></i> Previous</a>
          <input type="submit" class="btn btn-primary" style="background-color:green;color:white;" value="SUBMIT">
          @if(!empty($database))
            <a href="/tables/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;">NEXT <i class="fa fa-arrow-circle-right"></i></a>
          @endif
        </div>

      </form>
      <!-- End Of Form -->

      
    </div>
  </div>

</div>
<!-- End Of Container -->

@endsection