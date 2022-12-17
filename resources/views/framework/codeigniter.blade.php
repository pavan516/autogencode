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
    <li class="breadcrumb-item active">{{strtoupper($project->project_name)}} ( Click To Generate )</li>
  </ol>
  <!-- End Of BreadCrumb -->

  <!-- Progress -->
  <ol class="progtrckr" data-progtrckr-steps="5">
    <li class="progtrckr-done">Select Features</li>
    <li class="progtrckr-done">Create Database</li>
    <li class="progtrckr-done">Create Tables</li>
    <li class="progtrckr-todo">Generate</li>
  </ol><br>
  <!-- End Of progress -->

  <!-- Default View Before Creating Schema -->
  <div class="flex-container">
    <div class="flex-child flex-child2">
      <a href="/generate/codeigniter/{{$project->uuid}}" class="btn btn-primary button" style="font-size:24px;" >Generate Project</a>
    </div>
  </div>
  <!-- End Of Default View Before Creating Schema -->
    
</div>
<!-- End of Container -->

@endsection