@extends('layouts.admin')

@section('title')
  Home
@endsection

@section('main-content-header')
<div class="content-header" style="background-image: url('/images/bg-wifi.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a class="badge badge-primary float-sm-left mb-3" href="{{ route('admin.home') }}"><i class="fas fa-arrow-alt-circle-left"></i> <span class="m-1">Back to home</span> </a>
                <br><br><br><br>
                <h1 class="m-0" style="text-shadow: 4px 4px 6px #838383;"><i class="fas fa-user-lock"></i> <span class="ml-2">Access Management</span></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb px-3 elevation-1 bg-white float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Integrated Library System</li>
                    <li class="breadcrumb-item active">Access Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection 

@section('main-content')
<style>
  .nav-link.active {
        color: green !important;
        border-bottom: 2px solid green;
        font-weight: bold;
    }
</style>

<div class="m-3">

<div class="nav">
    <div class="card border-bottom-0 w-100">
        <div class="card-body d-flex justify-content-between align-items-end p-0">
            <a href="{{ route('admin.access-management') }}" class="nav-link text-secondary"> Create </a>
            <a href="{{ route('admin.access-management-user') }}" class="nav-link text-secondary"> User </a>
            <a href="{{ route('admin.access-management-role') }}" class="nav-link text-secondary">Policies</a>
            <a href="{{ route('admin.access-management-permission') }}" class="nav-link text-success text-bold border-bottom border-success">Permissions</a>
        </div>
    </div>
</div>  

<h2 class="mt-4 text-bold">Permission List</h2>
<h6 class="mb-3">Test...</h6>

<div class="d-flex justify-content-between align-items-center">
    <button type="button" class="btn btn-outline-light rounded btn-sm text-dark" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus fa-sm" style="margin-right: 2px"></i> Add Permission</button>
    <form action="{{ route('admin.access-management-permission') }}" method="GET">
                <button type="submit" id="search" name="search" class="btn btn-sm btn-success rounded float-right">Search</button>
                <input class="form-control-sm float-right mr-1 mb-2 bg-light border border-secondary" type="text" name="search" placeholder="Search..." value="{{ $search }}">
    </form>
</div>

    <div>
        <table class="table table-sm w-100 table-striped table-bordered">
            <thead class="thead-successs">
                <tr>
                    <th>Permission</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>

            @foreach($permission as $permissions)
              <tr>
                  <td>{{ $permissions['name'] }}</td>
                  <td>{{ $permissions['description'] }}</td>
                  <td>
                      <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$permissions['id']}}">
                          <i class="fas fa-edit fa-sm" style="margin-right: 3px"></i> Edit
                      </button> 

                      <form action="{{ route('admin.access-management-destroy-permission', $permissions['id']) }}" method="POST" class="delete-role-form" data-role-id="{{ $permissions['id'] }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-role-btn">
                                <i class="fas fa-trash fa-sm" style="margin-right: 3px;"></i> Remove
                            </button>
                      </form>
                  </td>
              </tr>
            @endforeach
            
        </table>
    </div>

</div>

<!-- Edit Modal -->
@foreach($permission as $permissions)
<div class="modal fade" id="editModal{{$permissions['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header m-2">
              <h5 class="modal-title" id="exampleModalLabel">Update Permission</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body m-2">
                
                    <form action="{{ route('admin.access-management-edit-permission', ['id' => $permissions['id']]) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                          <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text" class="form-control" id="editedName" name="editedName" value="{{$permissions['name']}}" required>
                          </div>
                          <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="12" required>{{$permissions['description']}}</textarea><br>
                          </div>
                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary" id="submitButton" style="width: 20%">Save Changes</button>
                          </div>                                                   
                    </form>
                
            </div>

        </div>
    </div>
</div>
@endforeach
                                    

<!-- Create Modal -->

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content w-75">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <form method="POST" id="createPermissionForm">
          @csrf
            <div class="container">
                <label for="name"> Name: </label>
                <input type="text" name="name" id="name" class="form-control w-100 form-control-sm" placeholder="Enter Permission Name...">
                
                <label for="description"> Description: </label>
                <input type="text" name="description" id="description" class="form-control w-100 form-control-sm" placeholder="Enter Description..."><br>
                
                <input type="hidden" name="guard_name" id="guard_name" value="web">

                <button type="submit" class="btn btn-warning btn-sm w-100 text-bold rounded" id="createButton">Save</button>
            </div>
          </form>
          <div id="message"></div>

      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#createButton').click(function(event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.access-management-store-permission') }}',
                data: $('#createPermissionForm').serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                    })
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while submitting the form.',
                    });
                }
            });
        });

            // Delete confirmation using SweetAlert
    $('.delete-role-btn').click(function(event) {
        event.preventDefault();
        var form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure you want to remove this permission?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Continue'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

</script>

@endsection