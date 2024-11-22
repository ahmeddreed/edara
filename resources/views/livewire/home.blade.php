
{{-- <div dir="rtl" class="w-100">
    <div class="row ">
        <div class="col-lg-12 mx-auto mt-1 mb-1 ">
            <div class="card shadow ">
                <div class="card-body bg d-flex justify-content-between rounded">

                    <div class="swiper mySwiper2 ">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide bg-light rounded mt-2 d-flex">
                                <div class=" justify-content-center align-content-center" style="width: 8rem; height:11rem">
                                    <a wire:click='changeRoute' class="card-title fs-4 fw-bold color d-flex justify-content-center mt-1" >الكل</a>
                                </div>

                            </div>
                            @foreach($section as $item)
                                <div class="swiper-slide rounded  m-2 card"  style="width: 15rem;" >

                                    <div class="card-img-top mx-auto" style="height:8rem">
                                        @if($item->img)
                                            <img class=" mx-auto" src="{{ asset("storage/SectionImage/".$item->img) }}" alt="">
                                        @else
                                            <img class=" mx-auto" src="{{ asset("img/dash/profile.webp") }}" alt="">
                                        @endif

                                    </div>
                                    <div class="card-body">
                                        <a wire:click='changeRoute({{ $item->id }})' class="card-title fs-5 fw-bold btn color d-flex justify-content-center mt-2 mb-0 ">{{ $item->name }}</a>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class=" my-5 w-100" style=" background-color: #e9e9ff">
        <div class="row">

                @foreach($categories as $item)
                    @if( $item->materials()->count() > 0 )

                        <div class="swiper mySwiper p-3 my-3 " >
                            <h4 class="color my-4 fw-bold ">{{ $item->name }}</h4>
                            <div class="swiper-wrapper">

                                @foreach($item->materials() as $item2)
                                    <div class="swiper-slide card shadow" style="width: 18rem;">

                                        @if($item->img)
                                             <img class=" mx-auto" src="{{ asset("storage/SectionImage/".$item->img) }}" alt="">
                                        @else
                                            <img class=" mx-auto" src="{{ asset("img/dash/profile.webp") }}" alt="">
                                        @endif

                                        <img class=" mx-auto" src="{{ asset("img/dash/profile.webp") }}" alt="">
                                        <div class="card-body m-2">
                                        <h5 class="card-title fs-5 fw-bold mb-3">{{ $item2->title }}</h5>
                                        <div class=" mt-4">
                                            <div class="d-grid gap-2">
                                                <a href="{{ route("detaile",["id"=>$item2->id]) }}" class="btn bg fs-6 fw-bold text-light">تفاصيل</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @endif
                @endforeach

        </div>
    </div>
</div> --}}


<main id="main" dir="rtl">


    {{-- for section  --}}
    <div class="row my-5">
        <div class="col-lg-12 mx-auto mt-1 mb-1 ">
            <div class="card shadow ">
                <div class="card-body bg d-flex justify-content-between rounded">

                    <div class="swiper mySwiper2 ">
                        <div class="swiper-wrapper">
                            <div class="card swiper-slide bg-light rounded-circle mt-2 p-5 d-flex card" style="max-width: 15rem; max-height: 15rem">
                                <div class=" justify-content-center align-content-center" >
                                    <a wire:click='changeRoute' class="card-title fs-4 fw-bold color d-flex justify-content-center mt-1 " >الكل</a>
                                </div>

                            </div>
                            @foreach($section as $item)
                                <div class="card swiper-slide rounded-circle  m-2 "  style="max-width: 15rem; max-height: 15rem" >

                                    <div class="card-img-top mx-auto" style="max-height:8rem">
                                        @if($item->img)
                                            <img class=" mx-auto" src="{{ asset("storage/SectionImage/".$item->img) }}" alt="">
                                        @else
                                            <img class=" mx-auto" src="{{ asset("img/dash/profile.webp") }}" alt="">
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    {{-- for section  --}}

    @foreach ($categories as $item)

        <div class="row my-5">
            <h3 class="color fw-bold">{{ $item->name }}</h3>
            <div class="col-lg-12 bg rounded p-3">
                <div class="row">
                    @if( $item->materials()->count() > 0 )

                        @foreach($item->materials() as $item2)
                            <div class="col-lg-3 col-md-4 col-sm-6 my-3 ">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <img class="card-img-top mx-auto" src="{{ asset("img/dash/profile.webp") }}" alt="">
                                        <div class="d-flex justify-content-center">
                                            <p class="color p-2 mt-2 fw-bold fs-4">
                                                <a navgate href="{{ route("detaile",["id"=>$item2->id]) }}" class="btn card-title fs-4 fw-bold color d-flex justify-content-center mt-1 " > {{ $item2->title }}</a>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if( $item->materials()->count() > 11)
                            <div class="col-lg-3 col-md-4 col-sm-6 my-3 ">
                                <div class="card shadow h-100 ">
                                    <div class="card-body p-5">

                                        <h3 class="my-5 text-center color fw-bold ">
                                            عرض كل المواد
                                        </h3>

                                    </div>
                                    <div class="card-footer bg-light">
                                        <div class="">
                                            <p class="color p-2 mt-2 fw-bold fs-4 ">
                                                <a navgate href="{{ route("showItems",["id"=>$item->id]) }}" class="btn card-title fs-4 fw-bold color d-flex justify-content-center mt-1 " > عرض الكل</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @else
                        <div class="col-lg-3 col-md-4 col-sm-6 my-3 ">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <p class="color p-2 mt-2 fw-bold fs-4">
                                        لايوجد بيانات
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    @endforeach



</main>
