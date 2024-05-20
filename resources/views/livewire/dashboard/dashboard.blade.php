<div  class="">

    <div class="row mb-3">
        <div class="col-lg-12 mb-5 mx-auto">
            <div class="card shadow rounded bg">
                <div class="card-body mx-auto">
                    <h3 class="text-center fs-4 fw-bold text-light"> لوحة التحكم</h3>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/profile.webp") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("staff.profile") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">الملف الشخصي</a>
                </div>
            </div>
        </div>


    @if(auth()->user()->role_id == 1)
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/role.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("rolesTable") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">الصلاحيات</a>
                </div>
            </div>
        </div>

    @endif

    @if(auth()->user()->role_id != 3)
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/staff.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("staffTable") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">موظفين</a>
                </div>
            </div>
        </div>

    @endif



    @if(auth()->user()->role_id != 3)
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/customer.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("customerTable") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">العملاء</a>
                </div>
            </div>
        </div>
    @endif


    @if(auth()->user()->role_id !=3 )
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/sales.webp") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("salesTable") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">العمليات </a>
                </div>
            </div>
        </div>
    @endif


    @if(auth()->user()->role_id != 3 )
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/imf.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("imf") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">الصندوق</a>
                </div>
            </div>
        </div>
    @endif

    @if(auth()->user()->role_id !=3)
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/material.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("materialTable") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">المواد</a>
                </div>
            </div>
        </div>
    @endif

    @if(auth()->user()->role_id ==1 )
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/section.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("sectionTable") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">الاقسام</a>
                </div>
            </div>
        </div>
    @endif


    @if(auth()->user()->role_id ==1)
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/category.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("categoryTable") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">الفئات</a>
                </div>
            </div>
        </div>
    @endif

        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/order.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("invoiceProcessing") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">الطلبات</a>
                </div>
            </div>
        </div>



    @if(auth()->user()->role_id !=5)
        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/information.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("settings") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">اعدادات النظام</a>
                </div>
            </div>
        </div>
    @endif

        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/home.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a href="{{ route("home") }}" class="btn btn-light color fs-6 fw-bold text-center rounded">الرائسية</a>
                </div>
            </div>
        </div>



        <div class="col-lg-3 col-md-5 col-sm-7 my-3 ">
            <div class="card mx-auto shadow rounded bg"  style="width:15rem;height:15rem;">
                <div class="card-header mx-auto">
                    <img src="{{ asset("img/dash/logout.png") }}" alt=""  style="width: 10rem;height: 10rem;" class="card-img-top text-center">
                </div>
                <div class="card-body mx-auto">
                    <a  wire:click='logout' class="btn btn-light color fs-6 fw-bold text-center rounded">تسجيل الخروج</a>
                </div>
            </div>
        </div>


        <div class="col-lg-12 mt-5 mx-auto">
            <h3 class="text-center color">  التحكم</h3>
        </div>
    </div>
</div>


