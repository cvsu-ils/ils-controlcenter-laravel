

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
              <li class="breadcrumb-item"><a href="{{ route('admin.quicklog') }}">Quicklog</a></li>
              <li class="breadcrumb-item active">Test </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

@endsection 

@section('main-content') 
  <div class="container px-4 py-2">
    <form method="GET" action="{{ route('admin.result') }}">
        <input type="hidden" name="search" value="{{$search}}">
        <div class="btn-group btn-sm" role="group" aria-label="Basic outlined example">
            <button type="submit" class="btn btn-outline-success btn-sm text-dark {{ $filterCriteria == 'all' ? 'active' : '' }}" name="filter_criteria" value="all">All</button>
            <button type="submit" class="btn btn-outline-success btn-sm text-dark {{ $filterCriteria == 'ongoing' ? 'active' : '' }}" name="filter_criteria" value="ongoing">On-Going</button>
            <button type="submit" class="btn btn-outline-success btn-sm text-dark {{ $filterCriteria == 'cleared' ? 'active' : '' }}" name="filter_criteria" value="cleared">Cleared</button>
        </div>
    </form>
    <div class="btn-toolbar justify-content-between">
      <div class="input-group p-2 mb-4">
        <div id="navbar-search-autocomplete" class="form-outline" data-mdb-input-init>      
        <form method="GET" action="{{ route('admin.result') }}">    
            <input class="form-control-sm" type="text" name="search" placeholder="Search..." value="{{$search}}">
            <button type="submit" id="search" class="btn btn-sm btn-secondary rounded">Search</button>
          </form>
        </div>
      </div>
      <div>
        <a href="{{ route('admin.form') }}" type="button" class="btn btn-sm btn-warning p-2 m-2 rounded"><i class="fas fa-plus"></i> Create</a>
      </div>
    </div>

      <div>    
        <table class= "table table-striped table-hover" id="data-table">        
            <tr>
                <th class= "bg-success text-light">ID</th>
                <th class= "bg-success text-light">CARD NUMBER</th>
                <th class= "bg-success text-light">VIOLATION DESCRIPTION</th>
                <th class= "bg-success text-light">VIOLATION TYPE</th>
                <th class= "bg-success text-light">REMARKS</th>
                <th class= "bg-success text-light" >ACTION</th>
                
            </tr>
            
            
            </tr>
            @forelse($violations as $violation)

            <tr>                
                <td>{{ $violation->id }}</td>
                <td>{{ $violation->card_number }}</td>
                <td>{{ $violation->violation_desc }}</td>
                <td>{{ $violation->violation_type }}</td>
                <td>
                    @if(is_null($violation->remarks) && !is_null($violation->dateEnded))
                        <label for=""><span style="color: maroon; font-weight: bolder">Banned</span> until {{ $violation->dateEnded }}</label>    
                    @elseif($violation->remarks == 0 && is_null($violation->dateEnded))
                        <label for="">Accomplishment Incomplete</label>          
                    @endif
                </td>
                <td>
                    <div class = "d-flex justify-content-center">
                    @if($violation->remarks == 0 && is_null($violation->dateEnded))                        
                        <button type="button" class="btn btn-outline-success mx-3" data-toggle="modal" data-target="#completeModal{{ $violation->id }}">Completed</button>
                      </div>

<!-- Start Modal -->
<div class="modal fade" id="completeModal{{ $violation->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <p class = "">- {{ $violation->id }}</p>
          </div>
          <div class = "d-flex justify-content text-dark"> 
                <p class = "text-uppercase text-bold">PATRON</p>
                <p class = "">- {{ $violation->card_number }}</p>
          </div>
          <div class = "d-flex justify-content text-dark"> 
                <p class = "text-uppercase text-bold">VIOLATION </p>
                <p class = ""> - {{ $violation->violation_desc }}</p>
          </div>
        </div>

          <div class="modal-footer">
              <a href="{{ route('edit', ['selectedId' => $violation->id]) }}" class="btn modal-close waves-effect waves-green btn-dark text-uppercase bg-warning">Continue</a>
          </div>
    </div>
  </div>
</div>

<!-- End Modal -->

                      @elseif(\Carbon\Carbon::parse($violation->dateEnded)->lt(\Carbon\Carbon::parse($today)))
                          <label class="text-uppercase text-secondary d-flex justify-content-center" for="">Cleared</label>
                      @elseif(is_null($violation->dateEnded) && $violation->remarks==1)
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
    
      </form><br><br>
</div>
</div>

<!-- try pagination -->

<div class="container px-4 py-2">
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
      <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1">Previous</a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#">Next</a>
      </li>
    </ul>
  </nav>
</div>

<!-- end try pagination -->

@endsection

@section('script')

<script>

    $(document).ready(function() {

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

</script>

@endsection

