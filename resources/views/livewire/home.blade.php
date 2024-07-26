
<div dir="rtl" class="w-100">
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
                                        {{-- {{ dd() }} --}}
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
                                        {{-- <img  src="{{ asset("storage/MaterialImage/".$item2->image) }}" class="card-img-top w-100" alt=""> --}}
                                        {{-- @if($item->img)
                                             <img class=" mx-auto" src="{{ asset("storage/SectionImage/".$item->img) }}" alt="">
                                        @else
                                            <img class=" mx-auto" src="{{ asset("img/dash/profile.webp") }}" alt="">
                                        @endif --}}
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
</div>



