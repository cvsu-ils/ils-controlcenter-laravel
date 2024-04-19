

@extends('layouts.admin')

@section('title')
  Home
@endsection

@section('main-content-header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Violation List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Quicklog</a></li>
              <li class="breadcrumb-item active">Test </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

@endsection 

@section('main-content') 

<style>
    .patron-holder span:first-child {
        flex-basis: 40%;
    }
</style>

  <div class="container">
    <form method="GET" action="{{ route('admin.result') }}">
      @csrf
        <input type="hidden" name="search" value="{{$search}}">
        <div class="btn-group btn-sm" role="group" aria-label="Basic outlined example">
            <button type="submit" class="btn btn-outline-success btn-sm text-dark {{ $filterCriteria == 'all' ? 'active' : '' }}" name="filter" value="all">All</button>
            <button type="submit" class="btn btn-outline-success btn-sm text-dark {{ $filterCriteria == 'ongoing' ? 'active' : '' }}" name="filter" value="ongoing">On-Going</button>
            <button type="submit" class="btn btn-outline-success btn-sm text-dark {{ $filterCriteria == 'cleared' ? 'active' : '' }}" name="filter" value="cleared">Cleared</button>
        </div>
    </form>

    <div class="btn-toolbar justify-content-between">
      <div class="input-group">
        <div id="navbar-search-autocomplete" class="form-outline" data-mdb-input-init>     

          <form method="GET" action="{{ route('admin.result') }}">    
            @csrf
              <input class="form-control-sm" type="text" name="search" placeholder="Search..." value="{{$search}}">
              <button type="submit" id="search" class="btn btn-sm btn-secondary rounded">Search</button>
          </form>

        </div>
      </div>

        <button type="button" class="btn btn-sm btn-warning rounded" data-toggle="modal" data-target="#createModal">                    
          <i class="fas fa-plus"></i> 
          <span class="ml-2">Create</span>
        </button>

    </div><br>

    <!-- Modal Content -->
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">            
              <h5 class="modal-title" id="exampleModalLabel"> Add Violation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form id="formData" class="px-3">
                @csrf
                <label> Find Patron</label>        
                <div class="d-flex justify-content-center">
                  <div class="input-group">                                  
                    <input type="text" class="form-control form-control-sm mr-2" id="cardNumber" name="cardNumber" maxlength="9" placeholder="Enter Card Number" required>
                    <button type="submit" id="submitForm" class="btn bg-success btn-sm"><i class="fas fa-search"></i></button>
                  </div>
                </div><br>
                <div id="patronInfo" class="text-bold"></div>             
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
                
              </form>

              <form method="POST" id="input_form" class="px-3">
                @csrf
                <input type="hidden" name="cardnum" id="cardnum">
                <div class="mb-3">
                    <label for="violation_desc">Violation Description</label>
                    <input type="text" class="form-control form-control-sm w-100" id="violation_desc" name="violation_desc" placeholder="Enter Description..">
                </div>
                <div class="mb-3">
                  <label for="violation_type">Violation Type</label>
                    <select class="form-select form-control-sm text-secondary rounded w-100"  style="border-color: lightgray;" name="violation_type" id="violation_type" onchange="toggleDateEndedVisibility()" required>
                      <option value="none" disabled>Select Violation Type</option>
                      <option value="Accomplishment">Accomplishment</option>
                      <option value="Duration">Duration</option>                        
                    </select>
                </div>                
                <div id="endDateRow">                
                    <input type="date" class="form-control form-control-sm w-100" id="dateEnded" name="dateEnded" required>
                    <input type="hidden" id="remarks" name="remarks" value="0">
                </div>                    
                <div class="d-flex justify-content-center mb-4">
                   <input class="btn bg-success mt-3 w-75" type="submit" value="Submit" id="mainForm">
                </div>

              </form>

            </div>
            
          </div>
        </div>
      </div>
    <!-- End Modal Content -->

      <table class= "table table-striped table-hover" id="data-table">        
        <tr>
          <th class= "bg-success text-light">ID</th>
          <th class= "bg-success text-light">CARD NUMBER</th>
          <th class= "bg-success text-light">VIOLATION DESCRIPTION</th>
          <th class= "bg-success text-light">VIOLATION TYPE</th>
          <th class= "bg-success text-light">REMARKS</th>
          <th class= "bg-success text-light" >ACTION</th>
                
        </tr>
        
        @forelse($violations as $violation)

        <tr>                
        <td>{{ $violation['user_id'] }}</td>
        <td>{{ $violation['card_number'] }}</td>
        <td>{{ $violation['description'] }}</td>
        <td>{{ $violation['type'] }}</td>
        <td>
            @if(is_null($violation['status']) && !is_null($violation['date_ended']))
                <label><span style="color: maroon; font-weight: bolder"> Banned </span> until {{ $violation['date_ended'] }} </label>    
            @elseif($violation['status'] == 0 && is_null($violation['date_ended']))
                <label>Accomplishment Incomplete</label>          
            @endif
          </td>
          <td>
              <div class = "d-flex justify-content-center">
                @if($violation['status'] == 0 && is_null($violation['date_ended']))                        
                  <button type="button" class="btn btn-outline-success mx-3" data-toggle="modal" data-target="#completeModal{{ $violation['user_id'] }}">Completed</button>
              </div>

        <!-- Start Modal -->
        <div class="modal fade" id="completeModal{{ $violation['user_id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-bold" id="exampleModalLongTitle">Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          
              <div class="modal-body">
                <div class = "d-flex justify-content text-dark"> 
                  <p class = "text-uppercase text-bold">ID</p>
                  <p class = "">- {{ $violation['user_id'] }}</p>
                </div>
                <div class = "d-flex justify-content text-dark"> 
                    <p class = "text-uppercase text-bold">PATRON</p>
                    <p class = "">- {{ $violation['card_number'] }}</p>
                </div>
                <div class = "d-flex justify-content text-dark"> 
                    <p class = "text-uppercase text-bold">VIOLATION </p>
                    <p class = ""> - {{ $violation['description'] }}</p>
                </div>
              </div>

              <div class="modal-footer">
                <a href="{{ route('edit', ['selectedId' => $violation['user_id']]) }}" class="btn modal-close waves-effect waves-green btn-dark text-uppercase bg-warning">Continue</a>
              </div>

            </div>
          </div>
        </div>

        <!-- End Modal -->

                @elseif(\Carbon\Carbon::parse($violation['date_ended'])->lt(\Carbon\Carbon::parse($today)))
                  <label class="text-uppercase text-secondary d-flex justify-content-center" for="">Cleared</label>
                @elseif(is_null($violation['date_ended']) && $violation['status']==1)
                  <label class="text-uppercase text-secondary d-flex justify-content-center "for="">Cleared</label>
                @endif
          </td>
        </tr>
        @empty
                
        <tr>
          <td>No Data Found</td>
        </tr>
        @endforelse

      </table>

  </div>

@endsection

@section('script')

  <script>

    $(document).ready(function() {
        // Error handling on violation form
        $('#mainForm').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{route('admin.store')}}',
                type: 'POST',
                data: $('#input_form').serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Form submitted successfully.',
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            if (response.status == "success") {
                                window.location = "{{route('admin.result')}}";
                            }
                        }
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
    });

    $(document).ready(function() {

      // Search function
      $('#search').on('keyup', function() {
        $.ajax({
          type: 'GET',
          url: '{{route('admin.search')}}',
          data: {'searchData': $(this).val()},
            success: function(data) {
              console.log(data.card_number);            
            }
        });
      });

    });

    $(document).ready(function() {

      // Accomplishment and Duration Change Display
      function toggleDateEndedVisibility() {
        var violationType = $('#violation_type').val();
          if (violationType === 'Accomplishment') {
            $('#endDateRow').hide();
          } else {
            $('#endDateRow').show();
          }
      }
      toggleDateEndedVisibility();

      $('#violation_type').change(function() {
            toggleDateEndedVisibility();
      });

      // Disabling past dates
      var today = new Date().toISOString().split('T')[0];
        document.getElementById("dateEnded").setAttribute("min", today);

    });

    
    $(document).ready(function() {

      // Error handling for card number input / find patron information
      $('#cardNumber').on('keypress', function(event) {
        var key = event.key;
          if (!/\d/.test(key) && key !== 'Backspace' && key !== 'Delete' && key !== 'ArrowLeft' && key !== 'ArrowRight' && key !== 'Enter') {
            event.preventDefault();
          }
      });      

      $('#formData').submit(function (e) {
        e.preventDefault();
        var inputValue = $('#cardNumber').val();

        if (inputValue.length !== 9) {
          Swal.fire({
            title: "Input Error",
            text: "Card number must be 9 characters.",
            icon: "error"
          });
          return;
        }
      });
    });

    $(document).ready(function() {

      function hideForm() {
        $('#input_form').hide();
        
      }
      function showForm() {
        $('#input_form').show();
      }
      hideForm();

      $('#formData').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

          $.ajax({
            url: '/admin/patron/search',
            type: 'POST',
            data: formData,
              success: function(response) {
                if(response.status == 'error') {

                  // Clear Response Data   
                  $('#patronInfo').html("Patron Information"); 
                  $('#response').text("Not Found");
                  $('#cardnumber, #name, #registered, #expired, #categorycode, #college, #program').text("");

                  // Clear Data Name
                  $('#cn, #nm, #cc, #de, #col, #pr').text("");

                  // Clear Response Data Status
                  $('#registered, #expired').text(" ");
                  hideForm();

                } else {

                  // Displaying response data
                  $('#patronInfo').html("Patron Information"); 
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

                  // Display data name
                  $('#cn').html("<b>Card Number: </b>");
                  $('#nm').html("<b>Name: </b>");
                  $('#cc').html("<b>Category Code: </b>");
                  $('#de').html("<b>Account Status: </b>");
                  $('#col').html("<b>College: </b>");
                  $('#pr').html("<b>Program: </b>");   
                  $('#cardnum').val(response.data.cardnumber); 
                  showForm();               
                   
                  console.log(response.data);
                }
              },
            });
          });

    });

  </script>

@endsection

