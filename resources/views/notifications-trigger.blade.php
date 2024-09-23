@extends('layouts.admin')

@section('main-content-header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">NOTIFICATION SAMPLE</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Notif Sample</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>
@endsection 


@section('main-content')
<div class="container ml-3">
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>

  <div class="row">
    <div class="col-6 flex p-2 border border-2 border-dark">
      <!-- BUTTON FOR THESIS SUBMISSION -->
      <h4>THESIS SUBMISSION</h4>
      <button class="btn btn-success" id="thesis_submission"><i class="fas fa-hand-point-up m-1"></i> CLICK HERE</button>
    </div>

    <div class="col-6 border border-2 border-dark">
      <!-- BUTTON FOR RESERVATION -->
      <h4>RESERVATION</h4>
      <form id="reservationForm">
        @csrf
      <button class="btn btn-primary" id="reservation_request"><i class="fas fa-hand-point-up m-1"></i>CLICK HERE</button>
      </form>
    </div>
    
    <div class="col-6 border border-2 border-dark">
      <!-- BUTTON FOR APPROVED THESIS -->
      <h4>APPROVED THESIS</h4>
      <button class="btn btn-warning" id="thesis_approved"><i class="fas fa-hand-point-up m-1"></i>CLICK HERE</button>
    </div>

    <div class="col-6 border border-2 border-dark">
      <!-- BUTTON FOR APPROVED THESIS -->
      <h4>APPROVED RESERVATION</h4>
      <button class="btn btn-warning" id="reservation_approved"><i class="fas fa-hand-point-up m-1"></i>CLICK HERE</button>
    </div>


    <div class="col-6 border border-2 border-dark">
      <!-- BUTTON FOR APPROVED THESIS -->
      <h4>DECLINE THESIS</h4>
      <button class="btn btn-danger" id="thesis_rejected"><i class="fas fa-hand-point-up m-1"></i>CLICK HERE</button>
    </div>

    <div class="col-6 border border-2 border-dark">
      <!-- BUTTON FOR APPROVED THESIS -->
      <h4>DECLINE RESERVATION</h4>
      <button class="btn btn-danger" id="reservation_rejected"><i class="fas fa-hand-point-up m-1"></i>CLICK HERE</button>
    </div>


  </div>
</div>

@endsection

@section('script')
<script>
  //TRIGGER
  $(document).ready(function() {
      $('#thesis_submission').click(function() {
        event.preventDefault(); 
          triggerNotification('3', 'Someone submitted their thesis');
      });

      $('#reservation_request').click(function() {
        event.preventDefault(); // Prevent the default form submission
          triggerNotification('2', 'New Reservation Request');
      });

      $('#thesis_approved').click(function() {
        event.preventDefault(); 
          triggerNotification('1', 'Thesis Approved');
      });

      $('#thesis_rejected').click(function() {
        event.preventDefault(); 
          triggerNotification('5', 'Thesis Rejected');
      });

      $('#reservation_approved').click(function() {
        event.preventDefault(); 
          triggerNotification('4', 'Reservation Approved');
      });

      $('#reservation_rejected').click(function() {
        event.preventDefault(); 
          triggerNotification('6', 'Reservation unavailable');
      });
  });

  //SEND
  function triggerNotification(type, message) {
    $.ajax({
      url: "send-notification",
      method: "POST",
      data: { 
          "_token": "{{ csrf_token() }}",
          type: type, 
          message: message
      },
      success: function(response) {
          console.log('Notification sent successfully!');
          updateBadgeCount();
      },
      error: function(xhr, status, error) {
          console.error('Failed to send notification.');
      }
    });
  }
</script>

<script>
  var notificationsWrapper = $('li.notif');
  var notificationsToggle = notificationsWrapper.find('#read');
  
  const bell = document.querySelector('#bell');

  updateBadgeCount();


  //RETRIEVE NOTIFICATIONS
  function updateBadgeCount() {
      $.get("{{ route('admin.NotifCount') }}",function (data){
        notificationsCount = data.count;   
          updateNotifications(data.notifications);
          if (notificationsCount <= 0) {
              bell.style.display = "none";
            }else{
              console.log("test");
              bell.style.display = "inline-block";
              $('span.navbar-badge').text(data.count);
            }
      });
  }

  //FUNCTION FOR RETRIEVING MESSAGE
  function updateNotifications(notifications) {  
      var container = notificationsWrapper.find('.contain');
      container.empty();

      notifications.forEach(function(notification) {
          var html = '';
          var iconClass = getIconClass(notification.notifications_type_id);
          var timeAgoText = moment(notification.created_at).fromNow();
          html += '<a href="#" class="dropdown-item">' +
              '<div class="media">' +
              '<i class="' + iconClass + '" style="font-size: 20px"></i>' +
              '<div class="media-body">' +
              '<span>' + notification.message + '</span><br>' +
              '<span class="text-sm text-muted">' + timeAgoText + '</span>' +
              '</div>' +
              '</div>' +
              '</a>' +
              ' <div class="dropdown-divider notiffooter"></div>';
          container.append(html);
      });    
  }

  //GET ICON
  function getIconClass(type) {
      switch (type) {
        case 1: // Thesis Approved
        case 3: // Thesis Submission
        case 5: // Thesis Rejected
            return 'fas fa-book text-success align-self-center mr-2';
        case 2: // Reservation
        case 4: // Reservation Approved
        case 6: // Reservation Rejected
            return 'fas fa-calendar-check text-warning align-self-center mr-2';
        default:
            return '';
      }
  }

  //PUSHER
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('cac33588bfe1e9b1f7c1', {
    encrypted: true,
    cluster: 'ap1',
  });

  var channel = pusher.subscribe('my-channel');
  channel.bind('pusher:subscription_succeeded', function() {
    console.log('Subscription to my-channel succeeded');
  });
  channel.bind('my-event', function(data) {
    try {
      // Handle the event data here
      updateBadgeCount()
      console.log('Received event:', data);
    } catch (error) {
      // Handle any errors that occur
      console.error('Error handling event:', error);
    }
  });
  //BELL CLICK
  notificationsToggle.on('click', function () {
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.post("{{ route('admin.NotifRead') }}", function () {
          notificationsCount = 0;
          notificationsToggle.find('#bell').hide();
      });
    });

  //Add event listener to "View All" link
  notificationsWrapper.find('a.dropdown-footer').on('click', function (e) {
        e.preventDefault();
        fetchAllNotifications();
    });

  function fetchAllNotifications(){
    $.get("{{ route('admin.NotifAll') }}",function(data){
      var container = notificationsWrapper.find('.contain');
    // Clear existing notifications
    container.empty();    
    var html = '';
      data.forEach(function(notifications){
        console.log(notifications.id);
        var iconClass = getIconClass(notifications.notifications_type_id);
        var timeAgoText = moment(notifications.created_at).fromNow();
        html += '<a href="#" class="dropdown-item">' +
            '<div class="media">' +
            '<i class="' + iconClass + '" style="font-size: 20px"></i>' +
            '<div class="media-body">' +
            '<span>' + notifications.message + '</span><br>' +
            '<span class="text-sm text-muted">' + timeAgoText + '</span>' + // Replace with actual message
            '</div>' +
            '</div>' +
            '</a>' +
            ' <div class="dropdown-divider notiffooter"></div>';
        container.append(html);
       });
    });
  }
  notificationsWrapper.find('a.dropdown-footer').on('click', function (e) {
        e.preventDefault(); 
        fetchAllNotifications();
        e.stopPropagation();
    });

    

</script>
@endsection