<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tenants') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="">
                    <section>
                        <header class="flex justify-between items-center mb-8">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Create Tenant') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Add new tenant") }}
                                </p>
                            </div>
                    
                            <a href="{{ route("tenants.index") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Back') }}
                            </a>
                        </header>

                        <form method="post" action="{{ route('tenants.store') }}" class="mt-6 space-y-6">
                            @csrf
                    
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="domain" :value="__('Domain')" />
                                <x-text-input id="domain" name="domain" type="text" class="mt-1 block w-full" :value="old('domain')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('domain')" />
                            </div>

                            <div>
                                <x-input-label for="user_id" :value="__('Owner')" />
                                <x-select-options id="user_id" name="user_id" :options="$users" :value="old('user_id')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    
                    </section>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
