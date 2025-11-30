<div>
    <form wire:submit.prevent="updateProfile" method="post" id="profile" class="bg0 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Profile information
                        </h4>
                        <p class="stext-111 cl6 p-t-2">
                            Update your account's profile information.
                        </p>
                        <input class="flex-c-m stext-104 cl2 bg0 plh4 size-116 bor13 p-lr-20 m-r-10 m-tb-8" type="text"
                            wire:model.defer="name" placeholder="Name">
                        @error ('name')
                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                        @enderror

                        <input wire:model.defer="email"
                            class="flex-c-m stext-104 cl2 plh4 bg0 size-116 bor13 p-lr-20 m-r-10 m-tb-8" type="email"
                            placeholder="Email" disabled>
                        @error ('email')
                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                        @enderror

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 mb-2" style="color: seagreen">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                        <button type="submit" wire:loading.class="bg8"
                            wire:loading.remove.class="pointer bg3 hov-btn3 trans-04"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            <span wire:loading.remove>Save</span>
                            <span class="cl2" wire:loading>
                                <i class="zmdi zmdi-refresh zmdi-hc-spin"></i>
                            </span>
                        </button>
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2000)" class="m-t-4"
                                style="text-align: center; color: seagreen;">
                                {{ __('Saved.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Update password -->
    <form wire:submit.prevent="updatePassword" method="post" id="password">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Update Password
                        </h4>
                        <p class="stext-111 cl6 p-t-2">
                            Ensure your account is using a long, random password to stay secure.
                        </p>
                        @if (session('success'))
                            <h3 class="stext-111 cl6 p-t-2" style="color: seagreen">{{session('success')}}</h3>
                        @endif
                        <input class="flex-c-m stext-104 bg0 cl2 plh4 size-116 bor13 p-lr-20 m-r-10 m-tb-8"
                            type="password" wire:model="current_password" placeholder="Old Password">
                        @error ('current_password')
                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                        @enderror

                        <input class="flex-c-m stext-104 bg0 cl2 plh4 size-116 bor13 p-lr-20 m-r-10 m-tb-8"
                            type="password" wire:model="password" placeholder="New Password">
                        @error ('password')
                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                        @enderror

                        <input wire:model.defer="password_confirmation"
                            class="flex-c-m stext-104 bg0 cl2 plh4 size-116 bor13 p-lr-20 m-r-10 m-tb-8" type="password"
                            placeholder="Confirm Password">
                        @error ('password_confirmation')
                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                        @enderror

                        <button type="submit" wire:loading.class="bg8"
                            wire:loading.remove.class="pointer bg3 hov-btn3 trans-04"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            <span wire:loading.remove>Save</span>
                            <span class="cl2" wire:loading>
                                <i class="zmdi zmdi-refresh zmdi-hc-spin"></i>
                            </span>
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2000)" class="m-t-4"
                                style="text-align: center; color: seagreen;">
                                {{ __('Saved.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>