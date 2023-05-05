<x-guest-layout>
    <form method="POST">
        @csrf

        <!-- Code -->
        <div>
            <x-input-label for="otp_code" value="2FA kód" />
            <x-text-input id="otp_code" class="block mt-1 w-full" type="text" name="otp_code" required autofocus />
            <x-input-error :messages="$errors->first('message')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-3">
                Odoslať
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
