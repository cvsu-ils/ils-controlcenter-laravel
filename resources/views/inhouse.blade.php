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
<div class="content">
  <div class="container-fluid">
    <div class="m-3">
      <a href="{{ route('admin.inhouse.class') }}" class="btn btn-sm btn-success p-1"><i class="fas fa-plus"></i>&nbsp Add In-House Logs</a>
    </div>
    <hr>
    <div class="row">
      <div class="col-lg-8 col-12">
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Summary of In-House Logs Statistics</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="position-relative mb-4">
              <canvas id="inhouseChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Recently Added In-House Logs</h3>
          </div>
          <div class="card-body">
            <ul class="products-list product-list-in-card pl-2 pr-2">

            </ul>
          </div>
          <div class="card-footer text-center">
            <a href="javascript:void(0)"> &nbspView Report</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  const ctx = document.getElementById('inhouseChart');

  fetch('/admin/inhouse/chart')
  .then(response => response.json())
  .then(data =>{
    
    const months = data[0];
    const datacount = data[1];
    const total = datacount.reduce((total,count) => total + count, 0);
    
    console.log('Months: ', months)  
    console.log('Bilang: ', datacount)

    const chartData = [];

    chartData.push({
      label: 'Total',
      data:[total],
      backgroundColor: 'rgba(80, 192, 192, 1)',
      borderColor:'rgba(75, 192, 192, 1)',
      borderWidth: 1
    });
    
    chartData.push({
      label: '1st Floor',
      data:datacount.slice(0,1),
      backgroundColor: 'rgba(20,164,77,1)',
      borderColor:'rgba(20,164,77,1)',
      borderWidth: 1
    });

    chartData.push({
      label: '2nd Floor',
      data:datacount.slice(1,2),
      backgroundColor: 'rgba(243,227,66,1)',
      borderColor:'rgba(243,227,66,1)',
      borderWidth: 1
    });

    chartData.push({
      label: '3rd Floor',
      data:datacount.slice(2,3),
      backgroundColor: 'rgba(220,76,100,1)',
      borderColor:'rgba(220,76,100,1)',
      borderWidth: 1
    });
    const processedData = {
      labels: months,
      datasets: chartData
    };

    createChart(ctx, processedData);
  })
  .catch(error =>{
    console.error('Error Retrieving data: ', error);
  });


  function processDataForChart(data){
    const floorData1 = Array.from({ length: 12 }, () => 0);
    const floorData2 = Array.from({ length: 12 }, () => 0);
    const floorData3 = Array.from({ length: 12 }, () => 0);
  

  data.forEach(entry => {
    const monthIndex = entry['month'] - 1;
    const location = entry['location'];
    const count = entry['count'];

    console.log(entry);


    switch(location){
      case '1st':
          floorData1[monthIndex] += count;
          break;
      case '2nd':
      floorData1[monthIndex] += count;
      break;

      case '3rd':
      floorData1[monthIndex] += count;
      break;
    
      default:
        break;
    }
  });

  return{
    'labels': months,
    'datasets':[
      {
        label: '1st Floor',
        data:floorData1,
        backgroundColor: 'rgba(20,164,77,0.2)',
        borderColor:'rgba(20,164,77,1)',
        borderWidth: 1
      },
      {
        label: '2nd Floor',
        data:floorData2,
        backgroundColor: 'rgba(243,227,66,0.2)',
        borderColor:'rgba(243,227,66,1)',
        borderWidth: 1
      },
      {
        label: '3rd Floor',
        data:floorData3,
        backgroundColor: 'rgba(220,76,100,0.2)',
        borderColor:'rgba(220,76,100,1)',
        borderWidth: 1
      },
    ]
  };
}

function createChart(ctx, data){
  console.log('Processed Data: ', data);

  new Chart(ctx,{
    type: 'bar',
    data: data,
    options:{
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
}
</script>
@endsection
