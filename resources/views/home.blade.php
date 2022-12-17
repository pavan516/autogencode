@extends('layouts.default')
@include('includes.navbar')

@section('container')

<!-- Container -->
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{route('home')}}">Dashboard</a>
      </li>
    </ol>
    <!-- End Of BreadCrumb -->

    <!-- Create Project   -->
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-black bg-create o-hidden">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fa fa-plus-square"></i>
            </div>
            <div class="mr-5" style="cursor:pointer;color:black;font-size:13px;text-align:center;" data-toggle="modal" data-target="#createProjectModal">
              <i class="fa fa-plus-square" style="font-size:13px;"></i> <b>Create New Project</b>
            </div>
          </div>
          <a class="card-footer text-white bg-secondary clearfix small z-1" href="#" style="" data-toggle="modal" data-target="#createProjectModal">
            <span class="float-left"><b>Free Projects - Unlimited</b></span>
            <span class="float-right">
              <i class="fa fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>
    </div>
    <!-- End Of Create Project   -->

</div>
<!-- End Of Container     -->

<!-- Create Project Modal -->
<div class="modal fade" id="createProjectModal">
  <div class="modal-dialog" role="document" style="max-width:75%!important;">
    <div class="modal-content">

      <!-- Heading -->
      <div class="modal-header">
        <h5 class="modal-title" id="createProjectModal">Create A New Project</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <!-- Heading -->

      <!-- Modal Body -->
      <div class="modal-body">
        <!-- Form -->
        <form method="POST" action="{{ route('projects.create') }}">
            @csrf

            <!-- Project Name -->
            <div class="form-group form-row">
              <div class="col-md-12">
                <label for="name"><b style="color:red;">*</b> Project Name</label>
                @if ($errors->has('project_name')) { <span style="color:red" class="error">{{ $errors->first('project_name') }}</span> } @endif
                <input id="project_name" type="text" class="form-control{{ $errors->has('project_name') ? ' is-invalid' : '' }}" name="project_name" placeholder="Enter Project Name" value="{{ old('project_name') }}" required autofocus>
              </div>
            </div>
            <!-- Project Name -->

            <!-- Project Language & Framework Selection -->
            <div class="form-group form-row">
              <div class="col-md-6">
                <label for="name"><b style="color:red;">*</b> Programming Language</label>
                @if ($errors->has('programming_language')) { <span style="color:red" class="error">{{ $errors->first('programming_language') }}</span> } @endif
                <select id="programming_language" onchange="getFramework(this)" type="text" class="form-control{{ $errors->has('programming_language') ? ' is-invalid' : '' }}" name="programming_language" value="{{ old('programming_language') }}" required autofocus>
                  <option value="PHP" selected>PHP</option>
                  <option value="NODE_JS">NODE JS</option>
                </select>
              </div>
              <div class="col-md-6" id="select_framework">
                <label for="name"><b style="color:red;">*</b> Select Framework</label>
                @if ($errors->has('framework')) { <span style="color:red" class="error">{{ $errors->first('framework') }}</span> } @endif
                <select id="framework" type="text" class="form-control{{ $errors->has('framework') ? ' is-invalid' : '' }}" name="framework" value="{{ old('framework') }}" required autofocus>
                  <option value="CODEIGNITER" selected>CODEIGNITER</option>
                </select>
              </div>
            </div>
            <!-- Project Language & Framework Selection -->

            <!-- Select Local Protocol & Domain-Name & Port-No -->
            <div class="form-group form-row">
              <div class="col-md-4">
                <label for="name"><b style="color:red;">*</b> Select Local Protocol</label>
                @if ($errors->has('local_protocol')) { <span style="color:red" class="error">{{ $errors->first('local_protocol') }}</span> } @endif
                <select id="local_protocol" type="text" class="form-control{{ $errors->has('local_protocol') ? ' is-invalid' : '' }}" name="local_protocol" value="{{ old('local_protocol') }}" required autofocus>
                  <option value="http" selected>Http</option>
                  <option value="https">Https</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="name"><b style="color:red;">*</b> Select Local Domain Name</label>
                @if ($errors->has('local_domain_name')) { <span style="color:red" class="error">{{ $errors->first('local_domain_name') }}</span> } @endif
                <input id="local_domain_name" type="text" class="form-control{{ $errors->has('local_domain_name') ? ' is-invalid' : '' }}" name="local_domain_name" placeholder="localhost" value="{{ old('local_domain_name') }}" required autofocus>
              </div>
              <div class="col-md-4">
                <label for="name"> Select Local Port No</label>
                @if ($errors->has('local_portno')) { <span style="color:red" class="error">{{ $errors->first('local_portno') }}</span> } @endif
                <input id="local_portno" type="text" class="form-control{{ $errors->has('local_portno') ? ' is-invalid' : '' }}" name="local_portno" placeholder="80" value="{{ old('local_portno') }}" autofocus>
              </div>
            </div>
            <!-- Select Local Protocol & Domain-Name & Port-No -->

            <!-- Select Server Protocol & Domain-Name & Port-No -->
            <div class="form-group form-row">
              <div class="col-md-4">
                <label for="name"><b style="color:red;">*</b> Select Server Protocol</label>
                @if ($errors->has('server_protocol')) { <span style="color:red" class="error">{{ $errors->first('server_protocol') }}</span> } @endif
                <select id="server_protocol" type="text" class="form-control{{ $errors->has('server_protocol') ? ' is-invalid' : '' }}" name="server_protocol" value="{{ old('server_protocol') }}" required autofocus>
                  <option value="http" selected>Http</option>
                  <option value="https">Https</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="name"><b style="color:red;">*</b> Select Server Domain Name</label>
                @if ($errors->has('server_domain_name')) { <span style="color:red" class="error">{{ $errors->first('server_domain_name') }}</span> } @endif
                <input id="server_domain_name" type="text" class="form-control{{ $errors->has('server_domain_name') ? ' is-invalid' : '' }}" name="server_domain_name" placeholder="projectname.com" value="{{ old('server_domain_name') }}" required autofocus>
              </div>
              <div class="col-md-4">
                <label for="name"> Select Server Port No</label>
                @if ($errors->has('server_portno')) { <span style="color:red" class="error">{{ $errors->first('server_portno') }}</span> } @endif
                <input id="server_portno" type="text" class="form-control{{ $errors->has('server_portno') ? ' is-invalid' : '' }}" name="server_portno" placeholder="80" value="{{ old('server_portno') }}" autofocus>
              </div>
            </div>
            <!-- Select Server Protocol & Domain-Name & Port-No -->

            <!-- Submit Button -->
            <div class="form-group" style="text-align:center;">
              <button type="submit" class="btn btn-primary btn-block">Create Project</button>
            </div>
            <!-- Submit Button -->

          </form>
          <!-- End Of Form -->
      </div>
      <!-- Modal Body -->

    </div>
  </div>
</div>
<!-- End Of Create Project Modal -->

<!-- Get framework list on selecting language -->
<script>
function getFramework(input_type) {
  /** Get selected value */
  var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
  var selectedValue = input_type.value;

  /** init var */
  var str = '';
  /** Return name text field based on mode */
  if(selectedValue == "NODE_JS") {
    str += '<label for="name"><b style="color:red;">*</b> Select Framework</label>';
    str += '@if ($errors->has("framework")) { <span style="color:red" class="error">{{ $errors->first("framework") }}</span> } @endif';
    str += '<select id="framework" type="text" class="form-control{{ $errors->has("framework") ? " is-invalid" : "" }}" name="framework" value="{{ old("framework") }}" required autofocus>';
    str += '<option value="EXPRESS_JS_MYSQL" selected>EXPRESS JS (MYSQL)</option>';
    str += '</select>';
  } else if(selectedValue == "PHP") {
    str += '<label for="name"><b style="color:red;">*</b> Select Framework</label>';
    str += '@if ($errors->has("framework")) { <span style="color:red" class="error">{{ $errors->first("framework") }}</span> } @endif';
    str += '<select id="framework" type="text" class="form-control{{ $errors->has("framework") ? " is-invalid" : "" }}" name="framework" value="{{ old("framework") }}" required autofocus>';
    str += '<option value="CODEIGNITER" selected>CODEIGNITER</option>';
    str += '</select>';
  }

  /** append */
  document.getElementById('select_framework').innerHTML = str;
}
</script>
<!-- Get framework list on selecting language -->

@endsection