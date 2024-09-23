@extends('layouts.admin')

@section('title')
    Dashboard &sdot; Ladislao Theses Xplorer
@endsection

@section('main-content-header')
<div class="content-header" style="background-image: url('/images/landing/library.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
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
                    <li class="breadcrumb-item active">Ladislao Theses Xplorer</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('main-content')
<div class="content">
    <div class="container-fluid">
        <hr>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h3>
                        <?php
                            echo number_format(0);
                        ?>
                        </h3><p>Total e-theses</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <a href="?parent=users&action=browse" class="small-box-footer">
                        View records <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>
                        <?php
                            echo 0;
                        ?></h3>
                        <p>Total e-theses approval</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        View records <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3>
                        <?php
                            echo 0;
                        ?></h3>
                        <p>Total e-theses archives</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-archive"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        View records <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Summary of E-Theses</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">$18,230.00</span>
                                <span>Sales Over Time</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 33.1%
                                </span>
                                <span class="text-muted">Since last month</span>
                            </p>
                        </div> -->
                        <p class="text-gray">No data yet.</p>
                        <div class="position-relative mb-4">
                            <canvas id="myChart" height="300" style="display: block; width: 764px; height: 300px;" width="764" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recently Added E-theses</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            <p class="mt-3 mx-3 text-gray">
                                No theses uploaded yet.
                            </p>
                            <?php
                                // foreach($ebooks as $ebook) {
                                //     echo '
                                //         <li class="item">
                                //             <div class="product-img">
                                //                 <img src="http://library.cvsu.edu.ph/controlcenter/resources/images/covers/ebooks/open_access/default.jpg" style="height: 75px !important;">
                                //             </div>
                                //             <div class="product-info">
                                //                 <a href="javascript:void(0)" class="product-title">' . $ebook->title . '
                                //                 <span class="badge badge-warning float-right">' . $ebook->accession_no . '</span></a>
                                //                 <span class="product-description">
                                //                     <i>Encoded by: ' . $ebook->firstName . ' ' . $ebook->lastName . '</i> 
                                //                 </span>
                                //             </div>
                                //         </li>
                                //     ';
                                // }
                            ?>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="javascript:void(0)" class="uppercase">View All E-Theses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var labels = [];
    var fullLabels = [];
    var openAccessCount = [];
    var data = [];

    for(var i = 0; i < data.CLASSES.length; i++) {
        labels.push(data.CLASSES[i]);
        fullLabels.push(data.FULL_CATEGORY[i])
        openAccessCount.push(data.OEB_COUNT[i]);
    }

    var chartdata = {
        labels: fullLabels,
        datasets: [{
            label: ['Titles'],
            data: openAccessCount,
            backgroundColor: [
                '#007bff'
            ],
            borderRadius: 6
        }
        ]
    }
    
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
        options: {
            indexAxis: 'y',
            scales: {   
                xAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)"
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)"
                    }
                }]
            }
        }
    });
</script>
</script>
@endsection