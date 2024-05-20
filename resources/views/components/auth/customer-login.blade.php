
<div class="card shadow color">
    <div class="card-body">
        <h4 class="fw-bold text-center">
                 تسجيل الدخول العميل
        </h4>
        <form action="" wire:submit.prevent='customerLogin' method="post" class="container my-5">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">الاسم</label>
                <input type="text" wire:model='name' class="form-control" id="exampleFormControlInput1" placeholder=" ادخل الاسم">
                <small class="text-danger">@error('name') {{ $message }} @enderror</small>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">رقم الهاتف</label>
                <input type="number"  wire:model='phone' class="form-control" id="exampleFormControlInput1" placeholder=" ادخل  الهاتف">
                <small class="text-danger">@error('phone') {{ $message }} @enderror</small>
            </div>

            <div class="my-4 d-flex justify-content-between">
                <button type="submit" class="btn bg fs-5">تسجيل</button>
                <a href="{{ route("home") }}" class="btn bg fs-5">الصفحة الرائسية</a>
            </div>
        </form>
    </div>
</div>
