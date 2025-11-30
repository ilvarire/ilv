<div class="flex-w flex-tr">
    <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
        <form wire:submit.prevent="sendMail" method="post">
            <h4 class="mtext-105 cl2 txt-center p-b-30">
                Send Us A Message
            </h4>

            <div class="bor8 m-b-20 how-pos4-parent">
                <input class="stext-111 cl2 bg0 plh3 size-116 p-l-62 p-r-30" type="text" wire:model="email"
                    placeholder="Your Email Address" required>
                <img class="how-pos4 pointer-none" src="images/icons/icon-email.png" alt="ICON">
            </div>
            @error ('email')
                <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
            @enderror

            <div class="bor8 m-b-30">
                <textarea class="stext-111 bg0 cl2 plh3 size-120 p-lr-28 p-tb-25" wire:model="message"
                    placeholder="How Can We Help?"></textarea>
            </div>
            @error ('message')
                <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
            @enderror

            <button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                Submit
            </button>
            @if (session('status') === 'mail-sent')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="m-t-4" style="text-align: center; color: seagreen;">
                    {{ __('Message sent.') }}
                </p>
            @endif
        </form>
    </div>

    <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">


        <div class="flex-w w-full p-b-42">
            <span class="fs-18 cl5 txt-center size-211">
                <span class="lnr lnr-phone-handset"></span>
            </span>

            <div class="size-212 p-t-2">
                <span class="mtext-110 cl2">
                    Lets Talk
                </span>

                <p class="stext-115 cl1 size-213 p-t-18">
                    {{ $contact->phone_number }}
                </p>
            </div>
        </div>

        <div class="flex-w w-full">
            <span class="fs-18 cl5 txt-center size-211">
                <span class="lnr lnr-envelope"></span>
            </span>

            <div class="size-212 p-t-2">
                <span class="mtext-110 cl2">
                    Sale Support
                </span>

                <p class="stext-115 cl1 size-213 p-t-18">
                    {{ $contact->email }}
                </p>
            </div>
        </div>
    </div>
</div>