<div class="container">
    <div class="row">

        <div class="col-10 mx-auto text-light">
            @if(session()->has("msg_s"))
                <div class="alert alert-success text-center color" role="alert">
                    {{ session()->get("msg_s") }}
                </div>
            @elseif(session()->has("msg_e"))
                <div class="alert alert-danger text-center color" role="alert">
                    {{ session()->get("msg_e") }}
                </div>
            @endif

        </div>

        <div class="col-10 mx-auto">
            <h3 class="text-end text-light mb-5">الملف الشخصي</h3>
        </div>

        @if($show == "profile")
            <div class="col-10 mx-auto mb-5">
                <div class="card card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-ms-8 ">
                                <img style="width: 18rem;height: 18rem;" src="{{ asset("img/dash/staff.png") }}" alt="">

                                <div class="my-5">
                                    <a wire:click='showChange("update")' class="btn btn-primary fs-5 d-block my-3">تعديل البيانات </a>
                                    <a wire:click='showChange("password")' class="btn btn-info fs-5 d-block my-3 text-light">تغيير الرمز</a>
                                    <a href="{{ route("dashboard") }}" class="btn btn-info fs-5 d-block text-light">الرجوع</a>
                                </div>
                            </div>
                            <div class="col-lg-8 col-ms-8 color p-5">
                                <h3 class="text-end mb-5">بياناتي</h3>
                                <p class=""><span>الاسم</span>: <span> {{ auth()->user()->name }} </span></p>
                                <p class=""><span>الايميل</span>: <span> {{ auth()->user()->email }} </span></p>
                                <p class=""><span>الراتب</span>: <span>{{ auth()->user()->salary }}$</span></p>
                                <p class=""><span>الجنس</span>: <span>{{ auth()->user()->gender }}</span></p>
                                <p class=""><span>الوظيفة</span>: <span> {{ auth()->user()->role()->name }}</span></p>
                                <p class=""><span>استلام الراتب</span>: <span class="text-success"> مستلم</span></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        @elseif($show == "update")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center">تعديل البيانات</h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" wire:submit.prevent='update' action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">الاسم  :</label>
                                <input type="text" name="name" wire:model='name' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('name') {{ $message }} @enderror</small>
                            </div>
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> الايميل :</label>
                                <input wire:model='email' type="text" name="email"  class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('email') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> الجنس :</label>
                                <select wire:model='gender' class="form-select" aria-label="Default select example">
                                    @if($gender == "male")
                                        <option value="ذكر">ذكر</option>
                                        <option value="انثى">انثى</option>
                                    @else
                                        <option value="2">انثى</option>
                                        <option value="ذكر">ذكر</option>
                                    @endif
                                </select>
                                <small class="text-danger">@error('gender') {{ $message }} @enderror</small>
                            </div>
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">الصورة الشخصية :</label>
                                <input type="file" name="image" wire:model='image' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('image') {{ $message }} @enderror</small>
                            </div>
                            <button type="submit" class="btn btn-primary fs-5 col-8 mx-auto">تغيير</button>
                            <button type="button" wire:click='cancel' class="btn btn-secondary fs-5 col-8 mx-auto">الغاء</button>
                        </form>
                    </div>
                </div>
            </div>



        @elseif($show == "password")
            <div class="col-8 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center">تغيير الرمز</h5>
                    <div class="card-body color">
                        <form class="row g-3 mb-5" wire:submit.prevent='changePassword' action="" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                  <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الرمز السري القديم</label>
                                    <input name="password" wire:model='password' type="password"  class="form-control  @error('password') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="الرمز السري">
                                    @error('password')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                  <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الرمز السري الجديد</label>
                                    <input name="passwordNew" wire:model='passwordNew' type="password" class="form-control  @error('passwordNew') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="الرمز السري">
                                    @error('passwordNew')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                  <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">اعادة كتابة الرمز السري</label>
                                    <input name="c_passwordNew" wire:model='c_passwordNew' type="password" class="form-control @error('c_passwordNew') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="اعادة كتابة الرمز السري">
                                    @error('c_passwordNew')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>

                                <div class="col-12 text-center">
                                    <button class="btn btn-primary fs-5 fw-bold col-10 my-3" type="submit"> تغيير </button>
                                    <button wire:click='cancel' class="btn btn-secondary col-10 fs-5 fw-bold my-3"> الغاء </button>
                                </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>


        @endif
    </div>
</div>
