@props(['title'=>"tilte"])


<nav class="navbar navbar-expand-lg bg p-3 fs-5 fw-bold">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-blockquote-right text-light"></i>
      </button>
      <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fs-5">
            @if(!request()->routeIs("home"))
                <li class="nav-item">
                    <a wire:navigate class="nav-link active text-light fw-bold " aria-current="page" href="{{ route("home") }}">صفحة الرائسية</a>
                </li>
            @endif
            @auth
                <li class="nav-item dropdown">
                    <a wire:navigate class="nav-link text-light fw-bold" href="{{ route("dashboard") }}">لوحة التحكم</a>
                </li>

                <li class="nav-item">
                    <a wire:navigate class="nav-link text-light fw-bold" href="{{ route("customerLogout") }}">تسجيل الخروج</a>
                </li>
            @endauth
            @guest
                @if (session()->has("customer") == null)
                    <li class="nav-item">
                        <a wire:navigate class="nav-link active text-light fw-bold " aria-current="page" href="{{ route("login") }}">دخول الدخول</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a wire:navigate class="nav-link text-light fw-bold" href="{{ route("customerLogout") }}">تسجيل الخروج</a>
                    </li>
                    @if(!request()->routeIs("profile"))
                        <li class="nav-item">
                            <a wire:navigate class="nav-link text-light fw-bold" href="{{ route("customer-profile") }}">الملف الشخصي</a>
                        </li>
                    @endif
                @endif
            @endguest


        </ul>

        <div class="d-flex">
          <span class="text-light fs-3 fw-bold">{{ $title }}</span>
        </div>
      </div>
    </div>
  </nav>
