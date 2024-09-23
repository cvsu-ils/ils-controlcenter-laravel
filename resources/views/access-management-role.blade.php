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
    .text-light {
        color: #999 !important;
    }
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
            <a href="{{ route('admin.access-management-role') }}" class="nav-link text-success text-bold border-bottom border-success">Policies</a>
            <a href="{{ route('admin.access-management-permission') }}" class="nav-link text-secondary">Permissions</a>

            

        </div>
    </div>
</div>  

<h2 class="mt-4 text-bold">Role List</h2>
<h6 class="mb-3">Test..</h6>

<div class="d-flex justify-content-between align-items-center">
    <button type="button" class="btn btn-outline-light rounded btn-sm text-dark" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus fa-sm" style="margin-right: 2px"></i> Add Role</button>
    <form action="{{ route('admin.access-management-role') }}" method="GET">
                <button type="submit" id="search" name="search" class="btn btn-sm btn-success rounded float-right">Search</button>
                <input class="form-control-sm float-right mr-1 mb-2 bg-light border border-secondary" type="text" name="search" placeholder="Search..." value="{{ $search }}">
    </form>
</div>

    <div>
        <table class="table table-sm w-100 table-striped table-bordered">
            <thead class="thead-successs">
                <tr>
                    <th>Role</th>
                    <th>Permission</th>
                    <th>Action</th>
                </tr>
            </thead>

            <!-- Add hidden div to hold permissions data -->
            <div id="permissionsData" style="display: none;">
              @foreach($roleData as $data)
                <div id="permissions_{{ $data['role']->id }}" data-permissions="{{ json_encode($data['permissions']) }}"></div>
              @endforeach
            </div>
                
            @foreach($roleData as $data)
                <tr>
                    <td>{{ $data['role']->name }}</td>
                    <td><button type="button" class="btn text-primary show-details-btn" data-toggle="modal" data-target="#detailsModal" data-role-id="{{ $data['role']->id }}"> Details >> </button></td>
                    <td>

                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$data['role']->id}}">
                          <i class="fas fa-edit fa-sm" style="margin-right: 3px"></i> Edit 
                        </button> 

                        <form action="{{ route('admin.access-management-destroy-role', $data['role']->id) }}" method="POST" class="delete-role-form" data-role-id="{{ $data['role']->id }}" style="display:inline;">
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
@foreach($roleData as $data)

<div class="modal fade" id="editModal{{$data['role']->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header m-2">
              <h5 class="modal-title" id="exampleModalLabel">Update Permission</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body m-2">
                
                    <form action="{{ route('admin.access-management-edit-role', ['id' => $data['role']->id]) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                          <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text" class="form-control" id="editedName" name="editedName" value="{{$data['role']->name}}" required><br>

                          </div>

                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-warning" id="submitButton" style="width: 40%">Save Changes</button>
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
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <form method="POST" id="createRoleForm">
          @csrf
            <div class="container">
                <label for="name"> Name: </label>
                <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter Role Name..."><br>
                
                <label for="description"> Select Permissions: </label>

                @foreach($permissions as $key => $permission)
                    <div class="custom-control custom-switch mb-2">
                        @if(is_object($permission))
                            <input type="checkbox" class="custom-control-input custom-switch-input" id="customSwitch{{$key}}" name="permissions_id[]" value="{{ $permission['id'] }}">
                            <label class="custom-control-label font-weight-normal" for="customSwitch{{$key}}">
                                <span class="ml-2 permission-name">{{ $permission['name'] }}</span>
                                <span class="ml-2 permission-description">{{ $permission['description'] }}</span>
                            </label>
                        @endif
                    </div>
                @endforeach

                    <input type="hidden" name="guard_name" id="guard_name" value="web">
                    <button type="submit" class="btn btn-warning btn-sm w-100 text-bold rounded mt-2" id="createButton">Save</button>
            </div>
          </form>

          <div id="message"></div>

      </div>
    </div>
  </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Role Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Permissions:</h6>
        <ul id="permissionsList">
          <!-- Permissions will be dynamically added here -->
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



@endsection


@section('script')

<script>

// For text-muted if switch is off
  document.addEventListener("DOMContentLoaded", function() {
    
    var switchElements = document.querySelectorAll(".custom-switch-input");

      switchElements.forEach(function(switchElement) {
        var descriptionElement = switchElement.parentElement.querySelector(".permission-description");
        var nameElement = switchElement.parentElement.querySelector(".permission-name");

        switchElement.addEventListener("change", function() {
          if (this.checked) {
            descriptionElement.classList.remove("text-muted");
            nameElement.classList.remove("text-muted");
          }else {
            descriptionElement.classList.add("text-muted");
            nameElement.classList.add("text-muted");
          }
        });

        if (!switchElement.checked) {
          descriptionElement.classList.add("text-muted");
          nameElement.classList.add("text-muted");
        }
      });
    });

// Saving into the database
$(document).ready(function() {
    $('#createButton').click(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: '{{ route('admin.access-management-store-role') }}',
            data: $('#createRoleForm').serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: response.title,
                    text: response.message,
                });
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
            title: 'Are you sure you want to remove this role?',
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

// JavaScript to handle displaying permissions in the modal

$(document).ready(function() {
    $('.show-details-btn').click(function() {
      var roleId = $(this).data('role-id');
      var permissionsData = $('#permissions_' + roleId).data('permissions');
      console.log(permissionsData); // Output permissions data to console for debugging

      var permissionsList = $('#permissionsList');

      // Clear previous content
      permissionsList.empty();

      // Add permissions to the modal
      permissionsData.forEach(function(permission) {
        var listItem = $('<li>').text(permission.name + '  ' + permission.description);
        permissionsList.append(listItem);
      });
    });
  });

</script>

@endsection