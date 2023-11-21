
<div class="container">
    <div class="row">

        <div class="col-10 mx-auto text-light">
            @if(session()->has("msg_s"))
                <div class="alert alert-success text-center text-light" role="alert">
                    {{ session()->get("msg_s") }}
                </div>
            @elseif(session()->has("msg_e"))
                <div class="alert alert-danger text-center text-light" role="alert">
                    {{ session()->get("msg_e") }}
                </div>
            @endif

        </div>

        <div class="col-10 mx-auto">
            <h3 class="text-end text-light mb-5">الملف الشخصي</h3>
        </div>

        @if($show == "profile")
            <div class="col-8 mx-auto mb-5">
                <div class="card card-body">
                    <div class="card-body">

                    </div>
                </div>
            </div>

        @elseif($show == "update")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center">تعديل البيانات</h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" wire:submit.prevent='create' action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم الصلاحيه :</label>
                                <input type="text" name="name" wire:model='name' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('name') {{ $message }} @enderror</small>
                            </div>
                            <button type="submit" class="btn btn-primary fs-5 col-8 mx-auto">تغيير</button>
                            <button type="button" wire:click='cancel' class="btn btn-secondary fs-5 col-8 mx-auto">الغاء</button>
                        </form>
                    </div>
                </div>
            </div>



        @elseif($show == "password")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center">تغيير الرمز</h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" wire:submit.prevent='create' action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم الصلاحيه :</label>
                                <input type="text" name="name" wire:model='name' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('name') {{ $message }} @enderror</small>
                            </div>
                            <div class="col-8 mx-auto">
                                <button type="submit" class="btn btn-primary fs-5 col-8 mx-auto">تغيير</button>
                            <button type="button" wire:click='cancel' class="btn btn-secondary fs-5 col-8 mx-auto">الغاء</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


        @endif
    </div>
</div>
