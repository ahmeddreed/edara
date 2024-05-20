@props([
    'title'=>"tilte",
    "des"=>"الوصف"

])


<div class="bg">
    <div class="row container p-3">
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
    </div>
</div>
