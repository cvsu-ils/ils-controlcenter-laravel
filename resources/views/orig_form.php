
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
<form method="POST" action="{{ route('admin.create') }}" class="w-75" id="input_form">
               @csrf 
               <div class="mb-3">
                   <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Enter Card Number" required>
                   <div id="error_message" class="error-message text-danger"></div>
               </div>

               <div class="mb-3">
                   <input type="text" class="form-control" id="violation_desc" name="violation_desc" placeholder="Enter Violation Description" required>
               </div>

               <div class="mb-3">
                   <select class="form-select" name="violation_type" id="violation_type" onchange="toggleDateEndedVisibility()" required>
                       <option value="none" disabled>Select Violation Type</option>
                       <option value="Accomplishment">Accomplishment</option>
                       <option value="Duration">Duration</option>                        
                   </select>
               </div>
                
               <div id="endDateRow">                
                   <input type="date" class="form-control" id="dateEnded" name="dateEnded">
                   <input type="hidden" id="remarks" name="remarks" value="1">
               </div>
                    
               <div class="text-center mb-4">
                   <input class="btn btn-outline-success mt-3" type="submit" value="Submit">
               </div>
           </form>
</div>

      <script>
        // for hiding date input
        function toggleDateEndedVisibility() {
            var dateEnded = document.getElementById('endDateRow');
            var violationType = document.getElementById('violation_type').value;
            if (violationType === 'Accomplishment') {
                dateEnded.style.display = 'none'; 
            } else {
                dateEnded.style.display = '';
            }
        }
        toggleDateEndedVisibility();
        document.getElementById('violation_type').addEventListener('change', toggleDateEndedVisibility);

        // for disabling past dates
        var today = new Date().toISOString().split('T')[0];
        document.getElementById("dateEnded").setAttribute("min", today);
    </script>

<!-- Error Card Num input -->
    <script>
        var cardNumberInput = document.getElementById('card_number');
        var errorMessage = document.getElementById('error_message');
        var submitButton = document.getElementById('submit_button');
        var form = document.getElementById('input_form');

        cardNumberInput.addEventListener('input', function() {
            var cardNumber = this.value.trim();
            var maxLength = 9;
            var pattern = /^\d+$/; // Regular expression to allow only digits

            if (!pattern.test(cardNumber)) {
                // If input contains non-numeric characters
                errorMessage.textContent = 'Only numbers are allowed.';
                this.value = cardNumber.replace(/\D/g, ''); // Remove non-numeric characters
            } else if (cardNumber.length > maxLength) {
                // If input length exceeds the maximum allowed length
                errorMessage.textContent = 'You cannot type more than ' + maxLength + ' numbers.';
                this.value = cardNumber.slice(0, maxLength); // Truncate the input
            } else if (cardNumber.length < maxLength) {
                // If input length is less than the required length
                errorMessage.textContent = 'Card number must be at least ' + maxLength + ' numbers long.';
            } else {
                errorMessage.textContent = ''; // Clear error message if input length is within limit
            }

            // Disable submit button if error message is displayed
            submitButton.disabled = errorMessage.textContent !== '';
        });

        form.addEventListener('submit', function(event) {
            // Prevent form submission if there are still errors
            if (errorMessage.textContent !== '') {
                event.preventDefault();
            }
        });

        // Initially disable submit button
        submitButton.disabled = true;
    </script>
@endsection