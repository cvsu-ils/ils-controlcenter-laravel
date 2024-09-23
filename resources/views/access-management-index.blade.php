\@extends('layouts.admin')

@section('title')
  Home
@endsection`

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
    .step { 
        display: none; 
    }
    .step.active { 
        display: block; 
    }
    .tag {
        margin-right: 5px;
        color: black;
        background-color: lightgray;
        padding: 3px;
        border-radius: 3px;
        display: inline-block;
    }
    .tag i {
        margin-left: 5px;
        margin-right: 5px;
        cursor: pointer;
    }


</style>

<div class="m-3">

<div class="nav">
    <div class="card border-bottom-0 w-100">
        <div class="card-body d-flex justify-content-between align-items-end p-0">
            <a href="{{ route('admin.access-management') }}" class="nav-link text-success text-bold border-bottom border-success" id="create-link"> Create </a>
            <a href="{{ route('admin.access-management-user') }}" class="nav-link text-secondary">User</a>
            <a href="{{ route('admin.access-management-role') }}" class="nav-link text-secondary">Policies</a>
            <a href="{{ route('admin.access-management-permission') }}" class="nav-link text-secondary">Permissions</a>
        </div>
    </div>
</div>    

    <div id="form-errors" style="color: red; display: none;"></div>
    <div id="form-success" style="color: green; display: none;"></div>


    <div class="card">
    <div class="card-body">

    <form id="createUser" method="POST">
        @csrf      

        <div class="step">

        <h2 class="mt-4 text-bold">Step 1</h2>
        <h6 class="mb-3">User Information</h6>

            <label>Name </label> <br>
            <input type="text" class="form-control w-100 p-3" name="name" id="name" placeholder="Enter Name" required><br>

            <label>Email:</label><br>
            <input type="email" class="form-control w-100 p-3" name="email" id="email" placeholder="Enter Email" required><br>

            <center>
                <button type="reset" class="btn btn-secondary btn-sm text-bold rounded">Clear</button>
                <button type="button" class="btn btn-warning btn-sm text-bold rounded" onclick="showStep(1)">Next</button>
            </center>
        </div>

        <div class="step" id="step2">
            <h2 class="mt-4 text-bold">Step 2</h2>
            <h6 class="mb-3">Select Policies or Permissions</h6>
            <!-- POLICIES AREA -->
            <h4 class="mb-4">Policies</h4>

            <button type="button" class="btn btn-secondary p-1 mb-2" data-toggle="modal" data-target="#addPoliciesModal">
                + Add Policies
            </button>

            <div class="tags-container" id="policiesTagsContainer">
                <!-- Tags for policies will be dynamically added here -->
            </div>

            <input type="hidden" class="tagsInput" name="tags" value="">
            

            <!-- Add Policies Modal -->
            <div class="modal fade" id="addPoliciesModal" tabindex="-1" role="dialog" aria-labelledby="userGroupModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-bold" id="userGroupModalLabel">Select Policies: </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="rolesList">
                                <!-- Roles will be dynamically added here -->
                                @foreach($roles as $key => $role)
                                    <div class="custom-control custom-checkbox mb-2 font-weight-normal">
                                        <input type="checkbox" class="custom-control-input" id="customCheckboxRole{{$key}}" name="role_id[]" value="{{$role['id']}}">
                                        <label class="custom-control-label" for="customCheckboxRole{{$key}}">{{$role['name']}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm text-bold rounded back-btn" data-dismiss="modal">Back</button>
                            <button type="button" class="btn btn-warning btn-sm text-bold rounded" id="saveRoleBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden input to store selected roles -->
            <input type="hidden" id="selectedRoles" name="roles" value="">

            <hr>


            <!-- PERMISSION AREA -->
            <h4 class="mb-4">Permissions</h4>

            <button type="button" class="btn btn-secondary p-1 mb-2" data-toggle="modal" data-target="#addPermissionModal">
                + Add Permission
            </button>

            <div class="tags-container" id="permissionsTagsContainer">
                <!-- Tags for permissions will be dynamically added here -->
            </div>

            <input type="hidden" class="tagsInput" name="tags" value="">
            <hr>

            <!-- Add Permissions Modal -->
            <div class="modal fade" id="addPermissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-bold" id="permissionModalLabel">Select Permissions:</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="permissionsList">
                                <!-- Permissions will be dynamically added here -->
                                @foreach($permissions as $key => $permission)
                                    <div class="custom-control custom-checkbox mb-2 font-weight-normal">
                                        <input type="checkbox" class="custom-control-input" id="customCheckboxPermission{{$key}}" name="permission_id[]" value="{{$permission['id']}}">
                                        <label class="custom-control-label" for="customCheckboxPermission{{$key}}">{{$permission['name']}}</label>
                                        <label>{{$permission['description']}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm text-bold rounded back-btn" data-dismiss="modal">Back</button>
                            <button type="button" class="btn btn-warning btn-sm text-bold rounded" id="savePermissionBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden input to store selected permissions -->
            <input type="hidden" id="selectedPermissions" name="permissions" value="">

            <!-- Continue button -->

            <center>
                <button type="button" class="btn btn-secondary btn-sm text-bold rounded" onclick="showStep(0)">Back</button>
                <button type="button" class="btn btn-warning btn-sm text-bold rounded" onclick="showStep(2)">Next</button>
            </center>
        </div>

        <div class="step" id="step3">
            <h2 class="mt-4 text-bold">Step 3</h2>
            <h6 class="mb-3">Review Details</h6>
            <p><strong>Name:</strong> <span id="review-name"></span></p>
            <p><strong>Email:</strong> <span id="review-email"></span></p>
            <h4 id="policies-header" style="display: none;"><strong>Policies:</strong></h4>
            <div id="review-policies"></div>
            <h4 id="permissions-header" style="display: none;"><strong>Permissions:</strong></h4>
            <div id="review-permissions"></div>
            <div class="float-right">
                <button type="button" class="btn btn-secondary btn-md text-bold rounded" onclick="showStep(1)">Back</button>
                <button type="submit" class="btn btn-success btn-md text-bold rounded">Create</button>
            </div>
        </div>


    </form>


    </div>
    </div>
</div>


@endsection

@section('script')

<script>

$(document).ready(function() {
    $('#createUser').on('submit', function(event) {
        event.preventDefault();

        var email = $('#email').val();
        var name = $('#name').val();
        var selectedRoles = $('#selectedRoles').val();
        var selectedPermissions = $('#selectedPermissions').val();

        if (!email.endsWith('@cvsu.edu.ph')) {
            Swal.fire({
                title: "Input Error",
                text: "Email must belong to CVSU domain (cvsu.edu.ph).",
                icon: "error"
            });
            return;
        }

        $.ajax({
            url: '{{ route("admin.access-management-store") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: name,
                email: email,
                roles: selectedRoles,
                permissions: selectedPermissions
            },
            dataType: 'json',
            beforeSend: function() {
                $('button[type="submit"]').attr('disabled', 'disabled');
            },
            success: function(data) {
                $('button[type="submit"]').removeAttr('disabled');
                if (data.errors) {
                    let errorHtml = '<ul>';
                    $.each(data.errors, function(key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#form-errors').html(errorHtml).show();
                } else {
                    $('#form-errors').hide();
                    $('#form-success').text(data.success).show();
                }
            }
        });
    });
});


function showStep(step) {
    const steps = document.querySelectorAll('.step');
    steps.forEach((stepElement, index) => {
        stepElement.classList.toggle('active', index === step);
    });

    // Update the review step with user input
    if (step === 2) {
        document.getElementById('review-name').innerText = document.getElementById('name').value;
        document.getElementById('review-email').innerText = document.getElementById('email').value;

        // Populate the review-policies element
        const selectedRoles = $('#selectedRoles').val().split(',').filter(roleId => roleId);
        const selectedRoleNames = selectedRoles.map(roleId => $(`#policy-tag-${roleId}`).text().trim());
        const reviewPoliciesElement = document.getElementById('review-policies');
        if (selectedRoleNames.length > 0) {
            reviewPoliciesElement.innerHTML = `<ul><li>${selectedRoleNames.join('</li><li>')}</li></ul>`;
            reviewPoliciesElement.previousElementSibling.style.display = 'block'; // Show the header
        } else {
            reviewPoliciesElement.innerHTML = '';
            reviewPoliciesElement.previousElementSibling.style.display = 'none'; // Hide the header
        }

        // Populate the review-permissions element
        const selectedPermissions = $('#selectedPermissions').val().split(',').filter(permissionId => permissionId);
        const selectedPermissionNames = selectedPermissions.map(permissionId => $(`#permission-tag-${permissionId}`).text().trim());
        const reviewPermissionsElement = document.getElementById('review-permissions');
        if (selectedPermissionNames.length > 0) {
            reviewPermissionsElement.innerHTML = `<ul><li>${selectedPermissionNames.join('</li><li>')}</li></ul>`;
            reviewPermissionsElement.previousElementSibling.style.display = 'block'; // Show the header
        } else {
            reviewPermissionsElement.innerHTML = '';
            reviewPermissionsElement.previousElementSibling.style.display = 'none'; // Hide the header
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    showStep(0); // Show the first step initially

    // Handle click event on Save button in roles modal
    $('#saveRoleBtn').click(function() {
        var selectedRoles = [];
        $('#addPoliciesModal input[name="role_id[]"]:checked').each(function() {
            var roleId = $(this).val();
            var roleName = $(this).siblings('label').text().trim();
            selectedRoles.push({ id: roleId, name: roleName });
        });

        if (selectedRoles.length > 0) {
            addRoleTags(selectedRoles);
            $('#addPoliciesModal').modal('hide');
        }
    });

    // Handle click event on Save button in permissions modal
    $('#savePermissionBtn').click(function() {
        var selectedPermissions = [];
        $('#addPermissionModal input[name="permission_id[]"]:checked').each(function() {
            var permissionId = $(this).val();
            var permissionName = $(this).siblings('label').text().trim();
            selectedPermissions.push({ id: permissionId, name: permissionName });
        });

        if (selectedPermissions.length > 0) {
            addPermissionTags(selectedPermissions);
            $('#addPermissionModal').modal('hide');
        }
    });

    // Function to add role tags
    function addRoleTags(roles) {
        roles.forEach(function(role) {
            if ($('#policy-tag-' + role.id).length === 0) {
                var tag = $('<span>', {
                    class: 'tag',
                    id: 'policy-tag-' + role.id,
                    text: role.name
                });

                var removeIcon = $('<i>', {
                    class: 'fas fa-times ml-2',
                    style: 'cursor: pointer;'
                }).click(function() {
                    $(this).parent().remove();
                    removeSelectedRole(role.id);
                });

                tag.append(removeIcon);
                $('#policiesTagsContainer').append(tag);
                addSelectedRole(role.id);
            }
        });
    }

    // Function to add permission tags
    function addPermissionTags(permissions) {
        permissions.forEach(function(permission) {
            if ($('#permission-tag-' + permission.id).length === 0) {
                var tag = $('<span>', {
                    class: 'tag',
                    id: 'permission-tag-' + permission.id,
                    text: permission.name
                });

                var removeIcon = $('<i>', {
                    class: 'fas fa-times ml-2',
                    style: 'cursor: pointer;'
                }).click(function() {
                    $(this).parent().remove();
                    removeSelectedPermission(permission.id);
                });

                tag.append(removeIcon);
                $('#permissionsTagsContainer').append(tag);
                addSelectedPermission(permission.id);
            }
        });
    }

    // Function to add selected role to hidden input
    function addSelectedRole(roleId) {
        var selectedRoles = $('#selectedRoles').val().split(',');
        if (!selectedRoles.includes(roleId.toString())) {
            selectedRoles.push(roleId);
            $('#selectedRoles').val(selectedRoles.join(','));
        }
    }

    // Function to remove selected role from hidden input
    function removeSelectedRole(roleId) {
        var selectedRoles = $('#selectedRoles').val().split(',');
        var index = selectedRoles.indexOf(roleId.toString());
        if (index !== -1) {
            selectedRoles.splice(index, 1);
            $('#selectedRoles').val(selectedRoles.join(','));
        }
    }

    // Function to add selected permission to hidden input
    function addSelectedPermission(permissionId) {
        var selectedPermissions = $('#selectedPermissions').val().split(',');
        if (!selectedPermissions.includes(permissionId.toString())) {
            selectedPermissions.push(permissionId);
            $('#selectedPermissions').val(selectedPermissions.join(','));
        }
    }

    // Function to remove selected permission from hidden input
    function removeSelectedPermission(permissionId) {
        var selectedPermissions = $('#selectedPermissions').val().split(',');
        var index = selectedPermissions.indexOf(permissionId.toString());
        if (index !== -1) {
            selectedPermissions.splice(index, 1);
            $('#selectedPermissions').val(selectedPermissions.join(','));
        }
    }
        this.submit();
    });


</script>

@endsection
