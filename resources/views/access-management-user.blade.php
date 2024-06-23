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
    .form-control:focus {
        border-color: transparent;
        box-shadow: none;
    }
</style>

<div class="m-3">

<div class="nav">
    <div class="card border-bottom-0 w-100">
        <div class="card-body d-flex justify-content-between align-items-end p-0">
            <a href="{{ route('admin.access-management') }}" class="nav-link text-secondary"> Create </a>
            <a href="{{ route('admin.access-management-user') }}" class="nav-link text-success text-bold border-bottom border-success"> User </a>
            <a href="{{ route('admin.access-management-role') }}" class="nav-link text-secondary" >Policies</a>
            <a href="{{ route('admin.access-management-permission') }}" class="nav-link text-secondary">Permissions</a>

        </div>
    </div>
</div>  

<h2 class="mt-4 text-bold">User List</h2>
<h6 class="mb-3">Test...</h6>

<form action="{{ route('admin.access-management-user') }}" method="GET">
    <button type="submit" id="search" name="search" class="btn btn-sm btn-success rounded float-right">Search</button>
    <input class="form-control-sm float-right mr-1 mb-2 bg-light border border-secondary" type="text" name="search" placeholder="Search..." value="{{ $search }}">
</form>

    <div>
        <table class="table table-sm w-100 table-striped table-bordered">
            <thead class="thead-successs">
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (is_array($user) || is_object($user))
                    @foreach($user as $users)
                        <input type="hidden" id="model_id" name="model_id" value="{{ $users['id'] }}">
                        <tr>
                            <td>
                                <button type="button" class="btn btn-sm mr-2 rounded show-details-modal" data-toggle="modal" data-target="#detailsModal" data-user-id="{{ $users['id'] }}" data-role="{{ $users['is_single_user'] ? 'Single User' : 'User Group' }}">{{ $users['name'] }}</button>
                            </td>
                            <td>
                                <form action="{{ route('admin.access-management-destroy-user', $users['id']) }}" method="POST" class="delete-role-form" data-role-id="{{ $users['id'] }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-role-btn">
                                        <i class="fas fa-trash fa-sm" style="margin-right: 3px;"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No users found</td>
                    </tr>
                @endif
            </tbody>
        </table>


    </div>

</div>

<!-- Modal for User Details -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>Role</h3>
                <!-- Display the role passed as a parameter with correct badge color -->
                <span class="badge" id="roleBadge">{{ $role }}</span>
                <hr>
                <h5>Permissions: </h4>
                <ul id="permissionsList">

                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
