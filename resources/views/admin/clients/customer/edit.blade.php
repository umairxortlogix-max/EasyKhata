<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.clients.customer.update', $customer->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $customer->name)" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="phone" :value="__('Phone')" />
                            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $customer->phone)" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="address" :value="__('Address')" />
                            <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $customer->address)" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="company_name" :value="__('Company Name')" />
                            <x-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name', $customer->company_name)" />
                        </div>

                        <div class="mt-4">
                            <x-label for="tax_number" :value="__('Tax Number')" />

</x-app-layout>