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


        <div class="col-12 mx-auto">
            <h3 class="text-end text-light mb-3 fw-bold">الفواتير</h3>
        </div>

        @if($show == "table")
            <div class="col-12 mx-auto mb-5">
                <div class="card card-body">
                    <div class="card-header d-flex justify-content-between">
                        @if($all_invoice ==null)
                            <form class="row">
                                <label for="inputPassword2" class="visually-hidden">البحث</label>
                                <input wire:model.live.debounce.100ms='search' type="search" class="form-control" placeholder="البحث...">
                            </form>

                            <form class="row">
                                <input wire:model.live.debounce.100ms='date' type="date" class="form-control">
                            </form>

                            {{-- for space --}}
                            <form class="row mt-1">
                            </form>
                            <form class="row">
                            </form>

                        @else
                            {{-- for space --}}
                            <form class="row mt-1">
                            </form>
                            <form class="row">
                            </form>
                            <form class="row mt-1">
                            </form>
                            <form class="row">
                            </form>

                        @endif


                        <div class="d-flex">
                            <div class="form-check form-switch mx-3 mt-2">
                                <input  wire:model.live.debounce.100ms='all_invoice' class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                <label class="form-check-label color fw-bold" for="flexSwitchCheckDefault">الكل</label>
                            </div>
                            <div class="">
                                <button wire:click='createNewInvoice' class="btn bg ms-2"><b>+</b></button>
                            </div>

                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table color">
                                @if($data->count() > 0 )
                                    <thead class="color fw-bold fs-5">
                                    <tr >
                                        <th scope="col">رقم الفاتورة</th>
                                        <th scope="col"> صاحب الفاتورة</th>
                                        <th scope="col">الموظف</th>
                                        <th scope="col">عدد المواد</th>
                                        <th scope="col">التكلفة الكلية</th>
                                        <th scope="col">تاريخ الاضافة</th>
                                        <th scope="col">العمليات</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-bold">
                                        @php
                                            $i=1;
                                        @endphp
                                            @foreach($data as $item)
                                                @if ($item->customer())
                                                    <tr>
                                                        <td>{{ $item->id}}</td>
                                                        <td>{{ $item->customer()->name  }}</td>
                                                        <td>{{ $item->user()->name }}</td>
                                                        <td>{{ $item->materialCount() }}</td>
                                                        <td>{{ $item->t_price_after_discount }}</td>
                                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>

                                                        <td class="px-3">
                                                            @php
                                                                $id_enc = Hash::make($item->id);
                                                            @endphp
                                                            <button wire:click='showInvoiceDetail({{ $item->id }})' class="btn btn-info">عرض</button>
                                                            <button wire:click='showDelete({{ $item->id }})' class="btn btn-danger">حذف</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        @else


                                    </tbody>
                                    <h3 class="text-center color">
                                        لا يوجد بيانات
                                    </h3>
                                @endif
                            </table>
                        </div>
                    </div>
                        <div class="card-footer p-0 d-flex justify-content-between">
                            <div>
                                <p class="">
                                    {{ $data->links() }}
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route("dashboard") }}" class="btn bg fs-6 fw-bold">الرجوع</a>
                            </div>
                        </div>
                </div>
            </div>

        @elseif($show == "add")
            <div class="col-lg-3 col-sm-10 mx-auto">
                {{-- <h3 class="text-end text-light mb-3 container">الفواتير</h3> --}}
                @if($side_bar == "show")
                    <div class="card shadow">

                        <div class="card-body fw-bold fs-6">
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


                            @if($materials != null)

                            <hr class="color">
                            <hr class="color">

                                @if (count($materials) > 0 and  $side_bar_material_data == "material list")
                                    <div class="list">
                                        @foreach ($materials as $item)
                                            <p wire:click='setMaterial({{ $item->id }})'  class="fs-6 btn btn-light color mx-auto mt-2">{{ $item->title }}</p>
                                            <hr class="color">
                                        @endforeach
                                    </div>

                                @elseif ($side_bar_material_data == "material data")
                                    <p class="color">
                                    <span>الاسم</span> : <span>{{ $material->title }}</span>
                                    </p>
                                    <p class="color">
                                    <span>السعر</span> : <span>{{ $material->salePrice() }}</span>
                                    </p>
                                    <p class="color">
                                    <span>العدد المتوفر</span> : <span>{{ $material->number() }}</span>
                                    </p>
                                    <p class="color">
                                    <span>الملاحظة</span> : <span>{{ $material->note }}</span>
                                    </p>
                                @else
                                    <p class="text-center text-info fs-5">لا يوجد شي</p>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-9 col-sm-10  mx-auto  fs-5 fw-bold">
                <div class="card sahdow">
                    <div class="card-body">

                        <form action="">
                            <div class="row">
                                <div class="col-lg-3 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6">اسم العميل</label>
                                    <input wire:keydown='setCustomerName' wire:model.live.debounce.100ms='customer_name' type="text" class="form-control" placeholder="اسم العميل" >
                                    <small class="text-danger">@error('customer_name') {{ $message }} @enderror</small>
                                </div>
                                <div class="col-lg-3 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6">اسم الموظف</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" placeholder="اسم الموظف" @disabled(true)>
                                </div>
                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6">  نوع العملية</label>

                                        <select @if ($operation_type) @disabled(true) @endif  wire:model.live.debounce.100ms='operation_type' class="form-select" aria-label="Default select example">
                                            <option>اختر</option>
                                            <option value="in">شراء </option>
                                            <option value="out">بيع</option>
                                        </select>
                                        <small class="text-danger">@error('operation_type') {{ $message }} @enderror</small>


                                </div>
                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6"> نوع الفاتورة </label>
                                    <select wire:model.live.debounce.100ms='invoice_type' class="form-select" aria-label="Default select example">
                                        <option>اختر</option>
                                        <option value="cash">نقدي</option>
                                        <option value="debt">ديون</option>
                                    </select>
                                    <small class="text-danger">@error('invoice_type') {{ $message }} @enderror</small>
                                </div>
                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6"> التاريخ</label>
                                    <input type="text" class="form-control" value="{{ now()->format("Y/m/d") }}" @disabled(true)>
                                </div>

                                <br>

                                <div class="col-lg-3 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6">اسم المنتج</label>
                                    <input wire:keydown='setMaterialName' wire:model.live='material_name' type="text" class="form-control" placeholder="اسم المنتج ">
                                    <small class="text-danger">@error('material_name') {{ $message }} @enderror</small>
                                </div>
                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6">الكمية</label>
                                    <input  wire:model='material_Qty' wire:keydown='totalCost' type="number" class="form-control" value="" placeholder="الكمية" >
                                    <small class="text-danger">@error('material_Qty') {{ $message }} @enderror</small>
                                </div>

                                @if ($operation_type == "in")
                                    <div class="col-lg-2 col-sm-10 my-2">
                                        <label for="" class="color form-lable mb-1 fw-bold fs-6">السعر</label>
                                        <input wire:model='material_price' wire:keydown='totalCost' type="number" class="form-control" value="" placeholder="السعر" >
                                        <small class="text-danger">@error('material_price') {{ $message }} @enderror</small>
                                    </div>
                                 @endif
                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6">السعر البيع</label>
                                    <input wire:model='material_sale_price' wire:keydown='totalCost' type="number" class="form-control" value="" placeholder="سعر البيع" >
                                    <small class="text-danger">@error('material_sale_price') {{ $message }} @enderror</small>
                                </div>


                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6">المخزن</label>
                                    <select wire:model='store_id' class="form-select" aria-label="Default select example">

                                        @if($store_id)
                                            @php
                                                $store = App\Models\Store::find($store_id);
                                                // dd($store->name)
                                            @endphp
                                            <option value="{{ $store->id }}" selected>{{ $store->name }}</option>
                                        @else
                                            <option>اختر</option>
                                        @endif

                                        @foreach ($stores as $item)
                                            @if( $item->id != $store_id)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    <small class="text-danger">@error('invoice_type') {{ $message }} @enderror</small>
                                </div>


                                <div class="col-lg-3 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6"> تاريخ الانتهاء</label>
                                    <input type="date" wire:model='material_expiration' class="form-control" value="" >
                                    <small class="text-danger">@error('material_expiration') {{ $message }} @enderror</small>
                                </div>

                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6 "> مجموع الكلي</label>
                                    <input wire:model='material_total_cost' type="number" class="form-control"  @disabled(true)>
                                </div>

                                <div class="col-lg-3 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6 ">الملاحظة</label>
                                    <input type="text" class="form-control" value="الملاحظة">
                                </div>

                                <div class="col-lg-3 col-sm-10 my-2">
                                    @if($item_id == null)
                                        <button type="button" wire:click='addItem' class="btn btn-success fs-6 fw-bold mt-4 ">اضافة العنصر</button>
                                    @else
                                        <button type="button" wire:click='updateItem({{ $item_id }})' class="btn btn-warning fs-6 fw-bold  mt-4">تعديل العنصر</button>
                                    @endif
                                </div>

                                <br>

                                <hr class="color my-3">

                                <div class="flex justify-between">
                                    <p class=" color fs-5">
                                        بيانات الفاتورة
                                    </p>
                                </div>

                                {{-- table --}}
                                <div class="col-12 bg-secondary shadow mx-auto rounded">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-light fw-bold fs-5">
                                                <tr >
                                                    <th scope="col">#</th>
                                                    <th scope="col">اسم العنصر</th>
                                                    <th scope="col">الكمية</th>
                                                    <th scope="col">السعر</th>
                                                    <th scope="col">مجموع الكلي</th>
                                                    <th scope="col">العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody class=" text-light fw-bold fs-6">
                                                @if($invoice->items())
                                                @php
                                                    $num = 0;

                                                @endphp
                                                    @foreach($invoice->items() as $item)
                                                        <tr >
                                                            <th scope="col">{{  ++$num  }}</th>
                                                            <th scope="col">{{ "Invo-".$item->id }}</th>
                                                            <th scope="col">{{ $item->Qty }}</th>
                                                            <th scope="col">{{ $item->price }}</th>
                                                            <th scope="col">{{ $item->cost_of_all }}</th>
                                                            <th scope="col">
                                                                <a wire:click='editItem({{ $item->id }})' class="btn btn-warning">تعديل</a>
                                                                <a wire:click='deleteItem({{ $item->id }})' class="btn btn-danger">حذف</a>
                                                            </th>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <br>

                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6"> الخصم</label>
                                    <input type="text" class="form-control" wire:model='discount' placeholder="الخصم">
                                </div>

                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6 ">  عدد المنتجات</label>
                                    <input type="text" class="form-control" wire:model='invoice_material_count' @disabled(true)>
                                </div>

                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6 ">مجموع القائمة</label>
                                    <input type="text" class="form-control" wire:model='invoice_total_cost' @disabled(true)>
                                </div>

                                <div class="col-lg-2 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6">المجهز</label>
                                    <select wire:model.live.debounce.100ms='invoice_equipper' class="form-select" aria-label="Default select example">
                                        <option>اختر</option>
                                        @foreach ($equippers as $equiper)
                                            <option value="{{ $equiper->id}}">{{ $equiper->name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">@error('operation_type') {{ $message }} @enderror</small>
                                </div>

                                <div class="col-lg-3 col-sm-10 my-2">
                                    <label for="" class="color form-lable mb-1 fw-bold fs-6"> الملاحظة</label>
                                    <input type="text" class="form-control" placeholder="الملاحظة">
                                </div>

                                <br>

                                <div class="col-lg-8 col-sm-10 my-3">
                                    <button type="button" wire:click='saveTheInvoice' class="btn bg fs-6 fw-bold">حفظ الفاتورة</button>
                                    <button type="button" wire:click='out' class="btn btn-secondary fs-6 fw-bold">خروج</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        @elseif($show == "delete")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 text-danger text-center">حذف الفاتورة </h5>
                    <div class="card-body">
                        <h3 class="text-danger text-center">
                            <p>
                                هل انت متاكد من حذف هذا الفاتورة
                            </p>
                        </h3>
                        <div class="my-5 mx-auto text-danger text-center">
                            <form action="" wire:submit.prevent='invoiceDelete' method="post">
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
