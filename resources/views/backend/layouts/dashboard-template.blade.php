<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    @yield('vite-resource')
    <title>@yield('page-title')</title>
</head>
<body>
    <section>
        <div class="side-nav">
            @include('commonComponents.side-nav')
        </div>
        <div class="side-container">
            @include('commonComponents.bread-crumb')
            <div class="content-container">
                @yield('content')
            </div>
        </div>
    </section>
</body>
</html>