<x-layouts.customer-layout :title="'Policy'">
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-06.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Policy
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <div class="container">
            <div class="row p-b-148">
                <div class="col-md-7 col-lg-12">
                    <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                        <h3 class="mtext-111 cl2 p-b-16 txt-center">
                            Our Policy
                        </h3>

                        <p class="stext-113 cl6 p-b-26">
                            {{ $policy->policy}}
                        </p>
                    </div>
                </div>


            </div>
        </div>
    </section>

</x-layouts.customer-layout>