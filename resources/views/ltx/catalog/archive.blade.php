@extends('layouts.admin')

@section('title')
    Catalog &sdot; Ladislao Theses Xplorer
@endsection

@section('main-content-header')
<div class="content-header image-layer" data-bg="/images/landing/library.jpg" style="background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a class="badge badge-primary float-sm-left mb-3" href="{{ route('admin.ltx.dashboard') }}"><i class="fas fa-arrow-alt-circle-left"></i> Back to dashboard</a>
                <br><br><br><br>
                <h1 class="m-0 text-white" style="text-shadow: 4px 4px 4px #404040;"><i class="fas fa-tachometer-alt"></i> Ladislao Theses Xplorer</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb px-3 elevation-1 bg-white float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Integrated Library System</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.ltx.dashboard') }}">Ladislao Theses Xplorer</a></li>
                    <li class="breadcrumb-item active">Catalog</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<style>
    .ils-table-filters-divider {
        display: inline-block;
        width: 5%;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <hr>
        <div class="row">
            <div class="col-12">
                <div class="mb-2">
                    <a  href="{{route('admin.ltx.catalog')}}" type="button" id="active" class="btn btn-sm btn-success mr-1" data-status="active"><i class="fas fa-book mr-1"></i> Actives</a>
                    <a  href="{{route('admin.ltx.archive')}}" type="button" id="archive" class="btn btn-sm bg-gradient-success mr-1  disabled" data-status="archive"><i class="fas fa-archive mr-1"></i> Archived</a>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Archived E-books <span class="font-italic d-none" data-ebook="loader"> (Loading...)</span></h3>
                    </div>
                    <div class="card-body">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Accession Number</th>
                                                <th>Title</th>
                                                <th>Copyright Date</th>
                                                <th>Author</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data as $row) <!-- Using $theses fetched from the controller -->
                                                <tr>
                                                    <td>{{ $row->accession_number }}</td>
                                                    <td>{{ $row->title }}</td>
                                                    <td>{{ $row->year }}</td>
                                                    <td>  
                                                        @foreach ($row->authors as $author)
                                                        {{ $author->name }} [{{$author->type}}], <br>
                                                       @endforeach  
                                                    </td>
                                                    <td>
                                                        <a  href="{{ route('admin.ltx.show', $row->id) }}" type="button" class="btn btn-sm bg-gradient-primary rounded-0"><i class="fas fa-eye"></i></a>
                                                        <buton onclick="syncThesis('{{$row->id}}')" type="button" class="btn btn-sm bg-gradient-success rounded-0"><i class="fas fa-sync"></i></buton>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No theses available.</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" role="status" aria-live="polite">
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ number_format($data->total()) }} entries
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_numbers">
                                        {{ $data->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lazyBgElements = document.querySelectorAll('.image-layer[data-bg]');

        lazyBgElements.forEach(function(element) {
            var imageUrl = element.getAttribute('data-bg');
            element.style.backgroundImage = 'url(' + imageUrl + ')';
        });
    });

    //Synching THESIS region
    function syncThesis (thesisId){
        let publishRouteUrl = "{{ route('admin.ltx.sync', ['id' => '__ID__']) }}";
        
            publishRouteUrl = publishRouteUrl.replace('__ID__', thesisId),

            Swal.fire({
                title: "Restore Item?",
                text: "This item will moved back to active status.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, restore it!"
            }).then((result) => {
            if (result.isConfirmed) {            
                $.ajax({
                    method: "PATCH",
                    url: publishRouteUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {

                        if(response.status == "success"){
                            Swal.fire({
                                title: response.message,
                                icon: response.status,
                        }).then(function(){
                            window.location = "{{ route('admin.ltx.archive') }}"
                        });
                        }else{
                            Swal.fire({
                                title: response.message,
                                icon: response.status,
                        });
                        }
                        
                    }
                });
            }
        });
    }
</script>
@endsection