<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-xl">
                    Vitaj, {{ $user->name }}!
                </div>

                @if(!$user->secret_key)
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Nastav si 2FA v Google Authenticator:

                        <div class="p-6">
                        {!! (new PragmaRX\Google2FAQRCode\Google2FA)->getQRCodeInline('laravel', $user->email, $secret_key) !!}
                        </div>


                        <form action="{{ route('dashboard.save') }}" method="POST" class="mb-4">
                            @csrf

                            <input type="hidden" name="secret_key" value="{{ $secret_key }}">

                            <x-input-label for="2fa" value="Zadaj 2FA kód pre uloženie:" />

                            <x-text-input id="2fa" class="mt-1"
                                          type="text"
                                          name="code"
                                          require />

                            <x-input-error :messages="$errors->get('2fa')" class="mt-2" />

                            <x-secondary-button>
                                Uložiť
                            </x-secondary-button>
                        </form>

                        <p>Manuálne nastavenie: {{ $secret_key }}</p>
                    </div>
                @else
                    <div class="p-6 pt-2 text-gray-900 dark:text-gray-100">
                        <p>2FA je už nastavené.</p>

                        <form action="{{ route('dashboard.delete') }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')

                            <x-danger-button>
                                Zmazať
                            </x-danger-button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
