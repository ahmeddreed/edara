@props([
    'title'=>"tilte",
    "des"=>"الوصف",
    "slide"=>0,
    "heroAds"=>[],

])

{{--
@foreach($heroAds as $item)
<div class="carousel-item ">
    <img style="max-height: 550px;" src="{{ asset("storage/SettingsImage/".$item->image) }}" class="d-block w-100 rounded-sm "  alt="...">
    <div class="carousel-caption d-none d-md-block">
        <h5>{{ $item->title }}</h5>
        <p>{{ $item->description }}</p>
    </div>
</div>
@endforeach --}}

<div class="bg p-5">
    {{-- <div class="row container p-3">
        <div class="col-lg-6 col-md-7 my-lg-5 mx-auto mt-md-0 text-center">
            <img src="{{ asset("img/hero.png") }}" class="w-50">
        </div>
        <div class="col-lg-5 col-md-7 my-5 mx-auto">
            <h3 class="text-light fs-2 fw-bold text-end">
                شركة {{ $title }}
            </h3>
            <p class="text-light fs-3 fw-bold p-3 text-end">
                {{$des}}
            </p>
        </div>
    </div> --}}
{{--
    <div id="carouselExampleCaptions" class="carousel slide rounded-sm" data-bs-ride="carousel">
        <div class="carousel-indicators">
          @for($i = 0; $i < $heroAds->count(); $i++)
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $i }}"  @if($i == $slide) class="active" aria-current="true" @endif aria-label="Slide {{ $i+1 }}" wire:click='changeSlide({{ $i }})'></button>
          @endfor

        </div>

        <div class="carousel-inner">
            @php
                $i =0;
            @endphp

            {{ dd($slide, $i) }}
            @foreach($heroAds as $item)
                <div class="carousel-item @if($i == $slide) active @endif">
                    <img style="max-height: 550px;" src="{{ asset("storage/SettingsImage/".$item->image) }}" class="d-block w-100 rounded-sm "  alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $item->title }}</h5>
                        <p>{{ $item->description }}</p>
                    </div>
                </div>

                @php
                    $i++;
                @endphp
            @endforeach

            <div class="carousel-item @if($i == $slide) active @endif">
                <img style="max-height: 550px;" src="{{ asset("img/car.jpg") }}" class="d-block w-100 rounded-sm "  alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>gkfd;kg;fdg;kdf;</h5>
                    <p>hdjksghfdjhgl;dflkghjf</p>
                </div>
            </div>

            <div class="carousel-item @if($i == $slide) active @endif">
                <img style="max-height: 550px;" src="{{ asset("img/hero.jpg") }}" class="d-block w-100 rounded-sm "  alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>gkfd;kg;fdg;kdf;</h5>
                    <p>hdjksghfdjhgl;dflkghjf</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div> --}}

    <div class="swiper mySwiper3 ">
        <div class="swiper-wrapper">


            @foreach($heroAds as $item)
                <div class="card swiper-slide rounded-circle  m-2 "  style="" >

                    <div class="card-img-top mx-auto" style="max-height:8rem">
                        <img class=" mx-auto" src="{{ asset("img/dash/profile.webp") }}" alt="">
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</div>


<script>
    // var swiper3 = new Swiper(".mySwiper3", {
    // slidesPerView: 1,
    // spaceBetween: 1,
    // freeMode: true,
    // pagination: {
    // el: ".swiper-pagination",
    // clickable: true,
    // },
    // breakpoints: {

    // },
    // });
</script>
