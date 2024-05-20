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
            <h3 class="text-end text-light mb-5 fw-bold">جدول العملاء</h3>
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

                            <button wire:click='showChange("add")' class="btn bg ms-2"><b>+</b></button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table color">
                                <thead class="color fs-5 fw-bold">
                                <tr >
                                    <th scope="col">#</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col">رقم الهاتف</th>
                                    <th scope="col">المحافظة</th>
                                    <th scope="col">العنوان</th>
                                    <th scope="col">تاريخ الاضافة</th>
                                    <th scope="col">العمليات</th>
                                </tr>
                                </thead>
                                <tbody class=" fs-6 fw-bold">
                                    @php
                                        $i=1;
                                    @endphp
                                    @if($customers->count() > 0)
                                        @foreach($customers as $item)
                                        <tr>
                                            <th scope="row">
                                                {{$i++}}
                                            </th>
                                            <td>{{ $item->name}}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->governorate }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ date($item->created_at) }}</td>

                                            <td class="px-3">
                                                @php
                                                    $id_enc = Hash::make($item->id);
                                                @endphp
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
                                    {{ $customers->links() }}
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route("dashboard") }}" class="btn bg fs-6 fw-bold">الرجوع</a>
                            </div>
                        </div>
                </div>
            </div>

        @elseif($show == "add")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center"> اضافة عميل جديد</h5>
                    <div class="card-body">

                        <form wire:submit.prevent='create' class="container my-5 color">
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
                                    <option  value="">المحافظات</option>
                                    <option value="بغداد">بغداد</option>
                                    <option value="الربيل">الربيل</option>
                                    <option value="البصرة">البصرة</option>
                                </select>
                                <small class="text-danger">@error('governorate') {{ $message }} @enderror</small>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">العنوان</label>
                                <input wire:model='address' type="text" class="form-control" id="exampleFormControlInput1" placeholder=" ادخل العنوان">
                                <small class="text-danger">@error('address') {{ $message }} @enderror</small>
                            </div>
                            <div class="my-4">
                                <button type="submit" class="btn bg "> انشاء</button>
                                <button type="button" wire:click='cancel' class="btn btn-secondary "> الغاء</button>
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


        @endif
    </div>
</div>
