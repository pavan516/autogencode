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
    <li class="breadcrumb-item active">{{strtoupper($project->project_name)}} ( Select Features )</li>
  </ol>
  <!-- End Of BreadCrumb -->

  <!-- Progress -->
  <ol class="progtrckr" data-progtrckr-steps="5">
    <li class="progtrckr-todo">Select Features</li>
    <li class="progtrckr-todo">Create Database</li>
    <li class="progtrckr-todo">Create Tables</li>
    <li class="progtrckr-todo">Generate</li>
  </ol><br>
  <!-- End Of progress -->
      
  <!-- Table -->
  <table class="table-bordered table-striped" width="100%">

    <!-- Headings -->
    <tr>
      <th class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
      <th width="50%;" style="height:100%;text-align:center;background-color:black;color:white;">List Of Features</th>
      <th width="20%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
      <th class="form-control" width="20%;" style="height:100%;text-align:center;background-color:black;color:white;">SELECT</th>
    </tr>
              
    <!-- Form -->
    <form method="POST" action="{{ route('features.create') }}">
    @csrf

      <!-- Default Value Project UUID -->
      <input id="project_uuid" type="text" name="project_uuid" value="{{ $project->uuid }}" style="display:none;">

      <!-- Feature 1 - Create Codeigniter Project -->
      <tr>
        <td style="background-color:white;text-align:center;">1</td>
        <td style="text-align:center;"><b>Create Codeigniter Project</b></td>
        <td style="text-align:center;"><a class="btn btn-primary" data-toggle="modal" data-target="#feature1">View Details</a></td>
        <td>
          <input type="text" id="features[0][code]" name="features[0][code]" value="PROJECT" style="display:none;">
          <select id="features[0][enable]" name="features[0][enable]" class="form-control">
            @if(count($features) > 0)
              @foreach($features as $feature)
                @if($feature->feature_code === "PROJECT")
                  @if($feature->enable === "YES")
                    <option value="YES" selected>YES</option>
                    <option value="NO">NO</option>
                  @else
                    <option value="NO" selected>NO</option>
                    <option value="YES">YES</option>
                  @endif
                @endif
              @endforeach
            @else
              <option value="YES" selected>YES</option>
              <option value="NO">NO</option>
            @endif
          </select>
        </td>
      </tr>

      <!-- Feature 2 - Create Controllers -->
      <tr>
        <td style="background-color:white;text-align:center;">2</td>
        <td style="text-align:center;"><b>Create Controllers</b></td>
        <td style="text-align:center;"><a class="btn btn-primary" data-toggle="modal" data-target="#feature2">View Details</a></td>
        <td>
          <input type="text" id="features[1][code]" name="features[1][code]" value="CONTROLLERS" style="display:none;">
          <select id="features[1][enable]" name="features[1][enable]" class="form-control">
            @if(count($features) > 0)
              @foreach($features as $feature)
                @if($feature->feature_code === "CONTROLLERS")
                  @if($feature->enable === "YES")
                    <option value="YES" selected>YES</option>
                    <option value="NO">NO</option>
                  @else
                    <option value="NO" selected>NO</option>
                    <option value="YES">YES</option>
                  @endif
                @endif
              @endforeach
            @else
              <option value="YES" selected>YES</option>
              <option value="NO">NO</option>
            @endif
          </select>
        </td>
      </tr>

      <!-- Feature 3 - Create Models -->
      <tr>
        <td style="background-color:white;text-align:center;">3</td>
        <td style="text-align:center;"><b>Create Models</b></td>
        <td style="text-align:center;"><a class="btn btn-primary" data-toggle="modal" data-target="#feature3">View Details</a></td>
        <td>
          <input type="text" id="features[2][code]" name="features[2][code]" value="MODELS" style="display:none;">
          <select id="features[2][enable]" name="features[2][enable]" class="form-control">
            @if(count($features) > 0)
              @foreach($features as $feature)
                @if($feature->feature_code === "MODELS")
                  @if($feature->enable === "YES")
                    <option value="YES" selected>YES</option>
                    <option value="NO">NO</option>
                  @else
                    <option value="NO" selected>NO</option>
                    <option value="YES">YES</option>
                  @endif
                @endif
              @endforeach
            @else
              <option value="YES" selected>YES</option>
              <option value="NO">NO</option>
            @endif
          </select>
        </td>
      </tr>

      <!-- Feature 4 - Create Migrations -->
      <tr>
        <td style="background-color:white;text-align:center;">4</td>
        <td style="text-align:center;"><b>Create Migrations</b></td>
        <td style="text-align:center;"><a class="btn btn-primary" data-toggle="modal" data-target="#feature4">View Details</a></td>
        <td>
          <input type="text" id="features[3][code]" name="features[3][code]" value="MIGRATIONS" style="display:none;">
          <select id="features[3][enable]" name="features[3][enable]" class="form-control">
            @if(count($features) > 0)
              @foreach($features as $feature)
                @if($feature->feature_code === "MIGRATIONS")
                  @if($feature->enable === "YES")
                    <option value="YES" selected>YES</option>
                    <option value="NO">NO</option>
                  @else
                    <option value="NO" selected>NO</option>
                    <option value="YES">YES</option>
                  @endif
                @endif
              @endforeach
            @else
              <option value="YES" selected>YES</option>
              <option value="NO">NO</option>
            @endif
          </select>
        </td>
      </tr>

      <!-- Feature 5 - Create Routing -->
      <tr>
        <td style="background-color:white;text-align:center;">5</td>
        <td style="text-align:center;"><b>Create Routing</b></td>
        <td style="text-align:center;"><a class="btn btn-primary" data-toggle="modal" data-target="#feature5">View Details</a></td>
        <td>
          <input type="text" id="features[4][code]" name="features[4][code]" value="ROUTING" style="display:none;">
          <select id="features[4][enable]" name="features[4][enable]" class="form-control">
            @if(count($features) > 0)
              @foreach($features as $feature)
                @if($feature->feature_code === "ROUTING")
                  @if($feature->enable === "YES")
                    <option value="YES" selected>YES</option>
                    <option value="NO">NO</option>
                  @else
                    <option value="NO" selected>NO</option>
                    <option value="YES">YES</option>
                  @endif
                @endif
              @endforeach
            @else
              <option value="YES" selected>YES</option>
              <option value="NO">NO</option>
            @endif
          </select>
        </td>
      </tr>

      <!-- Feature 6 - Authentication -->
      <tr>
        <td style="background-color:white;text-align:center;">6</td>
        <td style="text-align:center;"><b>Authentication</b></td>
        <td style="text-align:center;"><a class="btn btn-primary" data-toggle="modal" data-target="#feature6">View Details</a></td>
        <td>
          <input type="text" id="features[5][code]" name="features[5][code]" value="AUTHENTICATION" style="display:none;">
          <select id="features[5][enable]" name="features[5][enable]" class="form-control">
            @if(count($features) > 0)
              @foreach($features as $feature)
                @if($feature->feature_code === "AUTHENTICATION")
                  @if($feature->enable === "YES")
                    <option value="YES" selected>YES</option>
                    <option value="NO">NO</option>
                  @else
                    <option value="NO" selected>NO</option>
                    <option value="YES">YES</option>
                  @endif
                @endif
              @endforeach
            @else
              <option value="YES" selected>YES</option>
              <option value="NO">NO</option>
            @endif
          </select>
        </td>
      </tr>

      <!-- Feature 7 - Api Document -->
      <tr>
        <td style="background-color:white;text-align:center;">7</td>
        <td style="text-align:center;"><b>Create Api-Document</b></td>
        <td style="text-align:center;"><a class="btn btn-primary" data-toggle="modal" data-target="#feature7">View Details</a></td>
        <td>
          <input type="text" id="features[6][code]" name="features[6][code]" value="APIDOCUMENT" style="display:none;">
          <select id="features[6][enable]" name="features[6][enable]" class="form-control">
            @if(count($features) > 0)
              @foreach($features as $feature)
                @if($feature->feature_code === "APIDOCUMENT")
                  @if($feature->enable === "YES")
                    <option value="YES" selected>YES</option>
                    <option value="NO">NO</option>
                  @else
                    <option value="NO" selected>NO</option>
                    <option value="YES">YES</option>
                  @endif
                @endif
              @endforeach
            @else
              <option value="YES" selected>YES</option>
              <option value="NO">NO</option>
            @endif
          </select>
        </td>
      </tr>

      <!-- Feature 8 - Installation Steps -->
      <tr>
        <td style="background-color:white;text-align:center;">8</td>
        <td style="text-align:center;"><b>Installation Steps</b></td>
        <td style="text-align:center;"><a class="btn btn-primary" data-toggle="modal" data-target="#feature8">View Details</a></td>
        <td>
          <input type="text" id="features[7][code]" name="features[7][code]" value="INSTALLATIONSTEPS" style="display:none;">
          <select id="features[7][enable]" name="features[7][enable]" class="form-control">
            @if(count($features) > 0)
              @foreach($features as $feature)
                @if($feature->feature_code === "INSTALLATIONSTEPS")
                  @if($feature->enable === "YES")
                    <option value="YES" selected>YES</option>
                    <option value="NO">NO</option>
                  @else
                    <option value="NO" selected>NO</option>
                    <option value="YES">YES</option>
                  @endif
                @endif
              @endforeach
            @else
              <option value="YES" selected>YES</option>
              <option value="NO">NO</option>
            @endif
          </select>
        </td>
      </tr>

      <!-- Submit & Next -->
      <tr>
        <td colspan="4" style="text-align:center">
          <a href="/projects" type="button" class="btn btn-primary" style="background-color:#000000;color:white;"><i class="fa fa-arrow-circle-left"></i> Previous</a>
          <input type="submit" class="btn btn-primary" style="background-color:green;color:white;" value="SUBMIT">
          @if(count($features)>0)
            <a href="/databases/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;">NEXT <i class="fa fa-arrow-circle-right"></i></a>
          @endif
        </td>
      </tr>
          
    </form>
    <!-- End Of Form -->

  </table>
  <!-- End Of Table -->
    
</div>
<!-- End of Container -->

<!-- LIST OF MODALS -->

<!-- Feature 1 -->
<div class="modal fade" id="feature1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-header text-center" id="feature1">
          &nbsp&nbsp&nbsp
          List Of Points Included In This Feature
          &nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- List Of Points -->
        <table class="table-bordered table-striped" width="100%">

          <!-- Headings -->
          <tr>
            <th width="20%;" class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
            <th width="80%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
          </tr>

          <!-- Point 1 - Create Project -->
          <tr>
            <td style="background-color:white;text-align:center;">1</td>
            <td><br>Creating project with version - 3.1.10<br><br></td>
          </tr>

          <!-- Point 1 - Changing domain path -->
          <tr>
            <td style="background-color:white;text-align:center;">2</td>
            <td>
              <br>Changing domain path:<br>
              &nbsp&nbsp&nbsp&nbsp Path : application/config/config.php<br>
              &nbsp&nbsp&nbsp&nbsp $config['base_url'] To : http://projectname.com/<br><br>
            </td>
          </tr>

        </table>
        <!-- End Of List Of Points -->

      </div>
    </div>
  </div>
</div>
<!-- End Of Feature 1 -->

<!-- Feature 2 -->
<div class="modal fade" id="feature2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-header text-center" id="feature2">
          &nbsp&nbsp&nbsp
          List Of Points Included In This Feature
          &nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- List Of Points -->
        <table class="table-bordered table-striped" width="100%">

          <!-- Headings -->
          <tr>
            <th width="20%;" class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
            <th width="80%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
          </tr>

          <!-- Main point -->
          <tr>
            <td colspan="2" style="text-align:center;">
              <br>Each table will have its respective controller file & each controller file consists of 5 crud operations.<br><br>
            </td>
          </tr>

          <!-- Point 1 - Get Method -->
          <tr>
            <td style="background-color:white;text-align:center;">1</td>
            <td>
              <br>Get method ( To fetch records ) with pagination<br><br>
            </td>
          </tr>

          <!-- Point 2 - Post Method -->
          <tr>
            <td style="background-color:white;text-align:center;">2</td>
            <td>
              <br>Post method ( To create a new record ) with validation<br><br>
            </td>
          </tr>

          <!-- Point 3 - Put method -->
          <tr>
            <td style="background-color:white;text-align:center;">3</td>
            <td>
              <br>Put method ( To update a existing record ) with validation<br><br>
            </td>
          </tr>

          <!-- Point 4 - Delete method -->
          <tr>
            <td style="background-color:white;text-align:center;">4</td>
            <td>
              <br>Delete method ( To delete a existing record )<br><br>
            </td>
          </tr>

          <!-- Point 5 - Get Method -->
          <tr>
            <td style="background-color:white;text-align:center;">5</td>
            <td>
              <br>Get method ( To search / filter the records )<br><br>
            </td>
          </tr>

        </table>
        <!-- End Of List Of Points -->

      </div>
    </div>
  </div>
</div>
<!-- End Of Feature 2 -->

<!-- Feature 3 -->
<div class="modal fade" id="feature3">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-header text-center" id="feature3">
          &nbsp&nbsp&nbsp
          List Of Points Included In This Feature
          &nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- List Of Points -->
        <table class="table-bordered table-striped" width="100%">

          <!-- Headings -->
          <tr>
            <th width="20%;" class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
            <th width="80%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
          </tr>

          <!-- Point 6 - Library Model -->
          <tr>
            <td style="background-color:white;text-align:center;">*</td>
            <td>
              <br>By default there will be a library model to write our custom methods.<br><br>
            </td>
          </tr>

          <!-- Main point -->
          <tr>
            <td colspan="2" style="text-align:center;">
              <br>Each controller will have its respective model file & Same as controller, model also consists of 5 crud operations.<br><br>
            </td>
          </tr>

          <!-- Point 1 - Fetch Method -->
          <tr>
            <td style="background-color:white;text-align:center;">1</td>
            <td>
              <br>fetch method ( To fetch records ) with pagination<br><br>
            </td>
          </tr>

          <!-- Point 2 - Create Method -->
          <tr>
            <td style="background-color:white;text-align:center;">2</td>
            <td>
              <br>create method ( To create a new record ) with validation<br><br>
            </td>
          </tr>

          <!-- Point 3 - Update method -->
          <tr>
            <td style="background-color:white;text-align:center;">3</td>
            <td>
              <br>update method ( To update a existing record ) with validation<br><br>
            </td>
          </tr>

          <!-- Point 4 - Delete method -->
          <tr>
            <td style="background-color:white;text-align:center;">4</td>
            <td>
              <br>delete method ( To delete a existing record )<br><br>
            </td>
          </tr>

          <!-- Point 5 - Search Method -->
          <tr>
            <td style="background-color:white;text-align:center;">5</td>
            <td>
              <br>search method ( To search / filter the records )<br><br>
            </td>
          </tr>

        </table>
        <!-- End Of List Of Points -->

      </div>
    </div>
  </div>
</div>
<!-- End Of Feature 3 -->

<!-- Feature 4 -->
<div class="modal fade" id="feature4">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-header text-center" id="feature4">
          &nbsp&nbsp&nbsp
          List Of Points Included In This Feature
          &nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- List Of Points -->
        <table class="table-bordered table-striped" width="100%">

          <!-- Headings -->
          <tr>
            <th width="20%;" class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
            <th width="80%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
          </tr>

          <!-- Point 1 - Database setup -->
          <tr>
            <td style="background-color:white;text-align:center;">1</td>
            <td>
              <br>Changing database credentials in database.php file<br><br>
            </td>
          </tr>

          <!-- Point 2 - Migration support -->
          <tr>
            <td style="background-color:white;text-align:center;">2</td>
            <td>
              <br>Changing migration.php file under config folder. (To support migrations in codeigniter)<br><br>
            </td>
          </tr>

          <!-- Point 3 - Create migrations -->
          <tr>
            <td style="background-color:white;text-align:center;">3</td>
            <td>
              <br>Create migrations for each table.<br><br>
            </td>
          </tr>

          <!-- Point 5 - Migration Endpoint -->
          <tr>
            <td style="background-color:white;text-align:center;">4</td>
            <td>
              <br>Create a migration file to create tables in database & route endpoint to execute.<br><br>
            </td>
          </tr>

        </table>
        <!-- End Of List Of Points -->

      </div>
    </div>
  </div>
</div>
<!-- End Of Feature 4 -->

<!-- Feature 5 -->
<div class="modal fade" id="feature5">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-header text-center" id="feature5">
          &nbsp&nbsp&nbsp
          List Of Points Included In This Feature
          &nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- List Of Points -->
        <table class="table-bordered table-striped" width="100%">

          <!-- Headings -->
          <tr>
            <th width="20%;" class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
            <th width="80%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
          </tr>

          <!-- Point 1 - routes -->
          <tr>
            <td style="background-color:white;text-align:center;">1</td>
            <td>
              <br>Create routes for each endpoint in a project<br><br>
            </td>
          </tr>

        </table>
        <!-- End Of List Of Points -->

      </div>
    </div>
  </div>
</div>
<!-- End Of Feature 5 -->

<!-- Feature 6 -->
<div class="modal fade" id="feature6">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-header text-center" id="feature6">
          &nbsp&nbsp&nbsp
          List Of Points Included In This Feature
          &nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- List Of Points -->
        <table class="table-bordered table-striped" width="100%">

          <!-- Headings -->
          <tr>
            <th width="20%;" class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
            <th width="80%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
          </tr>
      
          <!-- Point 1 - Auth methods -->
          <tr>
            <td style="background-color:white;text-align:center;">1</td>
            <td>
              <br>Signin - (with email & password)<br>Login - (with mobileno & password)<br>change-password<br>forgot-password<br><br>
            </td>
          </tr>

          <!-- Point 2 - session -->
          <tr>
            <td style="background-color:white;text-align:center;">2</td>
            <td>
              <br>Session Implementation<br><br>
            </td>
          </tr>

          <!-- Point 3 - jwt token -->
          <tr>
            <td style="background-color:white;text-align:center;">3</td>
            <td>
              <br>jwt-token (verification with each request)<br><br>
            </td>
          </tr>

        </table>
        <!-- End Of List Of Points -->

      </div>
    </div>
  </div>
</div>
<!-- End Of Feature 6 -->


<!-- Feature 7 -->
<div class="modal fade" id="feature7">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-header text-center" id="feature7">
          &nbsp&nbsp&nbsp
          List Of Points Included In This Feature
          &nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- List Of Points -->
        <table class="table-bordered table-striped" width="100%">

          <!-- Headings -->
          <tr>
            <th width="20%;" class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
            <th width="80%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
          </tr>

          <!-- Point 1 - Create api document -->
          <tr>
            <td style="background-color:white;text-align:center;">1</td>
            <td>
              <br>Create api document for a project<br><br>
            </td>
          </tr>

        </table>
        <!-- End Of List Of Points -->

      </div>
    </div>
  </div>
</div>
<!-- End Of Feature 7 -->

<!-- Feature 8 -->
<div class="modal fade" id="feature8">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-header text-center" id="feature8">
          &nbsp&nbsp&nbsp
          List Of Points Included In This Feature
          &nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- List Of Points -->
        <table class="table-bordered table-striped" width="100%">

          <!-- Headings -->
          <tr>
            <th width="20%;" class="form-control" width="10%;" style="height:100%;text-align:center;background-color:black;color:white;">INDEX</th>
            <th width="80%;" style="height:100%;text-align:center;background-color:black;color:white;">Description</th>
          </tr>

          <!-- Point 1 - Local  -->
          <tr>
            <td style="background-color:white;text-align:center;">1</td>
            <td>
              <br>Local environment setup - Installation steps<br><br>
            </td>
          </tr>

          <!-- Point 2 - Server  -->
          <tr>
            <td style="background-color:white;text-align:center;">2</td>
            <td>
              <br>Server environment setup - Installation steps<br><br>
            </td>
          </tr>

        </table>
        <!-- End Of List Of Points -->

      </div>
    </div>
  </div>
</div>
<!-- End Of Feature 8 -->

@endsection

<!--

Authentication

1. 
2. 

Create api document

1. Create all api end points.
