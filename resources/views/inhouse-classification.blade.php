@extends('layouts.admin')

@section('main-content-header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">IN-HOUSE MANAGEMENT SYSTEM</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">In-House Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>
@endsection 

@section('main-content')
<div class=" m-2">    
<a href="{{ route('admin.inhouse') }}" class="btn btn-sm btn-primary pb-2"><i class="fas fa-arrow-alt-circle-left "></i>&nbsp <b>Back</b></a> <a href="{{ route('admin.editclass') }}" class="btn btn-sm btn-success pb-2"><i class="far fa-edit"></i>&nbsp <b>Edit Classification</b></a>   
</div><br>
    <!-- ADDED BUTTON  -->
    <div class="row container-fluid d-flex justify-content-center">      
    @forelse ($classification['data'] as $class)
            <div class="col-sm-3 btn btn-lg btn-light mb-4 p-4 border-dark ml-4" type="button" id="class" onclick="showClassificationModal('{{ $class['id'] }}')">
                <div class="row">
                    <div class="col-1">
                    <i class="far fa-bookmark text-success fw-bolder fs-1"></i>
                    </div>
                    <div class="col-11 mb-0 text-primary fw-bolder align-middle ps-1">
                    <div class="classname" style="color:">{{$class['name']}}<br>
                    </div>    
                    
                        <small class="m-0 text-dark" style="font-size:medium">({{$class['alphabetic_range']}}),({{$class['numeric_range']}})</small>
                        </div>
                        
                </div>
            </div>
           
            
    @empty
      <div class="col-sm-3 btn btn-lg btn-light  mb-4 rounded p-4 border-dark text-primary fw-bolder ml-4"  type="button" data-toggle="modal" data-target="#staticBackdrop">
            <div class="align-middle"> 
            Add Classification 
            </div>      
        </div>
    @endforelse
    <div class="col-sm-3 btn btn-lg btn-light  mb-4 rounded p-4 border-dark text-primary fw-bolder ml-4"  type="button" data-toggle="modal" data-target="#staticBackdrop">
            <div class="align-middle"> 
            Add Classification 
            </div>      
        </div>
</div>

@if (!empty($classification['data']))
     <!-- IN-HOUSE LOGS -->
     <div class="modal fade" id="classificationModal" tabindex="-1" aria-labelledby="classificationModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- 1 -->
              <div class="modal-header">
                <h5 class="modal-title" id="classificationModalLabel">{{$class['name']}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><h1>&times;</h1></span>
                </button>
              </div>

              <div class="modal-body">
              @if($errors->any())
                  @foreach($errors->all() as $error)
                  <div class="alert alert-danger p-2" id="error-message">       
                      {{$error}}
                      <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endforeach
                  @endif 
                  <form action="" id="count_form" method="POST">

                  <div class="mb-3 form-group">
                    <label for="location">Location</label>
                    <select class="form-control" id="location" name="location" required>
                      <option value="" selected disabled>Choose Floor...</option>
                      <option value="1st Floor">1st Floor</option>
                      <option value="2nd Floor">2nd Floor</option>
                      <option value="3rd Floor">3rd Floor</option>
                    </select>
                  </div>

                  <div class="mb-3" id="accession" hidden>
                      <label for="" class="form-label fw-bolder fs-3" >Accession Number</label>
                      <input
                          type="text"
                          class="form-control border-dark"
                          name="parameter"
                          id="parameter"
                          aria-describedby="helpId"
                          placeholder="Accession Number..."
                         
                          />
                  </div>
                  
                  <div class="mb-3">
                      <label for="" class="form-label fw-bolder fs-3" >Quantity</label>
                      <input
                          type="number"
                          class="form-control border-dark"
                          name="quantity"
                          id=""
                          aria-describedby="helpId"
                          placeholder="Qty..."
                          required
                          />
                  </div>
                  <div class="mb-3" hidden>
                      <label for="" class="form-label fw-bolder">CLASS ID</label>
                      <input
                          type="number"
                          class="form-control hidden"
                          name="class_id"
                          id="class_id"
                          aria-describedby="helpId"
                          placeholder=""
                         
                      />
                  </div>          
            </div>
            
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endif

   <!-- Modal Classification -->
   <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Classification</h1>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><h1>&times;</h1></span>
                </button>
                </div>
                <div class="modal-body">
                  @if($errors->any())
                  @foreach($errors->all() as $error)
                  <div class="alert alert-danger p-2">       
                      {{$error}}
                      <button type="button" class="btn-close float-right" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endforeach
                  @endif      
                      <div class="card-body">
                      <form id="class_form">
                      @csrf
                      <div class="mb-3">
                          <label for="" class="form-label fw-bolder">Classification Name</label>
                          <input
                              type="text"
                              class="form-control"
                              name="name"
                              id="class_name"
                              aria-describedby="helpId"
                              placeholder=""
                          />
                          <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                      </div>
                      <div class="row">
                      <div class="col-5 mb-3">
                          <label for="" class="form-label fw-bolder">Alphabetic Range</label>
                          <input
                              type="text"
                              class="form-control text-uppercase"
                              name="alphabetic_range"
                              id="alphabetic_range"
                              aria-describedby="helpId"
                              placeholder=""
                          />
                          <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                  </div>
                
                      <div class="col-7 row mb-3">
                      <div class="col-12 form-label"><b>Numeric Range</b></div>
                          <div class="row col">
                              <div class="col-3 float-right fw-bolder p-2">
                                  From:
                              </div>
                              <div class="col-9 float-left p-1">
                              <input
                              type="text"
                              class="form-control"
                              name="numeric_range_from"
                              id="numeric_range_from"
                              aria-describedby="helpId"
                              placeholder=""
                              
                          />
                          <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                              </div>
                      
                          </div>
                          <div class="col row">
                          <div class="col-2 float-right fw-bolder p-2">
                                  To:
                              </div>

                              <div class="col-10 float-left p-1">  
                          <input
                              type="text"
                              class="form-control"
                              name="numeric_range_to"
                              id="numeric_range_to"
                              aria-describedby="helpId"
                              placeholder=""
                            
                          />
                          <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                          </div>
                          </div>
                      </div>  </div>
                      
                    
                      <div id="app"></div>
                      </div>
                      </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>

                  </form>
                </div>
              </div>
            </div>
  </div>  
</div>   
</div>


</div>

@endsection

@section('script')
<!-- MODAL FOR IN-HOUSE LOGS -->
<script>
  function showClassificationModal(classificationId) {
  fetch(`classification/${classificationId}`)
    .then(response => response.json())
    .then(data => {
      // Update modal title and hidden input value
      document.getElementById('classificationModalLabel').textContent = data.class_name;
      document.getElementById('class_id').value = data.id;
      // Show the modal
      $('#classificationModal').modal('show');
    })
    .catch(error => {
      console.error('Error fetching classification details:', error);
    });
  
}
 </script>

<!-- ADD IN-HOUSE LOG -->
<script type="text/javascript"> 
  $(document).ready(function() {    
    const select = document.getElementById('location');
    const input = document.getElementById('accession');
    select.addEventListener('change', function() {
      if (select.value === '2nd Floor') {
        input.removeAttribute('hidden');
      } else {
        input.setAttribute('hidden', '');
      }
    });

    $('#count_form').submit(function(event) {
      event.preventDefault();     
        //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')      
      $.ajax({
          url: "{{ route('admin.InHouseAddLogs') }}",
          method: 'POST', // Changed to method: 'POST'
          data: {
          "_token": "{{ csrf_token() }}",
          quantity: $(this).find('input[name="quantity"]').val(),
          class_id: $(this).find('input[name="class_id"]').val(),
          location:$(this).find('select[name="location"]').val(),
          parameter:$(this).find('input[name="parameter"]').val(),
          userId: {{ auth()->user()->id}}                         
          },
          dataType: 'JSON',
          success: function(response) {
              if(response.status == "success") {
                  Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: response.message
                  }).then(function(){
                  window.location = "{{ route('admin.inhouse.class') }}";
                  });
              }
          },
          error: function(xhr, status, error) {
          console.log(xhr.responseText);
          let response = JSON.parse(xhr.responseText);
          if (response.errors.location) {
              Swal.fire({
                  icon: 'error',
                  title: 'An error occurred',
                  text: response.errors.location[0]
              });
            }
          else if (response.errors.quantity) {
              Swal.fire({
                  icon: 'error',
                  title: 'An error occurred',
                  text: response.errors.quantity[0]
              });
          }
          else {
              Swal.fire({
                  icon: 'error',
                  title: 'An error occurred',
                  text: response.message
              });
          }
        }
      });
                
    });          
  });    
</script>

<!-- ADD CLASSIFICATION -->
<script>
    $(document).ready(function() {
      const numericRangeFrom = document.getElementById('numeric_range_from');
      const numericRangeTo = document.getElementById('numeric_range_to');
  
      numericRangeFrom.addEventListener('keypress', function(event) {
    const key = event.key;
    if (isNaN(key)) {
      event.preventDefault();
    }
  });

  numericRangeTo.addEventListener('keypress', function(event) {
    const key = event.key;
    if (isNaN(key)) {
      event.preventDefault();
    }
  });
    $('#class_form').submit(function(event) {
          event.preventDefault(); // Prevent the default form submission

          $.ajax({
              url: "{{ route('admin.InHouseAddClass') }}",
              method: 'POST',
              data: $(this).serialize()+ "&user_id={{ auth()->user()->id }}", // Serialize the form data
              dataType: 'JSON',
              success: function(response) {
                  if (response.satus === "success") {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: response.message
        }).then(function() {
          window.location = "{{ route('admin.editclass') }}";
        });
      }
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
      let response = JSON.parse(xhr.responseText);
      if (response.errors) {
        Swal.fire({
              icon: 'error',
              title: 'An error occurred',
              text: response.message
          });
      }
  }
  });
  });
});
</script>
@endsection
