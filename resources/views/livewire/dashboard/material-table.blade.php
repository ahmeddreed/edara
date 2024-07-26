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
            <h3 class="text-end text-light mb-5 fw-bold">جدول المواد</h3>
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
                    <div class="card-body fs-6 fw-bold">
                        <div class="table-responsive">
                            <table class="table color">
                                <thead class="color">
                                <tr >
                                    <th scope="col">#</th>
                                    <th scope="col">الصورة</th>
                                    <th scope="col">العنوان</th>
                                    <th scope="col">السعر</th>
                                    <th scope="col">العدد</th>
                                    <th scope="col">المضيف</th>
                                    <th scope="col">الفئة</th>
                                    <th scope="col">تاريخ الاضافة</th>
                                    <th scope="col">العمليات</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @if($materials->count() > 0)
                                        @foreach($materials as $item)
                                        <tr>
                                            <th scope="row">
                                                {{$i++}}
                                            </th>
                                            <td>
                                                <img style="width: 4rem;height: 4rem;" class="rounded" src="{{ asset("img/img.jpg")  }}" alt="">

                                            </td>
                                            <td>{{ $item->title}}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->number() }}</td>
                                            <td>{{ $item->user() }}</td>
                                            <td>{{ $item->category() }}</td>
                                            <td>{{ date($item->created_at) }}</td>

                                            <td class="px-3">
                                                @php
                                                    $id_enc = Hash::make($item->id);
                                                @endphp
                                                <button wire:click='showChange("update",{{ $item->id }},"{{ $id_enc }}")' class="btn btn-warning">تعديل</button>
                                                <button wire:click='showChange("delete",{{ $item->id }},"{{ $id_enc }}" )' class="btn btn-danger">حذف</button>
                                                <button wire:click='showChange("details",{{ $item->id }},"{{ $id_enc }}" )' class="btn btn-info">التفاصيل</button>
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
                                    {{ $materials->links() }}
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
                    <h5 class="my-4 color text-center">اضافة مادة جديد</h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" wire:submit.prevent='create'>
                            @csrf
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم المادة:</label>
                                <input type="text" name="title" wire:model='title' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم مادة " />
                                <small class="text-danger">@error('title') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> السعر :</label>
                                <input type="text" name="price" wire:model='price' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل السعر مادة " />
                                <small class="text-danger">@error('price') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> الوصف :</label>
                                <textarea name="discription" class="form-control g-3 in-valid" wire:model='discription'></textarea>
                                <small class="text-danger">@error('discription') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto">
                                <select wire:model='category_id' class="form-select" aria-label="Default select example">
                                    <option value> الفئة </option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">@error('category_id') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">صورة المادة :</label>
                                <input type="file" name="image" wire:model='image' class="form-control g-3 in-valid" id="exampleFormControlInput1" />
                                <small class="text-danger">@error('image') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">الملاحظة :</label>
                                <input type="text" name="salary" wire:model='salary' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل الملاحظة مادة " />
                                <small class="text-danger">@error('salary') {{ $message }} @enderror</small>
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
                    <h5 class="my-4 color text-center">تعديل مادة </h5>
                    <div class="card-body">
                        <form class="row g-3 mb-5" wire:submit.prevent='update'>
                            @csrf
                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">اسم المادة:</label>
                                <input type="text" name="title" wire:model='title' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل اسم مادة " />
                                <small class="text-danger">@error('title') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> السعر :</label>
                                <input type="text" name="price" wire:model='price' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل السعر مادة " />
                                <small class="text-danger">@error('price') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> الوصف :</label>
                                <textarea name="discription" class="form-control g-3 in-valid" wire:model='discription'></textarea>
                                <small class="text-danger">@error('discription') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto">
                                <select wire:model='category_id' class="form-select" aria-label="Default select example">
                                    <option value="{{ $material->category_id }}"> {{ $material->category() }} </option>
                                    @foreach ($categories as $item)
                                        @if($item->category_id != $material->category_id)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-danger">@error('category_id') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">صورة المادة :</label>
                                <input type="file" name="image" wire:model='image' class="form-control g-3 in-valid" id="exampleFormControlInput1" />
                                <small class="text-danger">@error('image') {{ $message }} @enderror</small>
                            </div>


                            <div class="col-8 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">الملاحظة :</label>
                                <input type="text" name="salary" wire:model='salary' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل الملاحظة مادة " />
                                <small class="text-danger">@error('salary') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-8 mx-auto p-3">
                                <button type="submit" class="btn btn-primary fs-5  mx-auto">تعديل</button>
                                <button type="button" wire:click='cancel' class="btn btn-secondary fs-5  mx-auto">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        @elseif($show == "delete")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 text-danger text-center">حذف مادة </h5>
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

        @elseif($show == "details")
            <div class="col-10 mx-auto mb-5">
                <div class="card mx-auto">
                    <h5 class="my-4 color text-center"> تفاصيل المادة</h5>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table color">
                                    <thead class="text-primary">
                                    <tr >
                                        <th scope="col">#</th>
                                        <th scope="col">المادة</th>
                                        <th scope="col">التفصيلة</th>
                                        <th scope="col">القيمة</th>
                                        <th scope="col">الموظف</th>
                                        <th scope="col">العمليات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp

                                        @if($material->ItemDetails())
                                            @foreach($material->ItemDetails() as $item)
                                            <tr>
                                                <th scope="row">
                                                    {{$i++}}
                                                </th>
                                                <td>{{ $material->title}}</td>
                                                <td>{{ $item->key }}</td>
                                                <td>{{ $item->value }}</td>
                                                <td>{{ $item->user()->name }}</td>
                                                <td class="px-3">
                                                    @php
                                                        $id_enc = Hash::make($item->id);
                                                    @endphp
                                                    <button wire:click='detailEdit({{ $item->id }})' class="btn btn-sm btn-warning">تعديل</button>
                                                    <button wire:click='detailDelete({{ $item->id }})' class="btn btn-sm  btn-danger">حذف</button>
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
                        <hr class="color">
                        <form class="row g-3 mb-5" wire:submit.prevent='addDetails'>
                            @csrf
                            <div class="col-4 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color">التفصيلة:</label>
                                <input type="text" name="key" wire:model='key' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل تفصيلة المادة " />
                                <small class="text-danger">@error('key') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-4 mx-auto">
                                <label for="exampleFormControlInput1" class=" form-label color"> القيمة :</label>
                                <input type="text" name="value" wire:model='value' class="form-control g-3 in-valid" id="exampleFormControlInput1" placeholder="ادخل  القيمة " />
                                <small class="text-danger">@error('value') {{ $message }} @enderror</small>
                            </div>

                            <div class="col-3 mx-auto mt-5">

                                @if(!$detail_id)
                                    <button type="submit" class="btn btn-sm btn-primary mx-auto">اضافة</button>
                                @else
                                    <button type="button" wire:click='updateDetails' class="btn btn-sm btn-warning mx-auto">تعديل</button>
                                @endif
                                <button type="button" wire:click='cancel' class="btn btn-sm btn-secondary mx-auto">الغاء</button>
                            </div>
                        </form>
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

