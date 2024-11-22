<div class="container color">
    <div class="row  fs-6 fw-bold">

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


        <div class="col-12 mx-auto">
            <h3 class="text-end text-light mb-4 fw-bold">الصندوق</h3>
        </div>

        @if ($show == "add")
            <div class="col-lg-12 mx-auto">
                <div class="row">
                    <div class="col-lg-3 col-sm-10 mx-auto">
                        @if($side_bar == "show")
                            <div class="card shadow">
                                <div class="card-body">

                                    @if ($customers != null or $customer != null)
                                        @if ($side_bar_customer_data == "customer list")
                                            <div class="list">
                                                @foreach ($customers as $item)
                                                    <p wire:click='setCustomer({{ $item->id }})'  class="fs-6 btn btn-light color mx-auto mt-2">{{ $item->name }}</p>
                                                    <hr class="color">
                                                @endforeach
                                            </div>

                                        @elseif ($side_bar_customer_data == "customer data")
                                            <p class="color">
                                            <span>الاسم</span> : <span>{{ $customer->name }}</span>
                                            </p>
                                            <p class="color">
                                            <span>المحافظة</span> : <span>{{ $customer->governorate }}</span>
                                            </p>
                                            <p class="color">
                                            <span>حساب الزبون</span> : <span>{{( $customer->account()->total_cost ? $customer->account()->total_cost : 0 ) }}</span>
                                            </p>
                                        @else
                                            <p class="text-center text-info fs-5">لا يوجد شي</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-8 col-sm-10 mx-auto">
                        <div class="card shadow">
                            <div class="card-body">
                                <form action=""wire:submit.prevent='saveOperation'>
                                    <div class="row p-3">

                                        <div class="col-lg-4 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">اسم العميل</label>
                                            <input  wire:model.live.debounce.100ms='customer_name' wire:keydown='setCustomerName' type="text" class="form-control" placeholder="اسم العميل" >
                                            <small class="text-danger">@error('customer_name') {{ $message }} @enderror</small>
                                        </div>
                                        <div class="col-lg-4 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">اسم الموظف</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" placeholder="اسم الموظف" @disabled(true)>
                                        </div>
                                        <div class="col-lg-4 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">  نوع العملية</label>
                                            <select wire:model.live='operation_type' wire:click='newNumberOfAccount' class="form-select" aria-label="Default select example">
                                                <option>اختر</option>
                                                <option value="give">صرف </option>
                                                <option value="take">قبض</option>
                                            </select>
                                            <small class="text-danger">@error('operation_type') {{ $message }} @enderror</small>
                                        </div>

                                        <div class="col-lg-5 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">الحساب القديم</label>
                                            <input  wire:model.live.debounce.100ms='old_number' type="number" class="form-control"  placeholder="الحساب القديم" @disabled(true)>
                                        </div>


                                        <div class="col-lg-5 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">الحساب الجديد</label>
                                            <input wire:model.live.debounce.100ms='new_number' type="number" class="form-control" placeholder="الحساب الجديد" @disabled(true)>
                                        </div>

                                        <div class="col-lg-5 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">ادخل مبلغ</label>
                                            <input wire:model.live='number' wire:keydown='newNumberOfAccount' type="number" class="form-control" placeholder="ادخل مبلغ">
                                            <small class="text-danger">@error('number') {{ $message }} @enderror</small>
                                        </div>


                                        <div class="col-lg-5 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">ملاحظة</label>
                                            <input type="text" class="form-control" placeholder="ملاحظة">
                                        </div>

                                        <div class="col-lg-5 col-sm-10 mt-4  me-4">
                                            <button type="submit" class="btn btn-success fs-6 fw-bold">حفظ</button>
                                            <button type="button" wire:click='showIMFTable' class="btn bg fs-6 fw-bold">جدول العمليات</button>
                                            <a href="{{ route("dashboard") }}" class="btn btn-secondary fs-6 fw-bold">خروج</a>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif ($show == "table")
            <div class="col-12 mx-auto">
                <div class="card card-body">
                    <div class="card-header d-flex justify-content-between">
                        <form class="row g-3">
                            <label for="inputPassword2" class="visually-hidden">البحث</label>
                            <input wire:model.live.debounce.100ms='search' type="search" class="form-control" placeholder="البحث...">
                        </form>

                        <div class="">
                            <button wire:click='showAdd' class="btn bg ms-2"><b>+</b></button>
                        </div>

                    </div>
                    <div class="card-body">
                        <!-- start table -->
                        @if(!empty($data))
                            <div class="table-responsive">
                                <table class="table table-hover border ">
                                    <thead class="color fs-5 fw-bold">
                                        <tr >
                                            <th scope="row">#</th>
                                            <td>اسم العميل </td>
                                            <td>اسم الموظف </td>
                                            <td>نوع العملية</td>
                                            <td>المبلغ القديم </td>
                                            <td> قيمة الدفع</td>
                                            <td>المبلغ الجديد</td>
                                            <td>التاريخ</td>
                                            <td>العمليات</td>
                                            </tr>
                                    </thead>
                                    <tbody class="bg-light color">
                                        @php
                                            $num = 1;//counter to table
                                        @endphp

                                        @foreach ($data as $item)
                                        <tr>
                                            <th scope="row">{{ $num++ }}</th>
                                            <td>{{ $item->customer()->name }}</td>
                                            <td>{{ $item->user()->name }}</td>
                                            <td>{{ ($item->operation_type == "take"? "قبض" : "صرف") }}</td>
                                            <td>{{ $item->old_number }}</td>
                                            <td>{{ $item->number }}</td>
                                            <td>{{ $item->new_number }}</td>
                                            <td>{{ $item->created_at->format("Y-m-d") }}</td>

                                            <td>
                                                <p class="d-inline mx-2 btn btn-danger " wire:click='showDeleteMessage({{$item->id}})'>حذف </p>
                                                <p class="d-inline mx-2 btn btn-warning " wire:click='showUpdateForm({{ $item->id  }})'>تعديل</p>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @else
                            <h3 class="text-primary m-5 text-center">لا يوجد بيانات</h3>
                        @endif
                    </div>
                </div>
            </div>

        @elseif ($show == "update")
            <div class="col-lg-12 mx-auto">
                <div class="row">
                    <div class="col-lg-3 col-sm-10 mx-auto">
                        @if($side_bar == "show")
                            <div class="card shadow">
                                <div class="card-body">

                                    @if ($customers != null or $customer != null)
                                        @if ($side_bar_customer_data == "customer list")
                                            <div class="list">
                                                @foreach ($customers as $item)
                                                    <p wire:click='setCustomer({{ $item->id }})'  class="fs-6 btn btn-light color mx-auto mt-2">{{ $item->name }}</p>
                                                    <hr class="color">
                                                @endforeach
                                            </div>

                                        @elseif ($side_bar_customer_data == "customer data")
                                            <p class="color">
                                            <span>الاسم</span> : <span>{{ $customer->name }}</span>
                                            </p>
                                            <p class="color">
                                            <span>المحافظة</span> : <span>{{ $customer->governorate }}</span>
                                            </p>
                                            <p class="color">
                                            <span>حساب الزبون</span> : <span>{{( $customer->account()->total_cost ? $customer->account()->total_cost : 0 ) }}</span>
                                            </p>
                                        @else
                                            <p class="text-center text-info fs-5">لا يوجد شي</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-8 col-sm-10 mx-auto">
                        <div class="card shadow">
                            <div class="card-body">
                                <form action=""wire:submit.prevent='updateOperation'>
                                    <div class="row p-3">

                                        <div class="col-lg-4 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">اسم العميل</label>
                                            <input  wire:model.live.debounce.100ms='customer_name' wire:keydown='setCustomerName' type="text" class="form-control" placeholder="اسم العميل" >
                                            <small class="text-danger">@error('customer_name') {{ $message }} @enderror</small>
                                        </div>
                                        <div class="col-lg-4 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">اسم الموظف</label>
                                            <input type="text" class="form-control" wire:model='user_name' placeholder="اسم الموظف" @disabled(true)>
                                        </div>
                                        <div class="col-lg-4 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">  نوع العملية</label>
                                            <select wire:model.live='operation_type' wire:click='newNumberOfAccount' class="form-select" aria-label="Default select example">
                                                @if($imf_data->operation_type =="give")
                                                    <option value="give">صرف </option>
                                                    <option value="take">قبض</option>
                                                @elseif($imf_data->operation_type =="take")
                                                    <option value="take">قبض</option>
                                                    <option value="give">صرف </option>
                                                @endif
                                            </select>
                                            <small class="text-danger">@error('operation_type') {{ $message }} @enderror</small>
                                        </div>

                                        <div class="col-lg-5 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">الحساب القديم</label>
                                            <input  wire:model.live.debounce.100ms='old_number' type="number" class="form-control"  placeholder="الحساب القديم" @disabled(true)>
                                        </div>


                                        <div class="col-lg-5 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">الحساب الجديد</label>
                                            <input wire:model.live.debounce.100ms='new_number' type="number" class="form-control" placeholder="الحساب الجديد" @disabled(true)>
                                        </div>

                                        <div class="col-lg-5 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">ادخل مبلغ</label>
                                            <input wire:model.live='number' wire:keydown='newNumberOfAccount' type="number" class="form-control" placeholder="ادخل مبلغ">
                                            <small class="text-danger">@error('number') {{ $message }} @enderror</small>
                                        </div>


                                        <div class="col-lg-5 col-sm-10 my-2 mx-auto">
                                            <label for="" class="color form-lable mb-1">ملاحظة</label>
                                            <input type="text" class="form-control" placeholder="ملاحظة">
                                        </div>

                                        <div class="col-lg-5 col-sm-10 mt-4  me-4">
                                            <button type="submit" class="btn btn-warning text-light fs-6 fw-bold">تعديل</button>
                                            <button type="button" wire:click='cancel' class="btn btn-secondary  mx-auto">الغاء</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif ($show == "delete")

            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 text-danger text-center">حذف الفاتورة </h5>
                    <div class="card-body">
                        <h3 class="text-danger text-center">
                            <p>
                                هل انت متاكد من حذف هذا القيد
                            </p>
                        </h3>
                        <div class="my-5 mx-auto text-danger text-center">
                            <form action="" wire:submit.prevent='imfDelete' method="post">
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
