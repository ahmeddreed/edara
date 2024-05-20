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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset("css/style.css") }}" />
    <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}" />

    <!-- Custom styles -->
    <style>
        @import url(https://fonts.googleapis.com/earlyaccess/scheherazade.css);
        body {
        background: #eee;
        font-family: 'Scheherazade', serif;
        font: 1.5em sans-serif;
        }

        .swiper {
        width: 100%;
        height: 100%;
        }

        .swiper-slide {
        text-align: start;
        font-size: 18px;
        background: #fff;
        }

        .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit:cover;
        }

        .bg{
            background: #8736EE;
            color: #f6f6f7;
        }


        .color{
            color: #8736EE;
        }


        body{
            background-color: #efeff6;
        }

    </style>

    @livewireStyles
  </head>

    @php
        $settingsData = DB::table('settings')->find(1);
    @endphp

  <body class="@if(request()->routeIs("login") || request()->routeIs("customerLogin") || request()->routeIs("CustomerRegister")) bg @endif">
    <!-- Start your project here-->
        <!-- navbar conbonent-->

    @if(!request()->routeIs("login") || !request()->routeIs("customerLogin") || !request()->routeIs("CustomerRegister"))

        <x-Main.navbar :title='$settingsData->title'></x-Main.navbar>
        @if(request()->routeIs("home"))

            <x-Main.hero :title='$settingsData->title' :des='$settingsData->des'></x-Main.hero>
        @endif

    @endif


    @yield("content")

    <div class="container mx-auto mt-5">
        {{ $slot }}
    </div>

    <br>
        <x-Main.footer :copy_right='$settingsData->copy_right'></x-Main.footer>
        <script src="{{ asset("js/swiper.js") }}"></script>
    <!-- End your project here-->
    <script src="{{ asset("js/bootstrap.bundle.js") }}"></script>



    <!-- Initialize Swiper -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> --}}
    <script>
        var swiper = new Swiper(".mySwiper", {
          slidesPerView: 1.5,
          spaceBetween: 10,
          freeMode: true,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          breakpoints: {
            500: {
              slidesPerView: 1.5,
              spaceBetween: 10,
            },
            580: {
              slidesPerView: 2.5,
              spaceBetween: 10,
            },
            768: {
              slidesPerView: 3,
              spaceBetween: 10,
            },
            1024: {
              slidesPerView: 4,
              spaceBetween: 10,
            },
          },
        });


        var swiper2 = new Swiper(".mySwiper2", {
          slidesPerView: 8,
          spaceBetween: 10,
          freeMode: true,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          breakpoints: {
            500: {
              slidesPerView: 5.5,
              spaceBetween: 10,
            },
            580: {
              slidesPerView: 6.5,
              spaceBetween: 10,
            },
            768: {
              slidesPerView: 7.5,
              spaceBetween: 10,
            },
            1024: {
              slidesPerView: 8.5,
              spaceBetween: 10,
            },
          },
        });
      </script>
@livewireScripts
</body>

</html>
