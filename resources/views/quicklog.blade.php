@extends('layouts.admin')

@section('title')
  Home
@endsection

@section('main-content-header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Test Quicklog</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.form') }}">Back</a></li>
              <li class="breadcrumb-item active">Violation Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

@endsection 

@section('main-content')
<form action="/quicklog" method="POST" >
        @csrf
        <br>
        <center>
        <input type="text" 
            class = "form-control form-control-lg" 
            name="card_number" 
            id="card_number" 
            placeholder="Enter your student number here..."
            style=" width: 70%;"
        >
        <br>
        <input type="button" value="Enter" id="btn_enter" >
        
        </center>
        
    </form>
    

@endsection