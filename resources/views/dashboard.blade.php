@extends('layouts.admin')

@section('main-content-header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col-6 row">
            <h1><i class="fas fa-chart-area"></i> Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>
@endsection 

@section('main-content')
<style>


    .btn-group .btn-outline-success:focus,
    .btn-group .btn-outline-success:active,
    .btn-group .btn-outline-success[aria-pressed="true"] {
    outline: none;
    background-color: #28a745; 
    color: white;
    }

    .btn-group .btn-outline-success {
        background-color: #ffffff;
    }

    .btn-group  {
        background-color: #dedede;
    }

    .btn-group .btn-outline-success:hover {
    background-color: #198754;
    color: white;
    }

    .button-wrapper {
    overflow: hidden;
    width: calc(5 * 62px);
    }

    .button-group {
    display: flex;
    transition: transform 0.3s ease-in-out;
    }



    @media (max-width: 480px) {
    .button-wrapper {
    width: calc(3 * 60px);
    }
    }

    @media (min-width: 481px) and (max-width: 768px) {
    .button-wrapper {
    width: calc(4 * 75px); 
    }
    }
</style>
<div class="content">   

<hr>

<!-- Collections -->
<div class="container">
    <h4>Collection</h4>
    <div class="card">
        <div class="card-body">
            
            <div class="mb-3 mt-2 text-left">
                <div class="btn-group" role="group">
                    <div class="">
                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle" type="button" id="collectionsDropdown" data-toggle="dropdown">
                                Select Collection
                            </button>   
                            <div class="dropdown-menu" aria-labelledby="collectionsDropdown">
                                @foreach ($collectionsData as $collections)
                                    <button type="button" class="dropdown-item collections-button" aria-pressed="false" onclick="populateCollections('{{ $collections->label }}', '{{ $collections->key }}', '{{ $collections->value }}', '{{ $collections->class_icon }}'); setActiveButton(this);" data-form-type="collections" data-class-icon="{{ $collections->class_icon }}">
                                        {{ $collections->label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Collection form -->
            <form id="updateCollections" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="selectedKeyCollections" name="selectedKeyCollections">
                <input type="hidden" id="iconpickerCollections" name="iconpickerCollections">

                <div class="row text-left">
                    <div class="col-md-6">
                        <div class="form-group text-left mb-0">
                            <label for="collectionsValue">Value</label>
                            <input type="number" class="form-control" id="collectionsValue" name="collectionsValue" required disabled>
                        </div>
                        <div class="d-flex ">
                            <div class=" ">
                                <span style="color: gray; margin-right: 10px; display:none; font-size:14px;" id="apiMessage">Retrieving Data... <span id="collectionsEndpointMessage"></span></span>
                            </div>
                            <div>
                                <a type="button" class="sync-button" id="sync-button" style="display:none; font-size:14px;">Sync Now</a>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="collectionsValue">Select Icon</label>
                        <br>
                        <button class="btn btn-secondary iconpicker-btn" role="iconpicker" id="iconPickerBtnCollections" disabled></button>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm update-button">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>



<hr>

<!-- Facilities -->
<div class="container ">
    <h4>Facilities</h4>
    
    <div class="card ">
        <div class="card-body">
            
            <div class="mb-3 mt-2  text-left">
                <div class="btn-group" role="group">
                    <div class="">
                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle" type="button" id="facilitiesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                Select Facility
                            </button>   
                            <div class="dropdown-menu" aria-labelledby="facilitiesDropdown">
                                @foreach ($facilitiesData as $facilities)
                                    <button type="button" class="dropdown-item facilities-button" onclick="populateFacilities('{{ $facilities->label }}', '{{ $facilities->key }}', '{{ $facilities->value }}', '{{ $facilities->class_icon }}'); setActiveButton(this);" data-form-type="facilities" data-class-icon="{{ $collections->class_icon }}">
                                        {{ $facilities->label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--Facilities forn -->
            <form id="updateFacilities" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="selectedKeyFacilities" name="selectedKeyFacilities">
                <input type="hidden" id="iconpickerFacilities" name="iconpickerFacilities">

                <div class="row text-left">
                    <div class="col-md-6">
                        <div class="form-group text-left">
                            <label for="">Value</label>
                            <input type="number" class="form-control" id="facilitiesValue" name="facilitiesValue" required disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Select Icon</label>
                        <br>
                        <button class="btn btn-secondary iconpicker-btn" role="iconpicker" id="iconPickerBtnFacilities" disabled></button>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm update-button" >Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

<hr>

<!-- Services -->
<div class="container ">
    <h4>Services</h4>
    
    <div class="card ">
        <div class="card-body">
            
            <div class="mb-3 mt-2  text-left">
                <div class="btn-group" role="group">
                    <div class="">
                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle" type="button" id="servicesDropdown" data-toggle="dropdown" >
                                Select Service
                            </button>   
                            <div class="dropdown-menu" aria-labelledby="servicesDropdown">
                                @foreach ($servicesData as $services)
                                    <button type="button" class="dropdown-item services-button" aria-pressed="false" onclick="populateServices('{{ $services->label }}', '{{ $services->key }}', '{{ $services->value }}', '{{ $services->class_icon}}'); setActiveButton(this);" data-form-type="services" data-class-icon="{{ $services->class_icon }}">
                                        {{ $services->label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--Services form -->
            <form id="updateServices" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="selectedKeyServices" name="selectedKeyServices">
                <input type="hidden" id="iconpickerServices" name="iconpickerServices">
                <div class="row text-left">
                    <div class="col-md-6">
                        <div class="form-group text-left">
                            <label for="">Value</label>
                            <input type="text" class="form-control" id="servicesValue" name="servicesValue" required disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Select Icon</label>
                        <br>
                        <button class="btn btn-secondary iconpicker-btn" role="iconpicker" id="iconPickerBtnServices" disabled></button>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm update-button" >Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

<hr>

<!-- Utilization -->
<div class="container ">
    <h4>Utilization</h4>

    <div class="card ">
        <div class="card-body">
            <!-- Button group utilization -->
            <div class="text-right">
                <button class="btn btn-primary btn-sm " type="button" data-toggle="modal" data-target="#addUtilizationModal"><i class="fas fa-plus"></i> Add New Data</button>
            </div>

            <div class="mb-3 mt-2  text-left">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success" id="leftButtonUtilization"><b><</b></button>
                    <div class="button-wrapper">
                        <div class="button-group-utilization button-group">
                            @foreach ($utilizationData as $utilization)
                                <button type="button" class="btn btn-outline-success utilization-button" aria-pressed="false" onclick="populateUtilization('{{ $utilization['label'] }}', '{{ $utilization['physical_value'] }}', '{{ $utilization['online_value'] }}'); setActiveButton(this);" data-form-type="utilization">
                                    {{ $utilization['label'] }}
                                </button>
                            @endforeach
                        </div>

                    </div>
                    <button type="button" class="btn btn-success" id="rightButtonUtilization"><b>></b></button>
                </div>
            </div>
            
            <!-- Update utilization data -->
            <form id="updateUtilYearForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="selectedKey" name="selectedKey">
                <div class="row ">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Physical Library Utilization</label>
                            <input type="number" class="form-control" id="physical" name="physicalValue" required disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Online Library Utilization</label>
                            <input type="number" class="form-control" id="online" name="onlineValue" required disabled>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-success update-button">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

<hr>

<!-- Satisfaction Rating -->
<div class="container ">
    <h4>Satisfaction Rating</h4>
    <div class="card ">
        <div class="card-body">
            <!-- Button group -->
            <div class="text-right">
                <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#addSatisfactionModal"><i class="fas fa-plus"></i> Add New Data</button>
            </div>
            <div class=" text-left mb-3">
                <div class="mb-3 mt-2 ">
                    <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success" id="leftButtonSatisfaction"><b><</b></button>
                        <div class="button-wrapper">
                            <div class="button-group-satisfaction button-group">
                                @foreach ($satisfactionData as $satisfaction)
                                <button type="button" class="btn btn-outline-success utilization-button" aria-pressed="false" onclick="populateSatisfaction('{{ $satisfaction->key }}', '{{ $satisfaction->value }}'); setActiveButton(this);" data-form-type="satisfaction">
                                    {{ $satisfaction->key }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="rightButtonSatisfaction"><b>></b></button>
                    </div>
                </div>
            </div>
            
            <!--satisfaction forn -->
            <form id="updateSatisYearForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="selectedKeySatisfaction" name="selectedKeySatisfaction">
                <div class="row text-left">
                    <div class="col-md-6">
                        <div class="form-group text-left">
                            <label for="">  Average Rating</label>
                            <input type="number" class="form-control" id="ratingValue" name="ratingValue" step="0.01" required disabled>

                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm update-button" >Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

<hr>

<!-- Linkages -->
<div class="container ">
    <h4>Linkages</h4>
    
    <div class="card ">
        <div class="card-body">
            
            <div class="mb-3 mt-2  text-left">
                <div class="btn-group" role="group">
                    <div class="">

                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle" type="button" id="linkagesDropdown" data-toggle="dropdown" >
                                Select Linkage
                            </button>   
                            <div class="dropdown-menu" aria-labelledby="linkagesDropdown">
                                @foreach ($linkagesData as $linkages)
                                    <button type="button" class="dropdown-item linkages-button" aria-pressed="false" onclick="populateLinkages('{{ $linkages->label }}', '{{ $linkages->key }}', '{{ $linkages->value }}'); setActiveButton(this);" data-form-type="linkages">
                                        {{ $linkages->label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--LInkages form -->
            <form id="updateLinkages" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="selectedKeyLinkages" name="selectedKeyLinkages">
                <div class="row text-left">
                    <div class="col-md-6">
                        <div class="form-group text-left">
                            <label for="">Value</label>
                            <input type="number" class="form-control" id="linkagesValue" name="linkagesValue" required disabled>

                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm update-button" >Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

<hr>

<!-- Personnel -->
<div class="container ">
    <h4>Personnel</h4>
    
    <div class="card ">
        <div class="card-body">
            
            <div class="mb-3 mt-2  text-left">
                <div class="btn-group" role="group">
                    <div class="">
                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle" type="button" id="personnelDropdown" data-toggle="dropdown" >
                                Select Service
                            </button>   
                            <div class="dropdown-menu" aria-labelledby="personnelDropdown">
                                @foreach ($personnelData as $personnel)
                                    <button type="button" class="dropdown-item personnel-button" aria-pressed="false" onclick="populatePersonnel('{{ $personnel->label }}', '{{ $personnel->key }}', '{{ $personnel->value }}', '{{ $personnel->class_icon}}'); setActiveButton(this);" data-form-type="personnel" data-class-icon="{{ $personnel->class_icon }}">
                                        {{ $personnel->label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--Personnel form -->
            <form id="updatePersonnel" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="selectedKeyPersonnel" name="selectedKeyPersonnel">
                <input type="hidden" id="iconpickerPersonnel" name="iconpickerPersonnel">
                <div class="row text-left">
                    <div class="col-md-6">
                        <div class="form-group text-left">
                            <label for="">Value</label>
                            <input type="number" class="form-control" id="personnelValue" name="personnelValue" required disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Select Icon</label>
                        <br>
                        <button class="btn btn-secondary iconpicker-btn" role="iconpicker" id="iconPickerBtnPersonnel" disabled></button>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm update-button" >Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

<hr>

</div><!-- close ng content -->

    <!-- Modal for adding utilization data -->
    <div class="modal fade" id="addUtilizationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Utilization Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body">
                <form id="addUtilYearForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input id="year" name="year" class="form-control"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                type = "number"
                                maxlength = "4"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="physicalValueModal" class="form-label">Physical Library Utilization</label>
                            <input type="number" class="form-control" id="physicalValue" name="physicalValueModal">
                        </div>
                        <div class="mb-3">
                            <label for="onlineValueModal" class="form-label">Online Library Utilization</label>
                            <input type="number" class="form-control" id="onlineValue" name="onlineValueModal">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding satisfaction data -->
    <div class="modal fade" id="addSatisfactionModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>Add Satisfaction Data</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body">
                    <form id="addSatisYearForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input id="year" name="year" class="form-control"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                type = "number"
                                maxlength = "4"
                            />                        
                        </div>
                        <div class="mb-3">
                            <label for="physicalValueModal" class="form-label">Average Rating</label>
                            <input type="number" class="form-control" id="ratingValueModal" name="ratingValueModal" step="0.01" required >              
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection 

@section('script')
<script>
$('#iconPickerBtnCollections').iconpicker({
    }).on('change', function(e) {
    $('#iconpickerCollections').val(e.icon);
});
$('#iconPickerBtnFacilities').iconpicker({
    }).on('change', function(e) {
    $('#iconpickerFacilities').val(e.icon);
});
$('#iconPickerBtnServices').iconpicker({
    }).on('change', function(e) {
    $('#iconpickerServices').val(e.icon);
});
$('#iconPickerBtnPersonnel').iconpicker({
    }).on('change', function(e) {
    $('#iconpickerPersonnel').val(e.icon);
});

function populateCollections(selectedLabelCollections, selectedKeyCollections, collectionsValue, collectionsClassIcon) {
    document.getElementById('selectedKeyCollections').value = selectedKeyCollections;
    document.getElementById('iconpickerCollections').value = collectionsClassIcon;
    document.getElementById('collectionsValue').value = collectionsValue;
    document.getElementById('iconPickerBtnCollections').innerHTML = '<i class="' + collectionsClassIcon + '"></i>';
    document.getElementById("collectionsDropdown").innerText = selectedLabelCollections;

    if (selectedKeyCollections === 'e-books' || selectedKeyCollections === 'e-theses' || selectedKeyCollections === 'e-journals') {
        fetch('/admin/dashboard/' + selectedKeyCollections)
            .then(response => response.json())
            .then(data => {
                const apiMessage = document.getElementById('apiMessage');
                const collectionValueFromAPI = parseInt(collectionsValue, 10);

                if (data.count === collectionValueFromAPI) {
                    apiMessage.innerHTML = 'Already Updated';
                    document.getElementById('collectionsEndpointMessage').style.display = 'none';
                    document.getElementById('sync-button').style.display = 'none'; 
                } else {
                    apiMessage.innerHTML = selectedLabelCollections +  ' Realtime Data from System: <span id="collectionsEndpointMessage">' + data.count + '</span>';
                    document.getElementById('collectionsEndpointMessage').style.display = 'inline';
                    document.getElementById('sync-button').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });

        document.getElementById('apiMessage').style.display = 'block';  
    } else {
        document.getElementById('apiMessage').style.display = 'none';  
        document.getElementById('sync-button').style.display = 'none';
    }
}







function populateFacilities(selectedLabelFacilities, selectedKeyFacilities, facilitiesValue, facilitiesClassIcon) {
  document.getElementById('selectedKeyFacilities').value = selectedKeyFacilities;
  document.getElementById('iconpickerCollections').value = facilitiesClassIcon;
  document.getElementById('facilitiesValue').value = facilitiesValue;
  document.getElementById('iconPickerBtnFacilities').innerHTML = '<i class="' + facilitiesClassIcon + '"></i>';
  document.getElementById("facilitiesDropdown").innerText = selectedLabelFacilities;
}

function populateServices(selectedLabelServices, selectedKeyServices, servicesValue, servicesClassIcon) {
  document.getElementById('selectedKeyServices').value = selectedKeyServices;
  document.getElementById('iconpickerServices').value = servicesClassIcon;
  document.getElementById('servicesValue').value = servicesValue;
  document.getElementById('iconPickerBtnServices').innerHTML = '<i class="' + servicesClassIcon + '"></i>';
  document.getElementById("servicesDropdown").innerText = selectedLabelServices;
}

function populateUtilization(selectedKey, physical, online) {
  document.getElementById('selectedKey').value = selectedKey;
  document.getElementById('physical').value = physical;
  document.getElementById('online').value = online;
}

function populateSatisfaction(selectedKeySatisfaction, ratingValue) {
  document.getElementById('selectedKeySatisfaction').value = selectedKeySatisfaction;
  document.getElementById('ratingValue').value = ratingValue;
}

function populateLinkages(selectedLabelLinkages, selectedKeyLinkages, linkagesValue) {
  document.getElementById('selectedKeyLinkages').value = selectedKeyLinkages;
  document.getElementById('linkagesValue').value = linkagesValue;
  document.getElementById("linkagesDropdown").innerText = selectedLabelLinkages;

}

function populatePersonnel(selectedLabelPersonnel, selectedKeyPersonnel, personnelValue, personnelClassIcon) {
  document.getElementById('selectedKeyPersonnel').value = selectedKeyPersonnel;
  document.getElementById('iconpickerPersonnel').value = personnelClassIcon;
  document.getElementById('personnelValue').value = personnelValue;
  document.getElementById('iconPickerBtnPersonnel').innerHTML = '<i class="' + personnelClassIcon + '"></i>';
  document.getElementById("personnelDropdown").innerText = selectedLabelPersonnel;

}

function setActiveButton(clickedButton) {
    const buttons = document.querySelectorAll('.btn-group .btn-outline-success');

    buttons.forEach(button => {
        button.setAttribute('aria-pressed', 'false');
    });

    clickedButton.setAttribute('aria-pressed', 'true');
    const formType = clickedButton.getAttribute('data-form-type');

    if (formType === 'utilization') {
        document.getElementById('physical').disabled = false;
        document.getElementById('online').disabled = false;
    } else if (formType === 'satisfaction') {
        document.getElementById('ratingValue').disabled = false;
    } else if (formType === 'collections') {
        document.getElementById('collectionsValue').disabled = false;
        document.getElementById('iconPickerBtnCollections').disabled = false;

    } else if (formType === 'facilities') {
        document.getElementById('facilitiesValue').disabled = false;
        document.getElementById('iconPickerBtnFacilities').disabled = false;
    } else if (formType === 'services') {
        document.getElementById('servicesValue').disabled = false;
        document.getElementById('iconPickerBtnServices').disabled = false;
    } else if (formType === 'linkages') {
        document.getElementById('linkagesValue').disabled = false;
    } else if (formType === 'personnel') {
        document.getElementById('personnelValue').disabled = false;
        document.getElementById('iconPickerBtnPersonnel').disabled = false;

    }
}


const handleSliding = (groupSelector, leftButtonId, rightButtonId, buttonWidth, buttonsToShow) => {
  const leftButton = document.getElementById(leftButtonId);
  const rightButton = document.getElementById(rightButtonId);
  const buttonGroup = document.querySelector(groupSelector);
  const buttonCount = buttonGroup.childElementCount;
  let currentPosition = 0;
  const maxSlide = -(buttonCount - buttonsToShow) * buttonWidth;

  if (buttonCount <= buttonsToShow) {
    leftButton.disabled = true;
    rightButton.disabled = true;
    return;
  }

  leftButton.addEventListener('click', () => {
    currentPosition = Math.min(currentPosition + buttonWidth, 0);
    buttonGroup.style.transform = `translateX(${currentPosition}px)`;
    rightButton.disabled = currentPosition === maxSlide;
    leftButton.disabled = currentPosition === 0;
  });

  rightButton.addEventListener('click', () => {
    currentPosition = Math.max(currentPosition - buttonWidth, maxSlide);
    buttonGroup.style.transform = `translateX(${currentPosition}px)`;
    rightButton.disabled = currentPosition === maxSlide;
    leftButton.disabled = currentPosition === 0;
  });

  leftButton.disabled = currentPosition === 0;
  rightButton.disabled = currentPosition === maxSlide;
};

const initializeSliding = () => {
  const screenWidth = window.innerWidth;
  
  if (screenWidth <= 480) {
    // Mobile
    handleSliding('.button-group-utilization', 'leftButtonUtilization', 'rightButtonUtilization', 60, 3);
    handleSliding('.button-group-satisfaction', 'leftButtonSatisfaction', 'rightButtonSatisfaction', 60, 3);
  } else if (screenWidth <= 768) {
    // Tablet
    handleSliding('.button-group-utilization', 'leftButtonUtilization', 'rightButtonUtilization', 75, 4);
    handleSliding('.button-group-satisfaction', 'leftButtonSatisfaction', 'rightButtonSatisfaction', 75, 4);
  } else {
    // Desktop
    handleSliding('.button-group-utilization', 'leftButtonUtilization', 'rightButtonUtilization', 62, 5);
    handleSliding('.button-group-satisfaction', 'leftButtonSatisfaction', 'rightButtonSatisfaction', 62, 5);
  }
};

window.addEventListener('resize', initializeSliding);
initializeSliding();



$(document).ready(function() {
    function handleFormSubmit(formId, ajaxUrl) {
        $(formId).on('submit', function(event) {
            event.preventDefault();
            
            const button = $(this).find('button[type="submit"]');
            button.prop('disabled', true);
            
            $.ajax({
                url: ajaxUrl,
                method: 'POST',
                data: $(formId).serialize(),
                dataType: 'json',
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then(() => {
                        location.reload(); 
                    });
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'An error occurred',
                    }).then(() => {
                        button.prop('disabled', false);
                    });
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });
    }

    $('.sync-button').on('click', function() {
    const value = $('#collectionsEndpointMessage').text().trim();
        $('#collectionsValue').val(value);
        $('#updateCollections').submit();
    });


    handleFormSubmit('#addUtilYearForm', '/admin/dashboard/addUtilizationYear');
    handleFormSubmit('#addSatisYearForm', '/admin/dashboard/addSatisfactionYear');
    handleFormSubmit('#updateUtilYearForm', '/admin/dashboard/updateUtilizationYear');
    handleFormSubmit('#updateSatisYearForm', '/admin/dashboard/updateSatisfactionYear');
    handleFormSubmit('#updateCollections', '/admin/dashboard/updateCollections');
    handleFormSubmit('#updateFacilities', '/admin/dashboard/updateFacilities');
    handleFormSubmit('#updateServices', '/admin/dashboard/updateServices');
    handleFormSubmit('#updateLinkages', '/admin/dashboard/updateLinkages');
    handleFormSubmit('#updatePersonnel', '/admin/dashboard/updatePersonnel');





});

</script>
@endsection 
