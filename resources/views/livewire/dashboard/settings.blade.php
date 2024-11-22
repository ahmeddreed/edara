<div class="container">
    <div class="row">

        <div class="col-10 mx-auto color">
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

        <div class="col-10 mx-auto mb-5">
            <div class="card mx-auto">
                <h3 class="my-4 color fw-bold text-center">الاعدادات</h3>
                <div class="card-body">
                    <form class="row g-3 mb-5" wire:submit.prevent='update'>
                        @csrf
                        <div class="col-8 mx-auto">
                            <label for="exampleFormControlInput1" class=" fs-5 form-label color">اسم النظام:</label>
                            <input type="text" name="title" wire:model='title' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم مادة " />
                            <small class="text-danger">@error('title') {{ $message }} @enderror</small>
                        </div>


                        <div class="col-8 mx-auto">
                            <label for="exampleFormControlInput1" class=" fs-5 form-label color"> الوصف النظام:</label>
                            <textarea name="des" class="form-control g-3 in-valid" wire:model='des'>{{  $des }}</textarea>
                            <small class="text-danger">@error('des') {{ $message }} @enderror</small>
                        </div>


                        <div class="col-8 mx-auto">
                            <label for="exampleFormControlInput1" class=" fs-5 form-label color">صورة النظام :</label>
                            <input type="file" name="img" wire:model='img' class="form-control g-3 in-valid" id="exampleFormControlInput1" />
                            <small class="text-danger">@error('img') {{ $message }} @enderror</small>
                        </div>


                        <div class="col-8 mx-auto">
                            <label for="exampleFormControlInput1" class=" fs-5 form-label color">العلامة التجارية :</label>
                            <input type="text" name="copy_right" wire:model='copy_right' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل الملاحظة مادة " />
                            <small class="text-danger">@error('copy_right') {{ $message }} @enderror</small>
                        </div>

                        <div class="col-8 mx-auto">
                            <label for="exampleFormControlInput1" class=" fs-5 form-label color"> الرقم التواصل الاول:</label>
                            <input type="number" name="phone1" wire:model='phone1' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="رقم التواصل الاول" />
                            <small class="text-danger">@error('phone1') {{ $message }} @enderror</small>
                        </div>

                        <div class="col-8 mx-auto">
                            <label for="exampleFormControlInput1" class=" fs-5 form-label color"> الرقم التواصل الثاني:</label>
                            <input type="number" name="phone2" wire:model='phone2' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="رقم التواصل الثاني " />
                            <small class="text-danger">@error('phone2') {{ $message }} @enderror</small>
                        </div>

                        <div class="col-8 mx-auto p-3">
                            <button @if($new_img ==null and $old_img ==null) @disabled(true) @endif type="submit" class="btn bg fs-5  mx-auto">تعديل</button>
                            <a href="{{ route("dashboard") }}" class="btn btn-secondary fs-5  mx-auto">رجوع</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="col-10 mx-auto color">
            @if(session()->has("ads_msg_s"))
                <div class="alert alert-success text-center color" role="alert">
                    {{ session()->get("ads_msg_s") }}
                </div>
            @elseif(session()->has("ads_msg_e"))
                <div class="alert alert-danger text-center color" role="alert">
                    {{ session()->get("ads_msg_e") }}
                </div>
            @endif

        </div>


        <div class="col-10 mx-auto mb-5">
            <div class="card mx-auto">
                <h3 class="my-4 color fw-bold text-center">صورة الاعلانات</h3>
                <div class="card-body">
                    <form action="" class="mb-3" wire:submit.prevent='addAds'>

                        <div class="row mb-3">

                            <div class="col-8 mx-auto my-3 ">
                                <label for="exampleFormControlInput1" class=" fs-5 form-label color">عنوان الاعلان:</label>
                                <input type="text" name="title_ads" wire:model='title_ads' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل عنوان الاعلان " />
                                <small class="text-danger">@error('title_ads') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto my-3">
                                <label for="exampleFormControlInput1" class=" fs-5 form-label color"> الوصف الاعلان:</label>
                                <textarea name="des_ads" class="form-control g-3 in-valid" wire:model='des_ads'>{{  $des_ads }}</textarea>
                                <small class="text-danger">@error('des_ads') {{ $message }} @enderror</small>
                            </div>
                            <div class="col-8 mx-auto my-3">
                                <label for="exampleFormControlInput1" class=" fs-5 form-label color">صورة الاعلان:</label>
                                <input type="file" name="image_ads" wire:model='image_ads' class="form-control g-3 in-valid" />
                                <small class="text-danger">@error('image_ads') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto p-3">
                                <button type="submit" class="btn bg fs-5  mx-auto">اضافة</button>
                            </div>
                        </div>

                    </form>
                    @if ($ads->count() > 0)
                        <div class="row">

                            @foreach($ads as $item)

                                <div class="col-lg-4 col-md-6 col-sm-10">
                                    <div class="card bg">
                                        <img src="{{ asset("storage/SettingsImage/".$item->image) }}"   class="card-img-top">
                                        <div class="card-body mx-auto">
                                            <h4 class="card-title fw-bold text-center my-2">{{ $item->title }}</h4>
                                            <button wire:click='adsDelete({{ $item->id }})' class="btn btn-light text-center text-danger fs-5 fw-bold ">حذف الاعلان</button>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    @endif
                </div>
            </div>
        </div>





    </div>
</div>
