@props([
    'settingsData'=>[],
])

@if (!request()->routeIs("login"))
    <div dir="rtl" class="mt-5 w-100">
        <footer class="bg fs-lg-4 fs-md-5 fw-bold p-3">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-sm-11 mt-3">
                    <p class="text-center mt-3">
                    {{  $settingsData->title }}
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-11 mt-3">
                    <p class="text-center mt-3">
                        {{  $settingsData->copy_right }}
                    </p>
                </div>


                <div class="col-lg-4 col-md-6 col-sm-11 mt-3 mx-auto">
                    <p class="">
                        <div dir="ltr" class="d-flex justify-content-center mb-3">
                            ارقام التواصل
                        </div>
                        <div class="d-flex justify-content-center">
                        {{  $settingsData->phone1 }} - {{  $settingsData->phone2 }}
                        </div>
                    </p>
                </div>

            </div>

        </footer>
    </div>
@endif
