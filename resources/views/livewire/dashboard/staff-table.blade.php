<div class="container">
    <div class="row">

        <div class="col-10 mx-auto text-light">
            @if(session()->has("msg_s"))
                <div class="alert alert-success text-center color" role="alert">
                    {{ session()->get("msg_s") }}
                </div>
            @elseif(session()->has("msg_e"))
                <div class="alert alert-danger text-center text-light" role="alert">
                    {{ session()->get("msg_e") }}
                </div>
            @endif

        </div>

        <div class="col-10 mx-auto">
            <h3 class="text-end text-light mb-5 fw-bold">جدول الموظفين</h3>
        </div>

        @if($show == "table")
            <div class="col-10 mx-auto mb-5">
                <div class="card card-body">
                    <div class="card-header d-flex justify-content-between">
                        <form class="row g-3">
                            <label for="inputPassword2" class="visually-hidden">البحث</label>
                            <input wire:model.live.debounce.100ms='search' type="search" class="form-control" placeholder="البحث...">
                        </form>

                        <div class="">
                            <button wire:click='giveSalaryForAll'  class="btn btn-success ms-2"><b>الرواتب</b></button>
                            <button wire:click='showChange("add")' class="btn btn-primary ms-2"><b>+</b></button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table color">
                                <thead class="color  fs-5 fw-bold">
                                <tr >
                                    <th scope="col">#</th>
                                    <th scope="col">الصورة</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col">صلاحية</th>
                                    <th scope="col">الراتب </th>
                                    <th scope="col">الجنس </th>
                                    <th scope="col">تاريخ الاضافة</th>
                                    <th scope="col">العمليات</th>
                                </tr>
                                </thead>
                                <tbody class=" fs-6 fw-bold">
                                    @php
                                        $i=1;
                                    @endphp
                                    @if($staffs->count() > 0)
                                        @foreach($staffs as $item)
                                        <tr>
                                            <th scope="row">
                                                {{$i++}}
                                            </th>
                                            <td>
                                                <img style="width: 4rem;height: 4rem;" class="rounded" src="{{ asset("storage/UserImage/". $item->image)  }}" alt="">

                                            </td>
                                            <td>{{ $item->name}}</td>
                                            <td>{{ $item->role()->name }}</td>
                                            <td>{{ $item->salary }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td>{{ date($item->created_at) }}</td>

                                            <td class="p-3">
                                                @php
                                                    $id_enc = Hash::make($item->id);
                                                    $date = date("m");

                                                    // $date = strtotime($date);
                                                    // $date = date("Y-m-d", strtotime("+1 month", $date));
                                                    // dd($date);

                                                    $salaryDate =  $item->lastSalary();

                                                @endphp
                                                @if($salaryDate == null or $salaryDate->created_at->format("m") !=  $date)
                                                    <button wire:click='showChange("salary",{{ $item->id }},"{{ $id_enc }}")' class="btn btn-success">الراتب</button>
                                                @else
                                                    <button wire:click='showChange("salary",{{ $item->id }},"{{ $id_enc }}")' class="btn btn-warning">الراتب</button>
                                                @endif

                                                <button wire:click='showChange("update",{{ $item->id }},"{{ $id_enc }}")' class="btn btn-warning">تعديل</button>
                                                <button wire:click='showChange("delete",{{ $item->id }},"{{ $id_enc }}" )' class="btn btn-danger">حذف</button>
                                            </td>
                                        </tr>
                                        @endforeach

                                    @else

                                    <h3 class="text-center color">
                                        لا يوجد بيانات
                                    </h3>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <div class="card-footer p-0 d-flex justify-content-between">
                            <div>
                                <p class="">
                                    {{ $staffs->links() }}
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route("dashboard") }}" class="btn btn-primary fs-6 fw-bold">الرجوع</a>
                            </div>
                        </div>
                </div>
            </div>

        @elseif($show == "add")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center">انشاء صلاحيه جديد</h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" wire:submit.prevent='create' enctype="multipart/form-data">
                            @csrf
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم الموظف :</label>
                                <input type="text" name="name" wire:model='name' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('name') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> الايميل :</label>
                                <input type="text" name="email" wire:model='email' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('email') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">رمز السري :</label>
                                <input type="password" name="password" wire:model='password' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('password') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">الراتب :</label>
                                <input type="text" name="salary" wire:model='salary' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('salary') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <select wire:model='role_id' class="form-select" aria-label="Default select example">
                                    <option value> الصلاحيات </option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">@error('role_id') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <select wire:model='gender' class="form-select" aria-label="Default select example">
                                    <option value> الجنس </option>
                                    <option value="ذكر">ذكر</option>
                                    <option value="انثى">انثى</option>
                                </select>
                                <small class="text-danger">@error('gender') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم الصلاحيه :</label>
                                <input type="file" name="image" wire:model='image' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('image') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto p-3">
                                <button type="submit" class="btn btn-primary fs-5  mx-auto">انشاء</button>
                                <button type="button" wire:click='cancel' class="btn btn-secondary fs-5  mx-auto">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        @elseif($show == "update")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center">تعديل الصلاحية </h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" wire:submit.prevent='update' method="POST">
                            @csrf
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم الموظف :</label>
                                <input wire:model='name' type="text" name="name"  class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('name') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> الايميل :</label>
                                <input wire:model='email' type="text" name="email"  class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('email') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">الراتب :</label>
                                <input name="salary" type="text" wire:model='salary' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('salary') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <select wire:model='role_id' class="form-select" aria-label="Default select example">
                                    <option value> الصلاحيات </option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">@error('role_id') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <select wire:model='gender' class="form-select" aria-label="Default select example">
                                    <option value> الجنس </option>
                                    <option value="ذكر">ذكر</option>
                                    <option value="انثى">انثى</option>
                                </select>
                                <small class="text-danger">@error('gender') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم الصلاحيه :</label>
                                <input type="file" name="image" wire:model='image' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('image') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto p-3">
                                <button type="submit" class="btn btn-primary fs-5  mx-auto">انشاء</button>
                                <button type="button" wire:click='cancel' class="btn btn-secondary fs-5  mx-auto">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        @elseif($show == "delete")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 text-danger text-center">حذف الصلاحية </h5>
                    <div class="card-body">
                        <h3 class="text-danger text-center">
                            <p>
                                هل انت متاكد من حذف هذا العنصر
                            </p>
                        </h3>
                        <div class="my-5 mx-auto text-danger text-center">
                            <form action="" wire:submit.prevent='delete' method="post">
                                <button type="submit" class="btn btn-danger">حذف</button>
                                <button type="button" wire:click='cancel' class="btn btn-secondary fs-5 mx-auto">الغاء</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            @elseif($show == "salary")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 text-success text-center">اعطاء الراتب </h5>
                    <div class="card-body">
                        <h3 class="text-success text-center">
                            <p>
                                هل انت متاكد  من اعطاء الراتب لعذا الشخص
                            </p>
                        </h3>
                        <div class="my-5 mx-auto text-success text-center">
                            <form action="" wire:submit.prevent='giveSalary' method="post">
                                <button type="submit" class="btn btn-success">اعطاء</button>
                                <button type="button" wire:click='cancel' class="btn btn-secondary fs-5 mx-auto">الغاء</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        @else
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 text-warning text-center">حدث خطا ما</h5>
                    <div class="card-body">
                        <h3 class="text-warning text-center">
                            <p>
                                الرجاء العودة الى لوحة التحكم
                            </p>
                            <a href="" class="btn btn-warning text-light fs-5">الرجوع</a>
                        </h3>
                    </div>
                </div>
            </div>

        @endif
    </div>
</div>
