<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CK Editor for rich text -->
        <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">

        <!-- Custom admin styles -->
        <link rel="stylesheet" href="{{asset('css/toast.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        
        <title>@yield('titleBar')</title>
    </head>

    <body>
        @include('client.partials.toast')

        @include('client.partials.header')

        <main class="container pt-5" style="min-height: 100vh;">
            @yield('content')
        </main>

        @include('client.partials.footer')

        <script src="{{asset('js/script.js')}}"></script>
    </body>

</html>
