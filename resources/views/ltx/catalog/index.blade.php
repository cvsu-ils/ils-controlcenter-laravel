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
                <div class="m-3">
                    <a  href="{{route('admin.ltx.catalog')}}" type="button" id="active" class="btn btn-sm bg-gradient-success mr-1  disabled" data-status="active"><i class="fas fa-book mr-1"></i> Actives</a>
                    <a  href="{{route('admin.ltx.archive')}}" type="button" id="archive" class="btn btn-sm btn-success mr-1" data-status="archive"><i class="fas fa-archive mr-1"></i> Archived</a>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">E-books open access <span class="font-italic d-none" data-ebook="loader"> (Loading...)</span></h3>
                        <a class="btn bg-gradient-success btn-sm float-right" href="#"><i class="fas fa-plus"></i> Create new record</a>
                    </div>
                    <div class="card-body">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-12" style="position: relative;">
                                    <div id="filter-btn" class="mb-3 float-right">
                                        <form action="{{route('admin.ltx.catalog')}}" method="get">
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <button type="submit" class="btn btn-success {{$filter == 'all' ? 'active' : ''}}" name="filter" value = "all">All</button>
                                            <button type="submit" class="btn btn-success {{$filter == 'published' ? 'active' : ''}}" name="filter" value = "published">Published</button>
                                            <button type="submit" class="btn btn-success {{$filter == 'unpublished' ? 'active' : ''}}" name="filter" value = "unpublished">Unpublished</button>
                                        </form>
                                    </div>

                                    </div> 
                                    <table id="thesis-table" class="table table-bordered">
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
                                            @forelse($data as $row)
                                            <tr>
                                                <td>{{ $row->accession_number }}</td>
                                                <td>{{ $row->title }}</td>
                                                <td>{{ $row->year }}</td>
                                                <td>@php
                                                    // Split the authors and types into arrays
                                                    $authors = explode('|', $row->authors);
                                                    $types = explode('^', $row->types);
                                                @endphp
                                                
                                                @foreach($authors as $index => $author)
                                                    {{ $author }}[{{ $types[$index] }}]
                                                    @if(!$loop->last),<br> @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <a  href="{{ route('admin.ltx.show', $row->id) }}" type="button" class="btn btn-sm bg-gradient-primary"><i class="fas fa-eye"></i></a>
                                                <a  href="{{ route('admin.ltx.edit',$row->id) }}" type="button" class="btn btn-sm bg-gradient-success"><i class="fas fa-edit"></i></a>
                                                <buton onclick="archiveThesis('{{$row->id}}')" type="button" class="btn btn-sm bg-gradient-danger"><i class="fas fa-archive"></i></button>
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
                                        {{ $data->appends(['filter' => request()->get('filter')])->links() }}
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

   

    //Archive THESIS region
    function archiveThesis (thesisId){
        let publishRouteUrl = "{{ route('admin.ltx.deactivate', ['id' => '__ID__']) }}";
        
            publishRouteUrl = publishRouteUrl.replace('__ID__', thesisId),

            Swal.fire({
                title: "Are you sure?",
                text: "You can restore it later.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, archive it!"
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
                            window.location = "{{ route('admin.ltx.catalog') }}";
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