<div class="container" dir="rtl">
    <div class="row my-5">

        <div class="col-lg-6 col-md-8 col-sm-12 mx-auto my-3">
            <div class="shadow card">
                <img  src="{{asset("img/img.jpg") }}" style="width: 30rem;height: 27rem;" alt="" class="card-img-top h-100 w-100">
                <div class="card-body p-4  d-none">
                    <div class="mx-auto ">
                        <a href="#" class="btn bg px-4 py-2 fw-bold fs-5">شراء </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-8 col-sm-12 my-3">
            <div class="shadow card">
                <div class="card-body color">
                    <h3 class="fw-bold">تفاصيل المنتج</h3>
                    <hr class="color">
                    <div class="row fw-bold fs-5">
                        <div class="col-lg-5">الاسم :</div>
                        <div class="col-lg-5"> {{ $material->title }}</div>

                        <div class="col-lg-5">السعر :</div>
                        <div class="col-lg-5"> {{ $material->price }}</div>

                        @if($material->ItemDetails()->count() > 0)
                            @foreach($material->ItemDetails() as $item)
                                <div class="col-lg-5">{{ $item->key }} :</div>
                                <div class="col-lg-5"> {{ $item->value  }}</div>
                            @endforeach
                        @endif

                        @if( $material->description)
                            <div class="col-lg-12 mt-3">
                                <p class="color fs-5 fw-bold">
                                    الوصف:
                                </p>
                               <hr class="bg fw-bold fs-5">
                                <p>
                                    {!!  $material->description !!}
                                </p>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="container my-5">
            <div class="row">



                <div class="swiper mySwiper bg-light p-3 my-3 shadow">
                    <h3 class="color my-3 fs-5 fw-bold">{{$category->name }}</h3>
                    <div class="swiper-wrapper">

                        @foreach($category->materials() as $item)
                        {{-- <h1>{{ $item->id."-".$material->category_id }}</h1> --}}
                            @if($material->id !== $item->id)
                                <div class="swiper-slide card" style="width: 18rem;">
                                    <img  src="{{ asset("img/img.jpg") }}" class="card-img-top w-100" alt="">
                                    <div class="card-body m-2">
                                    <h5 class="card-title fs-5 fw-bold mb-3">{{ $item->title }}</h5>
                                    <div class=" mt-4">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route("detaile",["id"=>$item->id]) }}" class="btn bg fs-6 fw-bold text-light">تفاصيل</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
