<div class="container color">

    @if($show == "reportList")
        <section id="reports" class="">

            <h2 class="text-light border-3 border-bottom pb-1" style="width: 10%">التقارير</h2>
            <div class="row mt-3">

                <div class="col-lg-12 col-md-12 col-sm-12 my-2 mx-auto">
                    <div class="bg-light rounded d-flex">
                        <div class="header rounded  bg-success d-flex justify-center align-items-center">
                            <h5 class="title text-center text-light p-4">الفواتير</h5>
                        </div>
                        <div class="d-flex mx-auto">
                            <div class=" justify-center align-content-center">
                                <button type="button" wire:click='invoiceForDay' class="btn btn-info m-2 px-2 py-1 text-light btn-md fs-5">اليومية</button>
                                <button type="button" wire:click='invoiceForDay' class="btn btn-info m-2 px-2 py-1 text-light btn-md fs-5">حسب المادة</button>
                                <button type="button" wire:click='byCustomerForm' class="btn btn-info m-2 px-2 py-1 text-light btn-md fs-5">حسب العميل</button>
                                <button type="button" wire:click='byDurationForm' class="btn btn-info m-2 px-2 py-1  text-light btn-md fs-5">حسب المدة</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 col-md-8 col-sm-12 my-2 mx-auto">
                    <div class="bg-light rounded d-flex">
                        <div class="header rounded  bg-success ">
                            <h5 class="title text-center text-light p-4">المستندات</h5>
                        </div>
                        <div class="d-flex mx-auto">
                            <div class=" justify-center align-content-center">
                                <button type="button" wire:click='documentForDay' class="btn btn-info m-2 px-2 py-1 text-light btn-md fs-5"> اليومية</button>
                                <button type="button" wire:click='documentByCustomerForm' class="btn btn-info m-2 px-2 py-1 text-light btn-md fs-5">حسب العميل</button>
                                <button type="button" wire:click='documentByDurationForm' class="btn btn-info m-2 px-2 py-1 text-light btn-sm fs-5">حسب المدة</button>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6 col-md-8 col-sm-12 my-2 mx-auto">
                    <div class="bg-light rounded d-flex">
                        <div class="header rounded  bg-primary ">
                            <h5 class="title text-center text-light p-4">لوحة التحكم</h5>
                        </div>
                        <div class="d-flex mx-auto">
                            <div class=" justify-center align-content-center">
                                <a href="{{ route("dashboard") }}" wire:navigate class="btn btn-info mt-2 px-2 py-1 text-light btn-sm fs-5">رجوع</a>
                            </div>
                        </div>
                    </div>
                </div>




            </div>

        </section>

    @elseif($show == "invoice")

        {{-- sales --}}
        <div class="table-responsive mb-3">
            <h3 class="text-light fw-bold">فواتير المبيعات</h3>
            <table class="table bg-light rounded">
                @if($sales_data->count() > 0 )
                    <thead class=" fw-bold fs-5">
                    <tr >
                        <th scope="col">رقم الفاتورة</th>
                        <th scope="col"> صاحب الفاتورة</th>
                        <th scope="col">الموظف</th>
                        <th scope="col">نوع الفاتورة</th>
                        <th scope="col">عدد المواد</th>
                        <th scope="col">التكلفة الكلية</th>
                        <th scope="col">تاريخ الاضافة</th>
                        <th scope="col">العمليات</th>
                    </tr>
                    </thead>
                    <tbody class="fs-6 fw-bold">
                        @php
                            $i=1;
                            $cash = 0;
                            $debt = 0;
                        @endphp
                            @foreach($sales_data as $item)
                                @if ($item->customer())
                                    <tr>
                                        <td>{{ "INV-".$item->id}}</td>
                                        <td>{{ $item->customer()->name  }}</td>
                                        <td>{{ $item->user()->name }}</td>
                                        <td>{{ $item->invoice_type == "cash"  ? "نقد" : "ديون" }}</td>
                                        <td>{{ $item->materialCount() }}</td>
                                        <td>{{ $item->t_price_after_discount }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>

                                        <td class="px-3">
                                            <button  class="btn btn-info text-light">عرض</button>
                                        </td>
                                    </tr>

                                    @php
                                        if($item->invoice_type == "cash")
                                            $cash += $item->t_price_after_discount;
                                        elseif($item->invoice_type == "debt")
                                            $debt += $item->t_price_after_discount;
                                        else {
                                            # code...
                                        }
                                    @endphp

                                @endif
                            @endforeach

                        </tbody>
                        @if($sales_data->count() > 0)
                            <tfoot class="text-center bg-light ">
                                <tr>
                                    <td class="text-center">مجموع تكلفة النقدية</td>
                                    <td class="text-center">{{ $cash }}</td>
                                    <td colspan="3"  class="text-center">-|-</td>
                                    <td  class="text-center">مجموع تكلفة الاجلة</td>
                                    <td  class="text-center">{{ $debt }}</td>
                                </tr>
                            </tfoot>
                        @endif
                        @else
                    <h3 class="text-center text-light">
                        لا يوجد فواتير للمبيعات
                    </h3>
                @endif
            </table>
        </div>

        {{-- purchases --}}
        <div class="table-responsive mb-3">
            <h3 class="text-light fw-bold">فواتير المشتريات</h3>
            <table class="table bg-light rounded color">
                @if($purchase_data->count() > 0 )
                    <thead class=" fw-bold fs-5">
                    <tr >
                        <th scope="col">تسلسل</th>
                        <th scope="col">رقم الفاتورة</th>
                        <th scope="col"> صاحب الفاتورة</th>
                        <th scope="col">الموظف</th>
                        <th scope="col">نوع الفاتورة</th>
                        <th scope="col">عدد المواد</th>
                        <th scope="col">التكلفة الكلية</th>
                        <th scope="col">تاريخ الاضافة</th>
                        <th scope="col">العمليات</th>
                    </tr>
                    </thead>
                    <tbody class="fs-6 fw-bold">
                        @php
                            $i=1;
                            $cash = 0;
                            $debt = 0;
                        @endphp
                            @foreach($purchase_data as $item)
                                @if ($item->customer() )
                                    <tr>
                                        <td>{{ $i}}</td>
                                        <td>{{ "INV-".$item->id}}</td>
                                        <td>{{ $item->customer()->name  }}</td>
                                        <td>{{ $item->user()->name }}</td>
                                        <td>{{ $item->invoice_type == "cash"  ? "نقد" : "ديون" }}</td>
                                        <td>{{ $item->materialCount() }}</td>
                                        <td>{{ $item->t_price_after_discount }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>

                                        <td class="px-3">
                                            <button  class="btn btn-info text-light">عرض</button>
                                        </td>
                                    </tr>

                                    @php
                                        $i++;
                                        if($item->invoice_type == "cash")
                                            $cash += $item->t_price_after_discount;
                                        elseif($item->invoice_type == "debt")
                                            $debt += $item->t_price_after_discount;
                                        else {
                                            # code...
                                        }


                                    @endphp

                                @endif
                            @endforeach

                        </tbody>
                        @if($purchase_data->count() > 0)
                            <tfoot class="text-center bg-light ">
                                <tr>
                                    <td class="text-center">مجموع تكلفة النقدية</td>
                                    <td class="text-center">{{ $cash }}</td>
                                    <td colspan="3"  class="text-center">-|-</td>
                                    <td  class="text-center">مجموع تكلفة الاجلة</td>
                                    <td  class="text-center">{{ $debt }}</td>
                                </tr>
                            </tfoot>
                        @endif

                        @else
                    <h3 class="text-center text-light">
                        لا يوجد فواتير للمشتريات
                    </h3>
                @endif
            </table>
        </div>

        <div>
            <button wire:click='cancel' class="btn btn-info text-light float float-end fw-bold fs-5">الرجوع </button>
       </div>

    @elseif($show == "invoiceByDuration")

        <div class="row ">

            <div class="col-lg-6  p-3 bg-light rounded mx-auto" >
                <h3 class="text-center">
                    فواتير حسب المدة
                </h3>
                <form action="" >
                    <div class="p-2">
                        <label for="dateFrom">من</label>
                        <input type="date" wire:model="first_date" value="" class="form-control" id="dateFrom" placeholder="من">
                    </div>
                    <div class="p-2">
                        <label for="dateTo">إلى</label>
                        <input type="date" wire:model="last_date" class="form-control" id="dateTo" placeholder="إلى">
                        <small class="text-danger">
                            @error('last_date') {{ $message }} @enderror
                        </small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" wire:click='invoiceByDuration' class="btn btn-info text-light float float-end fw-bold fs-5 d-inline">عرض</button>
                        <button type="button" wire:click='cancel' class="btn btn-secondary text-light float float-end fw-bold fs-5 d-inline">الغاء</button>
                    </div>
                </form>

            </div>
        </div>


    @elseif($show == "invoiceByCustomer")

        <div class="row ">
            {{-- <h3 class="text-end text-light mb-3 container">الفواتير</h3> --}}
            @if($side_bar == "show")
                <div class="col-lg-3 col-sm-10 mx-auto">
                    <div class="card shadow">
                        {{--  --}}
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
                                        @if ($customer->account())
                                            <span>حساب الزبون</span> : <span>{{( $customer->account()->total_cost ? $customer->account()->total_cost : 0 ) }}</span>
                                        @endif
                                    </p>

                                @else
                                    <p class="text-center text-info fs-5">لا يوجد شي</p>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            @endif


            <div class="col-lg-6  p-3 bg-light rounded mx-auto" >
                <h3 class="text-center">
                    فواتير حسب العميل
                </h3>
                <form action="" >
                    <div class="p-2">
                        <label class="p-3" for="custmer">اسم الشخص</label>
                        <input type="text" wire:keydown='setCustomerName' wire:model.live.debounce.100ms='customer_name' class="form-control" id="custmer" placeholder="من">
                    </div>
                    <div class="p-2">
                        <label class="p-3" for="dateFrom">من</label>
                        <input type="date" wire:model="first_date" value="" class="form-control" id="dateFrom" placeholder="من">
                    </div>
                    <div class="p-2">
                        <label class="p-3" for="dateTo">إلى</label>
                        <input type="date" wire:model="last_date" class="form-control" id="dateTo" placeholder="إلى">
                        <small class="text-danger">
                            @error('last_date') {{ $message }} @enderror
                        </small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" wire:click='invoiceByCustomer' class="btn btn-info text-light float float-end fw-bold fs-5 d-inline">عرض</button>
                        <button type="button" wire:click='cancel' class="btn btn-secondary text-light float float-end fw-bold fs-5 d-inline">الغاء</button>
                    </div>
                </form>

            </div>
        </div>



    @elseif($show == "document")

        {{-- sales --}}
        <div class="table-responsive mb-3">
            <h3 class="text-light fw-bold">مستندات القبض</h3>
            <table class="table bg-light rounded color">
                @if($give_data->count() > 0 )
                    <thead class=" fw-bold fs-5">
                    <tr >
                        <th scope="col">رقم المستند </th>
                        <th scope="col"> صاحب المستند</th>
                        <th scope="col">الموظف</th>
                        <th scope="col">نوع المستند</th>
                        <th scope="col">الحساب القديم</th>
                        <th scope="col">القمية النقدية المعطاء</th>
                        <th scope="col">الحساب الجديد</th>
                        <th scope="col">التاريخ</th>
                        <th scope="col">العمليات</th>
                    </tr>
                    </thead>
                    <tbody class="fs-6 fw-bold">
                        @php
                            $i=1;
                            $give = 0;
                        @endphp
                            @foreach($give_data as $item)
                                @if ($item->customer())
                                    <tr>
                                        <td>{{ "DUC-".$item->id}}</td>
                                        <td>{{ $item->customer()->name  }}</td>
                                        <td>{{ $item->user()->name }}</td>
                                        <td>{{"صرف"}}</td>
                                        <td>{{ $item->old_number }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->new_number }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>

                                        <td class="px-3">
                                            <button  class="btn btn-info text-light">عرض</button>
                                        </td>
                                    </tr>

                                    @php
                                        if($item->operation_type == "give")
                                            $give += $item->number;
                                        else {
                                            # code...
                                        }
                                    @endphp

                                @endif
                            @endforeach

                        </tbody>
                        @if($give_data->count() > 0)
                            <tfoot class="text-center bg-light ">
                                <tr>
                                    <td class="text-center">مجموع الصرف</td>
                                    <td class="text-center">{{ $give }}</td>
                                    <td colspan="3"  class="text-center">-|-</td>
                                </tr>
                            </tfoot>
                        @endif
                        @else
                    <h3 class="text-center text-light">
                        لا يوجد مستندات
                    </h3>
                @endif
            </table>
        </div>


        {{-- catch --}}
        <div class="table-responsive mb-3">
            <h3 class="text-light fw-bold">مستندات الصرف</h3>
            <table class="table bg-light rounded color">
                @if($take_data->count() > 0 )
                    <thead class=" fw-bold fs-5">
                    <tr >
                        <th scope="col">رقم المستند </th>
                        <th scope="col"> صاحب المستند</th>
                        <th scope="col">الموظف</th>
                        <th scope="col">نوع المستند</th>
                        <th scope="col">الحساب القديم</th>
                        <th scope="col">القمية النقدية المعطاء</th>
                        <th scope="col">الحساب الجديد</th>
                        <th scope="col">التاريخ</th>
                        <th scope="col">العمليات</th>
                    </tr>
                    </thead>
                    <tbody class="fs-6 fw-bold">
                        @php
                            $i=1;
                            $take = 0;
                        @endphp
                            @foreach($take_data as $item)
                                @if ($item->customer() )
                                    <tr>
                                        <td>{{ "DUC-".$item->id}}</td>
                                        <td>{{ $item->customer()->name  }}</td>
                                        <td>{{ $item->user()->name }}</td>
                                        <td>{{"قبض"}}</td>
                                        <td>{{ $item->old_number }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->new_number }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>

                                        <td class="px-3">
                                            <button  class="btn btn-info text-light">عرض</button>
                                        </td>
                                    </tr>

                                    @php
                                        $i++;
                                        if($item->operation_type == "take"){
                                            $take += $item->number;
                                        }
                                        else {
                                            # code...
                                        }


                                    @endphp

                                @endif
                            @endforeach

                        </tbody>
                        @if($take_data->count() > 0)
                            <tfoot class="text-center bg-light ">
                                <tr>
                                    <td class="text-center">مجموع القبض</td>
                                    <td class="text-center">{{ $take }}</td>
                                    <td colspan="3"  class="text-center">-|-</td>
                                </tr>
                            </tfoot>
                        @endif

                        @else
                    <h3 class="text-center text-light">
                        لا يوجد مستندات
                    </h3>
                @endif
            </table>
        </div>

        <div>
            <button wire:click='cancel' class="btn btn-info text-light float float-end fw-bold fs-5">الرجوع </button>
       </div>



    @elseif($show == "documentByDuration")
        <div class="row ">

            <div class="col-lg-6  p-3 bg-light rounded mx-auto" >
                <h3 class="text-center">
                    المستندات حسب المدة
                </h3>
                <form action="" >
                    <div class="p-2">
                        <label for="dateFrom">من</label>
                        <input type="date" wire:model="first_date" value="" class="form-control" id="dateFrom" placeholder="من">
                    </div>
                    <div class="p-2">
                        <label for="dateTo">إلى</label>
                        <input type="date" wire:model="last_date" class="form-control" id="dateTo" placeholder="إلى">
                        <small class="text-danger">
                            @error('last_date') {{ $message }} @enderror
                        </small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" wire:click='documentByDuration' class="btn btn-info text-light float float-end fw-bold fs-5 d-inline">عرض</button>
                        <button type="button" wire:click='cancel' class="btn btn-secondary text-light float float-end fw-bold fs-5 d-inline">الغاء</button>
                    </div>
                </form>

            </div>
        </div>



    @elseif($show == "documentByCustomer")

        <div class="row ">
            {{-- <h3 class="text-end text-light mb-3 container">الفواتير</h3> --}}
            @if($side_bar == "show")
                <div class="col-lg-3 col-sm-10 mx-auto">
                    <div class="card shadow">
                        {{--  --}}
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
                                        @if ($customer->account())
                                            <span>حساب الزبون</span> : <span>{{( $customer->account()->total_cost ? $customer->account()->total_cost : 0 ) }}</span>
                                        @endif
                                    </p>

                                @else
                                    <p class="text-center text-info fs-5">لا يوجد شي</p>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            @endif


            <div class="col-lg-6  p-3 bg-light rounded mx-auto" >
                <h3 class="text-center">
                    المستندات حسب العميل
                </h3>
                <form action="" >
                    <div class="p-2">
                        <label class="p-3" for="custmer">اسم الشخص</label>
                        <input type="text" wire:keydown='setCustomerName' wire:model.live.debounce.100ms='customer_name' class="form-control" id="custmer" placeholder="من">
                    </div>
                    <div class="p-2">
                        <label class="p-3" for="dateFrom">من</label>
                        <input type="date" wire:model="first_date" value="" class="form-control" id="dateFrom" placeholder="من">
                    </div>
                    <div class="p-2">
                        <label class="p-3" for="dateTo">إلى</label>
                        <input type="date" wire:model="last_date" class="form-control" id="dateTo" placeholder="إلى">
                        <small class="text-danger">
                            @error('last_date') {{ $message }} @enderror
                        </small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" wire:click='documentByCustomer' class="btn btn-info text-light float float-end fw-bold fs-5 d-inline">عرض</button>
                        <button type="button" wire:click='cancel' class="btn btn-secondary text-light float float-end fw-bold fs-5 d-inline">الغاء</button>
                    </div>
                </form>

            </div>
        </div>

    @endif

</div>
