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
    <li class="breadcrumb-item active">Projects</li>
  </ol>
  <!-- End Of BreadCrumb -->
    
  <!-- List Of Projects -->
  <div class="row">

    <!-- Created Projects -->
    @if(count($projects) > 0)
      @foreach($projects as $project)
      <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-black o-hidden">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fa fa-clock-o"></i>
            </div>
            <div class="mr-5" style="font-size:13px;text-align:center;"><b>{{$project->project_name}}</b></div>
          </div>
          <a class="card-footer text-white bg-primary clearfix small z-1" href="/features/{{$project->uuid}}">
            <span class="float-left"><b>View Project</b></span>
            <span class="float-right">
              <b><i class="fa fa-angle-right"></i></b>
            </span>
          </a>
          <a class="card-footer text-white bg-primary clearfix small z-1" style="cursor:pointer;" data-toggle="modal" data-target="#{{$project->uuid}}">
            <span class="float-left"><b>Delete Project</b></span>
            <span class="float-right">
              <b><i class="fa fa-angle-right"></i></b>
            </span>
          </a>
          <!-- Delete Project Modal -->
          <div class="modal fade" id="{{$project->uuid}}" tabindex="-1">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="{{$project->uuid}}">Do You Want To Delete Project?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">Deleting Project Will Delete all Your Data!</div>
                <div class="modal-footer">
                  
                  {!! Form::open(['action' => ['ProjectsController@destroy', $project->uuid], 'method' => 'POST', 'class' => 'pull right']) !!} 
                      {{Form::hidden('_method','DELETE')}} 
                      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                      {{Form::submit('Delete', ['class' => 'btn btn-danger'])}} 
                  {!!Form::close() !!}
                </div>
              </div>
            </div>
          </div>
          <!-- End Of Delete Project Modal -->
        </div>
      </div>
      @endforeach
    @endif
    <!-- End Of Created Projects -->

  </div>    
  <!-- End Of List Of Projects -->

</div>
<!-- End Of Container -->

@endsection