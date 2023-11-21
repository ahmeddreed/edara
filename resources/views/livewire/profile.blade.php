<div class="container my-5" dir="rtl">
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
            @if(session()->has("msg_s"))
                <div class="alert alert-success text-center color" role="alert">
                    {{ session()->get("msg_s") }}
                </div>
            @elseif(session()->has("msg_e"))
                <div class="alert alert-danger text-center text-light" role="alert">
                    {{ session()->get("msg_e") }}
                </div>
            @endif
            <div class="card shadow">
                <div class="card-body">
                    <p class="color fs-4 fw-bold text-center">
                        الملف الشخصي
                    </p>
                    <hr class="color mb-3">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item mx-auto" role="presentation">
                            <button class="nav-link active fw-bold" id="pills-data-tab" data-bs-toggle="pill" data-bs-target="#pills-data" type="button" role="tab" aria-controls="pills-data" aria-selected="true">بياناتي</button>
                        </li>
                        <li class="nav-item mx-auto" role="presentation">
                            <button class="nav-link fw-bold" id="pills-invoice-tab" data-bs-toggle="pill" data-bs-target="#pills-invoice" type="button" role="tab" aria-controls="pills-invoice" aria-selected="false">الفواتير</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-data" role="tabpanel" aria-labelledby="pills-data-tab">

                            <div class="card shadow container">
                                <div class="card-body ">
                                    <div class="row text-center">
                                        <div class="col-4">الاسم</div>
                                        <div class="col-7">{{session()->get('customer')->name }}</div>
                                        <div class="col-4">رقم الهاتف</div>
                                        <div class="col-7">{{session()->get('customer')->phone }}</div>
                                        <div class="col-4">المحافظة</div>
                                        <div class="col-7 ">{{session()->get('customer')->governorate }}</div>
                                        <div class="col-4">العنوان</div>
                                        <div class="col-7">{{session()->get('customer')->address }}</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-invoice" role="tabpanel" aria-labelledby="pills-invoice-tab">

                            <div class="row">

                                <div class="col-lg-12 mx-auto">
                                    <div class="card shadow">
                                        <div class="card-body">

                                            <table class="table text-center">
                                                <thead>
                                                  <tr class="">
                                                    <th scope="col">رقم الفاتورة</th>
                                                    <th scope="col">المساول</th>
                                                    <th scope="col">العمليات</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $invoices = session("customer")->invoices();
                                                        // $num = 1;
                                                    @endphp

                                                    @foreach($invoices as $invoice)
                                                        <tr>
                                                            <th scope="row">{{ $invoice->id }}</th>
                                                            <td>
                                                                @if($invoice->user_id)
                                                                    {{ DB::table('users')->find($invoice->user_id)->name }}
                                                                @else
                                                                    ذاتي
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="" class="btn btn-primary fw-bold">عرض</a>
                                                                <a href="" class="btn btn-danger fw-bold">حذف</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
