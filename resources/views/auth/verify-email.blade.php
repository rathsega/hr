<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="#">
                <img class="mb-4" width="220px" src="{{ get_image(get_settings('dark_logo')) }}">
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ get_phrase('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ get_phrase('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ get_phrase('Resend Verification Email') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ get_phrase('Log Out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
