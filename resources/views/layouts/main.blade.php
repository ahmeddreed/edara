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
  </head>

  <body class="@if(request()->routeIs("login") || request()->routeIs("customerLogin") || request()->routeIs("CustomerRegister")) bg @endif">
    <!-- Start your project here-->
        <!-- navbar conbonent-->

    @if(!request()->routeIs("login") || !request()->routeIs("customerLogin") || !request()->routeIs("CustomerRegister"))

        <x-Main.navbar></x-Main.navbar>
        @if(request()->routeIs("home"))

            <x-Main.hero></x-Main.hero>
        @endif

    @endif


    @yield("content")

    <div class="container mx-auto mt-5">
        {{ $slot }}
    </div>

    <br>
        <x-Main.footer></x-Main.footer>
    <!-- End your project here-->
    <script src="{{ asset("js/bootstrap.bundle.js") }}"></script>
</body>

</html>
