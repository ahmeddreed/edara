<div class="container">
    <div class="row">

        <div class="col-10 mx-auto text-light">
            @if(session()->has("msg_s"))
                <div class="alert alert-success text-center text-light" role="alert">
                    {{ session()->get("msg_s") }}
                </div>
            @elseif(session()->has("msg_e"))
                <div class="alert alert-danger text-center text-light" role="alert">
                    {{ session()->get("msg_e") }}
                </div>
            @endif

        </div>

        <div class="col-10 mx-auto">
            <h3 class="text-end text-light mb-5">جدول الصلاحيات</h3>
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
                        <form class="row g-3">
                            <label for="inputPassword2" class="visually-hidden">البحث</label>
                            <input wire:model.live.debounce.100ms='search' type="search" class="form-control" placeholder="البحث...">
                        </form>

                        <div class="">

                            <button wire:click='showChange("add")' class="btn btn-primary ms-2"><b>+</b></button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table color">
                                <thead class="text-primary">
                                <tr >
                                    <th scope="col">#</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col">تاريخ الاضافة</th>
                                    <th scope="col">العمليات</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach($roles as $item)
                                    <tr>
                                        <th scope="row">
                                            {{$i++}}
                                        </th>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ date($item->created_at) }}</td>
                                        <td class="px-3">
                                            @php
                                                $id_enc = Hash::make($item->id);
                                            @endphp
                                            <button wire:click='showChange("update",{{ $item->id }},"{{ $id_enc }}")' class="btn btn-warning">تعديل</button>
                                            <button wire:click='showChange("delete",{{ $item->id }},"{{ $id_enc }}" )' class="btn btn-danger">حذف</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($roles->count() > 0)
                        <div class="card-footer p-0">
                            <tr>
                                <p class="">
                                    {{ $roles->links() }}
                                </p>
                            </tr>
                        </div>
                    @endif
                </div>
            </div>

        @elseif($show == "add")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center">انشاء صلاحيه جديد</h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" wire:submit.prevent='create' action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم الصلاحيه :</label>
                                <input type="text" name="name" wire:model='name' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية " />
                                <small class="text-danger">@error('name') {{ $message }} @enderror</small>
                            </div>
                            <button type="submit" class="btn btn-primary fs-5 col-8 mx-auto">انشاء</button>
                            <button type="button" wire:click='cancel' class="btn btn-secondary fs-5 col-8 mx-auto">الغاء</button>
                        </form>
                    </div>
                </div>
            </div>


        @elseif($show == "update")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center">تعديل الصلاحية </h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" action="" wire:submit.prevent='update' method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-8 mx-auto">
                                <label class=" form-label color">اسم الصلاحيه :</label>
                                <input wire:model='name' type="text" name="name" class="form-control g-3 @error('roleName') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="ادخل اسم الصلاحية "/>
                            </div>
                            <button type="submit" class="btn btn-primary fs-5 col-8 mx-auto">تعديل</button>
                            <button type="button" wire:click='cancel' class="btn btn-secondary fs-5 col-8 mx-auto">الغاء</button>
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
