<div dir="rtl" class="w-100">
    <div class="row">
        <div class="col-lg-12 mx-auto my-5 ">
            <div class="card shadow ">
                <div class="card-body bg d-flex justify-content-between rounded">
                    <form class="row g-3">
                        <div class="col-lg-10">
                          <label for="inputPassword2" class="visually-hidden">البحث</label>
                          <input wire:model.live.debounce.100ms='search' type="search" class="form-control" placeholder="البحث...">
                        </div>
                    </form>
                    <form action="" method="post" class="d-flex ">
                        <div class="row g-2 mx-2">
                            <select wire:model.live.debounce.10ms='section_id' class="form-select" aria-label="Default select example">
                                <option value> كل الاقسام</option>
                                @foreach ($section as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($categories->count() > 0)
                            <div class="row g-2 mx-2">
                                <select wire:model.live.debounce.10ms='category_id' class="form-select" aria-label="Default select example">
                                    @if($section_id == null and $category_id == null)
                                    <option value> كل الفئات </option>
                                    @endif
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

    </div>


    <div class="contaier my-5">
        <div class="row d-flex justify-center">
        @foreach($materials as $item)
            <div class="col-lg-4 col-md-6 col-sm-12 py-2">
                <div class="card  mx-auto" style="width: 18rem;">
                    <img style="width: 18rem;height: 10rem;" src="{{ asset($item->image) }}" class="card-img-top" alt="">
                    <div class="card-body m-2">
                    <h5 class="card-title mb-3">{{ $item->title }}</h5>
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route("detaile",["id"=>$item->id]) }}" class="btn btn-info fw-bold text-light">التفاصيل</a>
                            <a href="{{ route("detaile",["id"=>$item->id]) }}" class="btn btn-success fw-bold text-light">شراء</a>
                        </div>

                        <span class="color fw-bold fs-5">{{ $item->price }}$</span>
                    </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-5 ">
            {{ $materials->links() }}
        </div>

        </div>

    </div>

</div>


