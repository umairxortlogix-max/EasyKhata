<div class="min-h-screen flex items-center justify-center bg-gray-100 py-10">
    <section class="w-full max-w-2xl p-8 rounded-3xl bg-gray-100 shadow-[10px_10px_20px_#d1d5db,-10px_-10px_20px_#ffffff] border border-gray-200">

        <!-- Header -->
        <header class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-gray-800 drop-shadow-sm">
                {{ __('Profile Information') }}
            </h2>
            <p class="mt-2 text-sm text-gray-500">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </header>

        <!-- Email Verification Form -->
        <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <!-- Profile Update Form -->
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            <!-- Name -->
            <div class="p-4 rounded-2xl bg-gray-100 shadow-[inset_4px_4px_8px_#d1d5db,inset_-4px_-4px_8px_#ffffff]">
                <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-semibold" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-2 block w-full rounded-xl border-none focus:ring-2 focus:ring-indigo-400 bg-gray-100 text-gray-800"
                    :value="old('name', $user->name)"
                    required
                    autofocus
                    autocomplete="name"
                />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="p-4 rounded-2xl bg-gray-100 shadow-[inset_4px_4px_8px_#d1d5db,inset_-4px_-4px_8px_#ffffff]">
                <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold" />
                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    class="mt-2 block w-full rounded-xl border-none focus:ring-2 focus:ring-indigo-400 bg-gray-100 text-gray-800"
                    :value="old('email', $user->email)"
                    required
                    autocomplete="username"
                />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-3 rounded-xl bg-gray-100 shadow-[inset_4px_4px_8px_#d1d5db,inset_-4px_-4px_8px_#ffffff]">
                        <p class="text-sm text-gray-700">
                            {{ __('Your email address is unverified.') }}
                        </p>
                        <button
                            form="send-verification"
                            class="mt-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 underline"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm text-green-600 font-medium">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Phone Number (optional field example) -->
            <div class="p-4 rounded-2xl bg-gray-100 shadow-[inset_4px_4px_8px_#d1d5db,inset_-4px_-4px_8px_#ffffff]">
                <x-input-label for="phone" :value="__('Phone Number')" class="text-gray-700 font-semibold" />
                <input
                    id="phone"
                    name="phone"
                    type="text"
                    class="mt-2 block w-full rounded-xl border-none focus:ring-2 focus:ring-indigo-400 bg-gray-100 text-gray-800 shadow-inner px-3 py-2"
                    placeholder="+92 300 1234567"
                />
            </div>

            <!-- Save Button -->
            <div class="flex items-center justify-center gap-4 pt-4">
                <button
                    type="submit"
                    class="px-8 py-3 rounded-2xl font-semibold text-gray-700 bg-gray-100 shadow-[6px_6px_12px_#d1d5db,-6px_-6px_12px_#ffffff] hover:shadow-[inset_6px_6px_12px_#d1d5db,inset_-6px_-6px_12px_#ffffff] transition-all duration-200"
                >
                    {{ __('Save Changes') }}
                </button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600"
                    >
                        {{ __('Saved successfully!') }}
                    </p>
                @endif
            </div>
        </form>
    </section>
</div>
