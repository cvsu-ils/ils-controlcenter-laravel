@extends('layouts.admin')

@section('main-content-header')
<div class="content-header" style="background-image: url('/images/bg-wifi.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a class="badge badge-primary float-sm-left mb-3" href="{{ route('admin.home') }}"><i class="fas fa-arrow-alt-circle-left"></i> Back to home</a>
                <br><br><br><br>
                <h1 class="m-0" style="text-shadow: 4px 4px 6px #838383;"><i class="fas fa-wifi"></i> Wifi Logs</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb px-3 elevation-1 bg-white float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Integrated Library System</li>
                    <li class="breadcrumb-item active">Wifi Logs</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection 

@section('main-content')
<div class="content">
    <div class="container-fluid px-3">
        <div class="d-block mt-3 rounded text-lg d-flex justify-content-end">
            <button class="btn btn-sm bg-gradient-success mr-1" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-plus mr-1"></i>Create</button>
        </div>
        <div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body px-5 py-5">
                        <h5 class="floatingInput">Location:</h5>
                        <select class="form-control form-control-lg border-dark mb-4" id="location_drp" aria-label="" >
                            <option value="" disabled selected hidden>Select Floor</option>
                            <option value="1st Floor">1st Floor</option>
                            <option value="2nd Floor">2nd Floor</option>
                            <option value="3rd Floor">3rd Floor</option>
                            <option value="4th Floor">4th Floor</option>
                        </select>
                    
                        <form id="formData">  
                            @csrf
                            <div class="has-float-label mb-4">
                                <h5 class="floatingInput">Card Number:</h5>
                                <input type="text" maxlength="9" class="form-control form-control-lg border-dark" id="floatingInput" placeholder="20xxxxxxx" required>
                            </div>
                            <button id="submitForm" class="btn btn-success btn-lg d-flex justify-content-center m-auto w-50" type="submit">Submit</button>
                        </form>
                </div>
            </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Summary of Wifi Logs Statistics</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="myChart" height="300" style="display: block; width: 764px; height: 300px;" width="764"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recently Added Wifi Logs</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group product-list-in-card" style="height:470px; overflow-y: scroll;" id="recentLogs">
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>

@endsection


@section('script')
<script>
    // add log
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
    
    // chart
    const ctx = document.getElementById('myChart');

    fetch('/admin/chart')
    .then(response => response.json())
    .then(data => {
        console.log(data);

        const months = data[0]; 
        console.log('Months:', months);
        const counts = data[1];
        console.log('Counts:', counts);
        const totalCount = counts.reduce((total, count) => total + count, 0);

        
        const datasets = [];

        datasets.push({
            label: 'Total',
            data: [totalCount],
            backgroundColor: 'rgba(80, 192, 192, 1)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        });

        datasets.push({
            label: '1st Floor',
            data: counts.slice(0, 1), 
            backgroundColor: 'rgba(20, 164, 77, 1)',
            borderColor: 'rgba(20, 164, 77, 1)',
            borderWidth: 1
        });

        datasets.push({
            label: '2nd Floor',
            data: counts.slice(1, 2), 
            backgroundColor: 'rgba(243, 227, 66, 1)',
            borderColor: 'rgba(243, 227, 66, 1)',
            borderWidth: 1
        });

        datasets.push({
            label: '3rd Floor',
            data: counts.slice(2, 3),
            backgroundColor: 'rgba(220, 76, 100, 1)',
            borderColor: 'rgba(220, 76, 100, 1)',
            borderWidth: 1
        });

        datasets.push({
            label: '4th Floor',
            data: counts.slice(3),
            backgroundColor: 'rgba(255, 144, 60, 1)',
            borderColor: 'rgba(255, 144, 60, 1)',
            borderWidth: 1
        });


        const processedData = {
            labels: months,
            datasets: datasets
        };

        createChart(ctx, processedData);
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });


    function processDataForChart(data) {
        const floor1Data = Array.from({ length: 12 }, () => 0);
        const floor2Data = Array.from({ length: 12 }, () => 0);
        const floor3Data = Array.from({ length: 12 }, () => 0);
        const floor4Data = Array.from({ length: 12 }, () => 0);
        

        data.forEach(entry => {
            const monthIndex = entry['month'] - 1;
            const location = entry['location'];
            const count = entry['count'];

            switch (location) {
                case '1st floor':
                    floor1Data[monthIndex] += count;
                    break;
                case '2nd floor':
                    floor2Data[monthIndex] += count;
                    break;
                case '3rd floor':
                    floor3Data[monthIndex] += count;
                    break;
                case '4th floor':
                    floor4Data[monthIndex] += count;
                    break;
                default:
                    break;
            }
        });

        return {
            'labels': months,
            'datasets': [
                {
                    label: '1st floor',
                    data: floor1Data,
                    backgroundColor: 'rgba(20, 164, 77, 0.2)',
                    borderColor: 'rgba(20, 164, 77, 1)',
                    borderWidth: 1
                },
                {
                    label: '2nd floor',
                    data: floor2Data,
                    backgroundColor: 'rgba(243, 227, 66, 0.2)',
                    borderColor: 'rgba(243, 227, 66, 1)',
                    borderWidth: 1
                },
                {
                    label: '3rd floor',
                    data: floor3Data,
                    backgroundColor: 'rgba(220, 76, 100, 0.2)',
                    borderColor: 'rgba(220, 76, 100, 1)',
                    borderWidth: 1
                },
                {
                    label: '4th floor',
                    data: floor4Data,
                    backgroundColor: 'rgba(255, 144, 60, 0.2)',
                    borderColor: 'rgba(255, 144, 60, 1)',
                    borderWidth: 1
                }
            ]
        };
    }

    function createChart(ctx, data) {
        console.log('Processed Data:', data); 
        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // end of chart

    fetch('/admin/recent')
    .then(response => response.json())
    .then(data => {
        console.log('Recent Logs:', data);

        document.getElementById("recentLogs").innerHTML = '';

        data.data.forEach(item => {
            let list = document.createElement("li");
            list.className = "list-group-item list-group-item-action";

            let floorClassColor = 'badge-primary';
            switch(item.location) {
                case "1st Floor":
                    floorClassColor = "badge-success";
                    break;
                case "2nd Floor":
                    floorClassColor = "badge-warning";
                    break;
                case "3rd Floor":
                    floorClassColor = "badge-danger";
                    break;
                case "4th Floor":
                    floorClassColor = "bg-orange";
                    break;
            }

            list.innerHTML = `
            <span class="text-secondary">
                <span class="badge badge-pill ${floorClassColor}" style="color: white !important;">${item.location}</span>
                <span class="font-weight-bold text-dark">Gera </span> created a wifi log for <span class="text-info"> ${item.cardnumber}</span> on <span>${item.formatted_timestamp}</span>
            </span>`;

            document.getElementById("recentLogs").appendChild(list); 
        });

    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });


</script>

@endsection
