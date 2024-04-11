<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name') }}</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <link rel="x icon" type="img/png" href="images/CvSU-logo-16x16.webp">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .hoverable-button {
                transition: background-color 0.3s ease, transform 0.3s ease; 
            }
            .hoverable-button:hover {
                background-color: #003618;
                transform: scale(1.05);     
            }
            .shadow { 
                box-shadow: 0px 2px 10px 2px rgba(0, 0, 0, 0.2);
            }
        </style>
    </head>
    <body>
        @yield('content')
    </body>
</html>