
@extends('layouts.admin')

@section('title')
  Home
@endsection

@section('main-content-header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Violation Form</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.result') }}">Back</a></li>
              <li class="breadcrumb-item active">Violations</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

@endsection 

@section('main-content')

<div class="container">
<form method="POST" class="w-75" id="input_form">
               @csrf 
               <div class="mb-3">
                   <!-- Button trigger modal -->
                   <label for="">Card Number</label>
                    <button type="button" class="btn w-100 bg-white float-left" style="border-color: lightgray" data-toggle="modal" data-target="#exampleModalCenter" value="cardnum" id="cardnumModal">                    
                    <span class="float-left text-secondary">20xxxxxxx</span>
                    </button>
                    <input type="hidden" name="cardnum" id="cardnum">
               </div>

               <div class="mb-3">
                    <label for="">Violation Description</label>
                   <input type="text" class="form-control" id="violation_desc" name="violation_desc" placeholder="Input here..">
               </div>

               <div class="mb-3">
                <label for="">Violation Type</label>
                   <select class="form-select w-100 text-secondary rounded"  style="height: 38px; border-color: lightgray" name="violation_type" id="violation_type" onchange="toggleDateEndedVisibility()" required>
                       <option value="none" disabled>Select Violation Type</option>
                       <option value="Accomplishment">Accomplishment</option>
                       <option value="Duration">Duration</option>                        
                   </select>
               </div>
                
               <div id="endDateRow">                
                   <input type="date" class="form-control" id="dateEnded" name="dateEnded" required>
                   <input type="hidden" id="remarks" name="remarks" value="0">
               </div>
                    
               <div class="text-center mb-4">
                   <input class="btn btn-outline-success mt-3" type="submit" value="Submit" id="mainForm">
               </div>

               </form>
               </div>
               <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formData" >
                            @csrf
                            <div class="d-flex justify-content-center">
                                <div class="input-group">                                
                                    <input type="text" class="form-control form-control-sm mr-2" id="card_number" name="card_number" maxlength="9" placeholder="Enter Card Number" required>
                                    <button type="submit" id="submitForm" class="btn bg-success btn-sm"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        
                            <hr>
                            <div class="my-3 result">
                                <div class="d-flex patron-holder">
                                    <span id="cn"></span>
                                    <span id="cardnumber"></span>
                                </div>
                                <div class="d-flex patron-holder">
                                    <span id="nm"></span>
                                    <span id="name"></span>
                                </div>
                                <div class="d-flex patron-holder">
                                    <span id="cc"></span>
                                    <span id="categorycode"></span>
                                </div>
                                <div class="d-flex patron-holder">
                                    <span id="col"></span>
                                    <span id="college"></span>
                                </div>
                                <div class="d-flex patron-holder">
                                    <span id="pr"></span>
                                    <span id="program"></span>
                                </div>
                                <div class="d-flex patron-holder">
                                    <span id="de"></span>
                                    <span id="registered"></span>
                                    <span id="expired"></span>
                                </div>
                                <span id="response"></span>
                            </div>                            
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit" id="chooseButton" class="btn btn-warning btn-sm" data-dismiss="modal">Choose</button>                        
                            </div>
                            </form>
                    </div>
                </div>
                </div>   
                </div>
<style>
    .patron-holder span:first-child {
        flex-basis: 25%;
    }
</style>

@endsection

@section('script')
<script>
    
    $(document).ready(function() {
    $('#mainForm').click(function(e) {
        e.preventDefault(); // Prevent form submission
        var cardNum = $('#cardnum').val().trim();
        var violationDesc = $('#violation_desc').val().trim();
        var violationType = $('#violation_type').val().trim();
        var durationDate = $('#dateEnded').val().trim();

        if (cardNum === "" || violationDesc === "" || violationType === "none" || (violationType === "Duration" && durationDate === "")) {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Please fill out all required fields!',
            });
        } else {
            $.ajax({
                url: '{{route('admin.store')}}',
                type: 'POST',
                data: $('#input_form').serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response if needed
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Form submitted successfully.',
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error response if needed
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while submitting the form.',
                    });
                }
            });
        }
    });
});

$(document).ready(function() {

        function toggleDateEndedVisibility() {
            var violationType = $('#violation_type').val();
            if (violationType === 'Accomplishment') {
                $('#endDateRow').hide();
            } else {
                $('#endDateRow').show();
            }
        }

        // Initial call to toggle visibility
        toggleDateEndedVisibility();

        // Event listener for violation type change
        $('#violation_type').change(function() {
            toggleDateEndedVisibility();
        });

        // for disabling past dates
        var today = new Date().toISOString().split('T')[0];
        document.getElementById("dateEnded").setAttribute("min", today);

        // Error Handling AJAX

            $('#card_number').on('keypress', function(event) {
                var key = event.key;
                if (!/\d/.test(key) && key !== 'Backspace' && key !== 'Delete' && key !== 'ArrowLeft' && key !== 'ArrowRight' && key !== 'Enter') {
                    event.preventDefault();
                }
            });

            $('#formData').submit(function (e) {
                e.preventDefault();

                var inputValue = $('#card_number').val();

                if (inputValue.length !== 9) {
                    Swal.fire({
                        title: "Input Error",
                        text: "Card number must be 9 characters.",
                        icon: "error"
                    });
                    return;
                }
            });

            

            // Displaying data

            $('#formData').submit(function(event) {
                event.preventDefault(); // Prevent form submission
                var formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: '/admin/patron/search',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.status == 'error') {
                            $('#response').text("Patron Not Found");
                            $('#cardnumber').text(" ");
                            $('#name').text(" ");
                            $('#dateexpiry').text(" ");
                            $('#categorycode').text(" ");
                            $('#college').text(" ");
                            $('#program').text(" ");

                            $('#cn').text(" ");
                            $('#nm').text(" ");
                            $('#cc').text(" ");
                            $('#de').text(" ");
                            $('#col').text(" ");
                            $('#pr').text(" ");

                            $('#registered').text(" ");
                            $('#expired').text(" ");

                        } else {
                            // print data to modal
                            $('#response').text(" ");
                            $('#cardnumber').html(response.data.cardnumber + "<br>");
                            $('#name').html(response.data.firstname + ' ' + response.data.surname + "<br>");
                            $('#categorycode').html(response.data.categorycode + "<br>");    
                            $('#college').html(response.data.sort2 + "<br>");                           
                            $('#program').html(response.data.sort1 + "<br>");   

                            if(!response.data.isExpired) {
                                $('#registered').html("<span class='badge badge-success'> REGISTERED </span><br>").show();
                                $('#expired').hide();
                            } else {
                                $('#expired').html("<span class='badge badge-danger'> EXPIRED </span><br>").show();
                                $('#registered').hide();
                            }

                            $('#cn').html("<b>Card Number: </b>");
                            $('#nm').html("<b>Name: </b>");
                            $('#cc').html("<b>Category Code: </b>");
                            $('#de').html("<b>Account Status: </b>");
                            $('#col').html("<b>College: </b>");
                            $('#pr').html("<b>Program: </b>");

                            $('#chooseButton').click(function() {
                                if (response.data.cardnumber !== null) {
                                    $('#cardnumModal').html(response.data.cardnumber);
                                    $('#cardnum').val(response.data.cardnumber);     
                                } else {
                                    // Reset modal value
                                    $('#cardnumModal').html("20xxxxxxx");
                                    $('#cardnum').val("20xxxxxxx");
                                    return;
                                }
                            });
                            
                            console.log(response.data);
                        }
                    },
                });
            });

            
            
            
    });


</script>

@endsection