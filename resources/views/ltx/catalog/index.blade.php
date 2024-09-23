@extends('layouts.admin')

@section('title')
    Catalog &sdot; Ladislao Theses Xplorer
@endsection

@section('main-content-header')
<div class="content-header image-layer" data-bg="/images/landing/library.jpg" style="background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a class="badge badge-primary float-sm-left mb-3" href="{{ route('admin.home') }}"><i class="fas fa-arrow-alt-circle-left"></i> Back to home</a>
                <br><br><br><br>
                <h1 class="m-0 text-white" style="text-shadow: 4px 4px 4px #404040;"><i class="fas fa-tachometer-alt"></i> Dashboard of Ladislao Theses Xplorer</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">E-books open access <span class="font-italic d-none" data-ebook="loader"> (Loading...)</span></h3>
                        <a class="btn bg-gradient-success btn-sm float-right" href="#"><i class="fas fa-plus"></i> Create new record</a>
                    </div>
                    <div class="card-body">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-12" style="position: relative;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Biblionumber</th>
                                                <th>Title</th>
                                                <th>Copyright Date</th>
                                                <th>Author</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data['data'] as $row)
                                                <tr>
                                                    <td>{{ $row['biblionumber'] }}</td>
                                                    <td>{{ $row['title'] }}</td>
                                                    <td>{{ $row['copyrightdate'] }}</td>
                                                    <td>{{ $row['author'] }}</td>
                                                </tr>
                                            @empty
                                                <p>No theses.</p>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" role="status" aria-live="polite">Showing <span>{{ $data['current_page'] }}</span> to <span>{{ $data['per_page'] }}</span> of <span>{{ number_format($data['total']) }}</span> entries</div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_numbers">
                                        <ul class="pagination">
                                            @foreach($data['links'] as $link)
                                                @if((\Illuminate\Support\Str::endsWith($link['label'], 'Previous')) && ($data['current_page'] - 1 > 0)) 
                                                    <li class="paginate_button page-item{{ ($link['active'] ? ' active' : '' )}}">
                                                        <a class="page-link" href="?page={{ ($data['current_page'] - 1) }}"><i class="fas fa-angle-double-left"></i> Previous</a>
                                                    </li>
                                                @endif
                                                @if(!(\Illuminate\Support\Str::startsWith($link['label'], 'Next')) && !(\Illuminate\Support\Str::endsWith($link['label'], 'Previous')))
                                                    @if(!\Illuminate\Support\Str::contains($link['label'], '...'))
                                                        <li class="paginate_button page-item{{ ($link['active'] ? ' active' : '' )}}">
                                                            <a class="page-link" href="{{ ($link['url'] ? '?page=' . $link['label'] : 'javascript:void(0)') }}">{{ $link['label'] }}</a>
                                                        </li>
                                                    @else
                                                        <li class="paginate_button page-item disabled">
                                                            <a class="page-link" href="javascript:void(0)">...</a>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if((\Illuminate\Support\Str::startsWith($link['label'], 'Next')) && (ceil($data['total'] / $data['per_page']) > $data['current_page'])) 
                                                    <li class="paginate_button page-item{{ ($link['active'] ? ' active' : '' )}}">
                                                        <a class="page-link" href="?page={{ ($data['current_page'] + 1) }}">Next <i class="fas fa-angle-double-right"></i></a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
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

    // $(document).ready(function() {
    //     $('#products-table').DataTable({
    //         processing: true,
    //         serverSide: false,
    //         ajax: '{{ route("products.getProducts") }}',
    //         columns: [
    //             { data: 'id', name: 'id' },
    //             { data: 'title', name: 'title' },
    //             { data: 'copyrightdate', name: 'copyrightdate' },
    //             { data: 'author', name: 'author' },
    //         ]
    //     });
    // });
    // $(document).ready(function() {
    //     var table = $('#products-table').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //             url: '{{ route("products.getProducts") }}',
    //             type: 'GET',
    //             // data: function(d) {
    //             //     d.customFilter = $('#customFilter').val();
    //             // },
    //             // beforeSend: function() {
    //             //     $('#loadingIndicator').show();
    //             // },
    //             // complete: function() {
    //             //     $('#loadingIndicator').hide();
    //             // }
    //         },
    //         columns: [
    //             { data: 'id', name: 'id' },
    //             { data: 'title', name: 'title' },
    //             { data: 'copyrightdate', name: 'copyrightdate' },
    //             { data: 'author', name: 'author' },
    //         ]
    //     });
    // });

    // function reloadData() {
    //     $('#example').DataTable().ajax.reload();
    // }
</script>
@endsection