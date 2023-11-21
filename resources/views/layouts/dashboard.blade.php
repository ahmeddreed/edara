<!DOCTYPE html>
<html lang="en" class="dark">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Tailwind elements</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Tailwind Elements CSS -->
    <link rel="stylesheet" href="{{ asset("css/style.css") }}" />
    <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}" />
    <!-- Custom styles -->
    <style>
        .bg{
            background: #0097B2;
            color: #f6f6f7;
        }


        .color{
            color: #0097B2;
        }

    </style>

    @livewireStyles
  </head>

  <body dir="rtl" class="@if(!request()->routeIs("dashboard")) bg pt-5 @endif">

    <div class="container mt-5">
        {{ $slot }}
    </div>

    <br>
    @livewireScripts
    <!-- End your project here-->
    <script src="{{ asset("js/bootstrap.bundle.js") }}"></script>

</body>

</html>
