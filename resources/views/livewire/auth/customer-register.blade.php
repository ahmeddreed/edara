
    <div class="card shadow color">
        <div class="card-body">
            <h4 class="fw-bold text-center">
                    انشاء حساب عميل
            </h4>

            <form wire:submit.prevent='customerRegister' class="container my-5">
                @csrf
                @method("post")
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">الاسم</label>
                    <input wire:model='name' type="text" class="form-control" id="exampleFormControlInput1" placeholder=" ادخل الاسم">
                    <small class="text-danger">@error('name') {{ $message }} @enderror</small>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">رقم الهاتف</label>
                    <input wire:model='phone' type="number" class="form-control" id="exampleFormControlInput1" placeholder=" ادخل  الهاتف">
                    <small class="text-danger">@error('phone') {{ $message }} @enderror</small>
                </div>

                <div class="mb-3">
                    <select wire:model='governorate' class="form-select" aria-label="Default select example">
                        <option selected>المحافظات</option>
                        <option value="بغداد">بغداد</option>
                        <option value="الربيل">الربيل</option>
                        <option value="البصرة">البصرة</option>
                    </select>
                    <small class="text-danger">@error('governoratet') {{ $message }} @enderror</small>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">العنوان</label>
                    <input wire:model='address' type="text" class="form-control" id="exampleFormControlInput1" placeholder=" ادخل العنوان">
                    <small class="text-danger">@error('address') {{ $message }} @enderror</small>
                </div>
                <div class="my-4">
                    <button type="submit" class="btn bg "> انشاء حساب</button>
                </div>
            </form>
        </div>
    </div>

