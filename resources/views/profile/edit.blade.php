<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent leading-tight">
            👤 {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-gradient-to-br from-white to-indigo-50 dark:from-gray-800 dark:to-gray-750 shadow-lg sm:rounded-2xl border border-indigo-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gradient-to-br from-white to-purple-50 dark:from-gray-800 dark:to-gray-750 shadow-lg sm:rounded-2xl border border-purple-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gradient-to-br from-white to-red-50 dark:from-gray-800 dark:to-gray-750 shadow-lg sm:rounded-2xl border border-red-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
