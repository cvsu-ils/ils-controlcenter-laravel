@extends('layouts.admin')

@section('main-content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">WIFI LOGGING SYSTEM</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Starter Page</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

@endsection 

@section('main-content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>


<div class="container mt-4">
    <select class="form-select form-select-lg mb-4" id = "location_drp" style = "width:15%;" aria-label="Default select example" >
        <option value="" disabled selected hidden>Select Floor</option>
        <option value="1st Floor">1st Floor</option>
        <option value="2nd Floor">2nd Floor</option>
        <option value="3rd Floor">3rd Floor</option>
        <option value="4th Floor">4th Floor</option>
      </select>

      {{-- <div class="form-floating">
        <select class="form-select mb-3" id="location_drp"  style="width:15%;" aria-label="Floating label select example">
            <option value="1st Floor">1st Floor</option>
            <option value="2nd Floor">2nd Floor</option>
            <option value="3rd Floor">3rd Floor</option>
            <option value="4th Floor">4th Floor</option>
        </select>
        <label for="floatingSelect">Works with selects</label>
      </div> --}}
    
    <form id="formData">
        @csrf
        <div class="form-floating mb-4">
            <input type="text" maxlength="9" class="form-control form-control-lg border-dark w-50" id="floatingInput" placeholder="" required>
            <label for="floatingInput">Enter card number:</label>
        </div>
        <button id="submitForm" class="btn btn-success btn-lg" type="submit">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $('#floatingInput').on('keypress', function(event) {
            var key = event.key;
            if (!/\d/.test(key) && key !== 'Backspace' && key !== 'Delete' && key !== 'ArrowLeft' && key !== 'ArrowRight' && key !== 'Enter') {
                event.preventDefault();
            }
        });


        $('#formData').submit(function (e) {
            e.preventDefault();

            var inputValue = $('#floatingInput').val();
            var selectedLocation = $('#location_drp').val();

            if (inputValue.length !== 9) {
                Swal.fire({
                    title: "Input Error",
                    text: "Card number must be 9 characters.",
                    icon: "error"
                });
                return;
            }

            if (selectedLocation == null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Location is required!',
                    text: 'Please select location!'
                });
                return;
            }

            $.ajax({
                url: "{{ route('store') }}", 
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    cardnum: inputValue,
                    location: selectedLocation,
                    userId: {{ auth()->user()->id }}
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire({
                        icon: response.status,
                        title: response.title,
                        text: response.message
                    }).then(function (result) {
                        if(result.isConfirmed) {
                            if(response.status == "success") {
                                window.location = "{{ route('admin.wifi') }}";
                            }
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
