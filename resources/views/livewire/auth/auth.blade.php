<div class="container" dir="rtl">
    <div class="row">
        <div class="col-lg-10 mx-auto text-center my-5">
            <div class="card shadow color">
                <div class="card-body d-flex justify-content-around">
                    <button wire:click='changeTheAction("login")' class="btn btn-light px-3 bg fw-bold">تسجيل الدخول</button>
                    <button wire:click='changeTheAction("customer login")' class="btn color px-3 fw-bold">تسجيل الدخول عميل</button>
                    <button wire:click='changeTheAction("customer register")' class="btn color px-3 fw-bold">انشاء حساب عميل</button>
                </div>
            </div>
        </div>
        <div class="col-lg-7 mx-auto ">
            <x-auth.login></x-auth.login>
        </div>
    </div>
    {{-- The whole world belongs to you. --}}
</div>

