<nav class="navbar navbar-expand-lg bg p-3">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-blockquote-right text-light"></i>
      </button>
      <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-light fw-bold " aria-current="page" href="{{ route("Authentication") }}">تسجيل الدخول</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="{{ route("profile") }}">الملف الشخصي</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="#">لوحة التحكم</a>
          </li>
        </ul>
        <div class="d-flex">
          <span class="text-light fs-4 fw-bold">السند</span>
        </div>
      </div>
    </div>
  </nav>
