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

        <div class="col-10 mx-auto">
            <h3 class="text-end text-light mb-5">جدول التجهيز</h3>
            @php
                $add = "add";
                $update = "update";
                $delete = "delete";
            @endphp
        </div>

        @if($show == "table")
            <div class="col-10 mx-auto mb-5">
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

                        </div>

                        <div class="">
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table color">
                                <thead class="color fs-5 fw-bold">
                                <tr >
                                    <th scope="col">رقم الفاتورة</th>
                                    <th scope="col">صاحب الفاتورة</th>
                                    <th scope="col">الموظف</th>
                                    <th scope="col">اكدت</th>
                                    <th scope="col">العناصر</th>
                                    <th scope="col">جهزة</th>
                                    <th scope="col">العمليات</th>
                                </tr>
                                </thead>
                                <tbody class="fs-6 fw-bold">
                                    @foreach($invoices as $item)
                                    <tr>
                                        <th scope="row">
                                            {{"Inv-".$item->id}}
                                        </th>
                                        <td>{{ ($item->customer() ? $item->customer()->name  : "قائمة فارغة")}}</td>
                                        <td>{{ $item->user()->name }}</td>
                                        <td class="{{ $item->confirm()->invoice_verify ? "text-success" :"text-danger" }} fw-bold">
                                            {{ $item->confirm()->invoice_verify ? "ماكدة" : "غير ماكدة" }}
                                        </td>
                                        <td class="{{$item->equipinvoice() ? "text-success" :"text-danger" }} fw-bold">
                                            {{$item->equipinvoice() ? "مكتملة" : "غير مكتمل" }}
                                        </td>
                                        <td class="{{ $item->confirm()->equip ? "text-success" :"text-danger" }} text-success fw-bold">
                                            {{ $item->confirm()->equip ? "جهزت" : "غير مجهزة"}}</td>
                                        <td class="px-3">
                                            <button wire:click='showChange("showDetails",{{ $item->id }})' class="btn btn-success">عرض</button>

                                            @if(auth()->user()->role_id == 3)
                                               <button wire:click='showChange("equip",{{ $item->id }})' class="btn bg text-light">تجهيز</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer p-0 d-flex justify-content-between">
                        <div>
                            <p class="">
                                {{ $invoices->links() }}
                            </p>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route("dashboard") }}" class="btn bg fs-6 fw-bold">الرجوع</a>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($show == "showDetails")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 text-primary text-end me-3"> تفاصيل الفاتورة </h5>

                        <div class="row color mx-3 mb-5">

                            <div class="col-lg-3 fs-5 fw-bold">
                                <span >الزبون</span> : <span class="btn bg  fw-bold">{{($invoice->customer() ? $invoice->customer()->name  : "قائمة فارغة")}}</span>
                            </div>
                            <div class="col-lg-3 fs-5 fw-bold ">
                                <span >الموظف</span> : <span class="btn bg fw-bold">{{ $invoice->user()->name }}</span>
                            </div>
                            <div class="col-lg-3 fs-5 fw-bold">
                                <span >نوع العملية</span> : <span class="btn bg fw-bold">{{ $invoice->operation_type == "in" ?"شراء" :"بيع"  }}</span>
                            </div>
                            <div class="col-lg-3 fs-5 fw-bold">
                                <span >نوع الفاتورة</span> : <span class="btn bg fw-bold">{{ $invoice->invoice_type == "cash" ?"نقد" :"ديون"  }}</span>
                            </div>
                            <hr class="color fw-bold my-3">

                            <div class="col-lg-12">
                                {{-- items --}}

                                <div class="col-12 shadow mx-auto rounded">
                                    <div class="table-responsive">
                                        <table class="table color">
                                            <thead class="fs-5 fw-bold color">
                                                <tr>
                                                    <th scope="col">اسم العنصر</th>
                                                    <th scope="col">الكمية</th>
                                                    <th scope="col">السعر</th>
                                                    <th scope="col">مجموع الكلي</th>
                                                    <th scope="col">تجهيز العنصر</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold">
                                                @if($invoice->items())
                                                    @foreach($invoice->items() as $item)
                                                        <tr >
                                                            <th scope="col">{{$item->material()->title }}</th>
                                                            <th scope="col">{{ $item->Qty }}</th>
                                                            <th scope="col">{{ $item->price }}</th>
                                                            <th scope="col">{{ $item->cost_of_all }}</th>
                                                            <th scope="col">
                                                                <div class="form-check mx-auto fs-4 fw-bold">
                                                                    <input class="form-check-input mx-auto" type="checkbox" wire:click='equipItem({{ $item->id }})' value="{{ $item->equip }}"  id="{{ $item->id }}" @if($item->equip) checked @endif>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- end items --}}

                            </div>

                            <hr class="color fw-bold my-3">
                            <div class="col-lg-4 fs-5 fw-bold my-4">
                                <span >المجموع الفاتورة</span> : <span class="btn bg">{{ $invoice->t_price }}</span>
                            </div>
                            <div class="col-lg-4 fs-5 fw-bold my-3 ">
                                <span >الخصم</span> : <span class="btn bg">{{ $invoice->discount }}</span>
                            </div>
                            <div class="col-lg-4 fs-5 fw-bold my-3 ">
                                <span >المجموع بعد الخصم</span> : <span class="btn bg">{{ $invoice->t_price_after_discount }}</span>
                            </div>
                            <div class="col-lg-4 fs-5 fw-bold my-3 ">
                                <span >التجهيز العناصر</span> : <span class="fw-bold btn @if($invoice->equipinvoice())  btn-success @else btn-warning @endif">{{ ($invoice->equipinvoice() ? "تم التجهيز" : "لم يتم التجهيز ")}}</span>
                            </div>
                            <div class="col-lg-4 my-3 fs-5 fw-bold">
                                <span >الملاحظة </span> : <span>{{ $invoice->note }}</span>
                            </div>
                            <div class="col-lg-5 my-3 ">
                                <button wire:click='cancel' class="btn btn-secondary fw-bold">الرجوع</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($show == "equip")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 text-primary text-center"> تجهيز الفاتورة </h5>
                    <div class="card-body">
                        <h3 class="text-primary text-center">
                            <p>
                                هل تم التجهيز بنجاح
                            </p>
                        </h3>
                        <div class="my-5 mx-auto text-primary text-center">
                            <form action="" wire:submit.prevent='equip' method="post">
                                <button type="submit" class="btn bg fw-blod">نعم</button>
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