
<div dir="rtl" class="w-100">
    <div class="row">
        <div class="col-lg-12 mx-auto mt-1 mb-1">
            <div class="card shadow ">
                <div class="card-body bg d-flex justify-content-between rounded">

                    <div class="swiper mySwiper2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide bg-light rounded-pill">
                                <a wire:click='changeRoute' class="card-title fs-4 fw-bold color d-flex justify-content-center mt-1" >الكل</a>
                            </div>
                            @foreach($section as $item)
                                <div class="swiper-slide bg-light rounded-pill">
                                    <a wire:click='changeRoute({{ $item->id }})' class="card-title fs-4 fw-bold color d-flex justify-content-center mt-1" >{{ $item->name }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class="container my-5">
        <div class="row">

                @foreach($categories as $item)
                    @if( $item->materials()->count() > 0 )

                        <div class="swiper mySwiper bg-light p-3 my-3 shadow">
                            <h4 class="color mt-3 mb-3 fw-bold">{{ $item->name }}</h4>
                            <div class="swiper-wrapper">

                                @foreach($item->materials() as $item2)
                                    <div class="swiper-slide card shadow" style="width: 18rem;">
                                        <img  src="{{ asset("img/img.jpg") }}" class="card-img-top w-100" alt="">
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



