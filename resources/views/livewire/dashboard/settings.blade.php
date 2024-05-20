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

                        <div class="col-8 mx-auto p-3">
                            <button @if($new_img ==null and $old_img ==null) @disabled(true) @endif type="submit" class="btn bg fs-5  mx-auto">تعديل</button>
                            <a href="{{ route("dashboard") }}" class="btn btn-secondary fs-5  mx-auto">رجوع</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
