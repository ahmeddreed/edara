<div dir="rtl">
    <div class="row my-5">
        <h3 class="color fw-bold">{{ $category->name }}</h3>
        <div class="col-lg-12 bg rounded p-3">
            <div class="row">

                @foreach ($category->materials() as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 my-3 ">
                        <div class="card shadow">
                            <div class="card-body">
                                <img class="card-img-top mx-auto" src="{{ asset("img/dash/profile.webp") }}" alt="">
                                <div class="d-flex justify-content-center">
                                    <p class="color p-2 mt-2 fw-bold fs-4">
                                        {{ $item->title }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
</div>
