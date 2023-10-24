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

  <body class="bg container">
    <!-- Start your project here-->
        <!-- navbar conbonent-->



    @yield("content")

    <div class="row">
        <div class="col-lg-10 mx-auto text-center my-5">
            <div class="card shadow color">
                <div class="card-body d-flex justify-content-around">
                    <a href="{{ route("customerLogin") }}" class="btn btn-light px-3 @if(request()->routeIs("customerLogin")) bg @else color  @endif fw-bold">تسجيل الدخول</a>
                    <a href="{{ route("customerLogin") }}" class="btn btn-light px-3  @if(request()->routeIs("customerLogin")) bg @else color  @endif fw-bold">تسجيل الدخول عميل</a>
                    <a href="{{ route("customerRegister") }}" class="btn btn-light @if(request()->routeIs("customerRegister")) bg @else color  @endif px-3 fw-bold">انشاء حساب عميل</a>
                </div>
            </div>
        </div>

        <div dir="rtl" class="col-lg-8 mx-auto my-5">

            <div class="container mx-auto">
                {{ $slot }}
            </div>
        </div>

    </div>




        <x-Main.footer></x-Main.footer>
    <!-- End your project here-->
    <script src="{{ asset("js/bootstrap.bundle.js") }}"></script>
</body>

</html>
