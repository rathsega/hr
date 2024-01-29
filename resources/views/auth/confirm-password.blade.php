<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="#">
                <img class="mb-4" width="220px" src="{{ get_image(get_settings('dark_logo')) }}">
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ get_phrase('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="get_phrase('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button>
                    {{ get_phrase('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
