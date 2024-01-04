<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <title>Dashboard-Login</title>
    
    @vite(['resources/css/admin-login.css'])

</head>
<body>
    <section class="main-section">
        <div class="form-banner">
            <div class="img-place">
                <img class="image" src="{{ URL('images/authenticate.jpg') }}" alt="Authenticate" srcset="">
            </div>
            @yield('content')
        </div>
    </section>
</body>
</html>