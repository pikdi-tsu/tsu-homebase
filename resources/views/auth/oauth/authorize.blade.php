{{-- resources/views/auth/oauth/authorize.blade.php --}}
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-center">
            <h1 class="text-xl font-bold">Otorisasi Aplikasi</h1>
            <p class="text-sm text-gray-600">
                Aplikasi <strong>{{ $client->name }}</strong> meminta izin untuk mengakses akun Anda.
            </p>
        </div>

        {{-- Form Otorisasi --}}
        <form method="post" action="{{ route('passport.authorizations.approve') }}" class="space-y-6">
            @csrf

            <input type="hidden" name="auth_token" value="{{ $authToken }}">

            <input type="hidden" name="state" value="{{ request('state') }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">

            {{-- Daftar Izin (Scopes) yang diminta --}}
            @if (count($scopes) > 0)
                <div class="space-y-2">
                    <label class="font-medium text-sm text-gray-700">Aplikasi ini meminta izin untuk:</label>
                    <ul class="list-disc list-inside text-sm text-gray-600">
                        @foreach ($scopes as $scope)
                            <li>{{ $scope->description }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex items-center justify-center mt-4">
                {{-- Tombol Deny --}}
                <button type="submit" name="authorization" value="deny" class="underline text-sm text-gray-600 hover:text-gray-900 mr-4">
                    Tolak
                </button>

                {{-- Tombol Approve --}}
                <x-button type="submit" name="authorization" value="approve">
                    Izinkan
                </x-button>
            </div>
        </form>

    </x-authentication-card>
</x-guest-layout>
