<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('submit-otp') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email_otp" :value="__('Enter Email OTP')" />
            <x-text-input id="email_otp" class="block mt-1 w-full" type="text" name="email_otp" :value="old('email_otp')" autofocus autocomplete="" />
            <x-input-error :messages="$errors->get('email_otp')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
