<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


    
@if($sanctionAccom && $sanctionAccom->remarks == 1 && $sanctionAccom->violation_type == 'Accomplishment' && is_null($sanctionAccom->dateEnded))
    <center>
        <h4>CvSU - MAIN CAMPUS LIBRARY</h4>
        <h2>QUICK LOG RECEIPT</h2>
        <h4>============================</h4>
        <h5>Card Number: {{ $sanctionAccom->card_number }}</h5>
        <h5>Accomplishment Incomplete</h5>
        <h5>Welcome to CvSU Library</h5>
    </center>
@elseif($sanctionAccom && $sanctionAccom->remarks == 0 && $sanctionAccom->violation_type == 'Accomplishment' && is_null($sanctionAccom->dateEnded))
    <center>
        <h4>CvSU - MAIN CAMPUS LIBRARY</h4>
        <h2>QUICK LOG RECEIPT</h2>
        <h4>============================</h4>
        <h5>Card Number: {{ $sanctionAccom->card_number }}</h5>
        <h5>Welcome to CvSU Library</h5>
    </center>
@elseif(is_null($sanctionAccom->dateEnded) || $sanctionAccom->dateEnded > $today)
    <center>
        <h4>CvSU - MAIN CAMPUS LIBRARY</h4>
        <h2>QUICK LOG RECEIPT</h2>
        <h4>============================</h4>
        <h5>Card Number: {{ $sanctionAccom->card_number }}</h5>
        <h5>BANNED until {{ $sanctionAccom->dateEnded }}</h5>
        <h5>Welcome to CvSU Library</h5>
    </center>
@else
    <center>
        <h4>CvSU - MAIN CAMPUS LIBRARY</h4>
        <h2>QUICK LOG RECEIPT</h2>
        <h4>============================</h4>
        <h5>Card Number: {{ $sanctionAccom->card_number }}</h5>
        <h5>Welcome to CvSU Library</h5>
    </center>
@endif


</body>
</html>