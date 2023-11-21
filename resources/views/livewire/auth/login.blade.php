<div class="container">

    @if(session()->has("msg_s"))
        <div class="alert alert-success text-center color" role="alert">
            {{ session()->get("msg_s") }}
        </div>
    @elseif(session()->has("msg_e"))
        <div class="alert alert-danger text-center text-light" role="alert">
            {{ session()->get("msg_e") }}
        </div>
    @endif

    <div class="card shadow color">
        <div class="card-body">
            <h4 class="fw-bold text-center">
                تسجيل دخول الموظفين
            </h4>
            <form action="" wire:submit.prevent='login' method="post" class="container my-5">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">الايميل</label>
                    <input type="email" wire:model='email' class="form-control" id="exampleFormControlInput1" placeholder=" ادخل الايميل">
                    <small class="text-danger">@error('email') {{ $message }} @enderror</small>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">رمز السري</label>
                    <input type="password"  wire:model='password' class="form-control" id="exampleFormControlInput1" placeholder=" ادخل  رمز السري">
                    <small class="text-danger">@error('password') {{ $message }} @enderror</small>
                </div>

                <div class="my-4 d-flex justify-content-between">
                    <button type="submit" class="btn bg ">تسجيل</button>
                    <a href="{{ route("home") }}" class="btn bg">الصفحة الرائسية</a>
                </div>
            </form>
        </div>
    </div>
</div>
