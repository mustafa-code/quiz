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
                                    {{ __('Tenants List') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Manage all tenants in the system") }}
                                </p>
                            </div>
                    
                            <a href="{{ route("tenants.create") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create') }}
                            </a>
                        </header>

                        <x-alert class="mb-8" />

                        <!-- Tenants Table -->
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <x-table-head>
                                        #
                                    </x-table-head>
                                    <x-table-head>
                                        {{ __("Name") }}
                                    </x-table-head>
                                    <x-table-head>
                                        {{ __("Domain") }}
                                    </x-table-head>
                                    <x-table-head>
                                        {{ __("Actions") }}
                                    </x-table-head>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tenants as $key => $tenant)
                                    <tr>
                                        <x-table-data>
                                            {{ ($key + 1) }}
                                        </x-table-data>
                                        <x-table-data>
                                            {{ $tenant->name }}
                                        </x-table-data>
                                        <x-table-data>
                                            {{ $tenant->domains->first()->domain }}
                                        </x-table-data>
                                        <x-table-data>
                                            <a href="{{ route('tenants.edit', $tenant->id) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ __("Edit") }}
                                            </a>
                                            <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    {{ __("Delete") }}
                                                </button>
                                        </x-table-data>
                                    </tr>
                                @empty
                                    <tr>
                                        <x-table-data colspan="4" class="text-center">
                                            {{ __("No tenants found") }}
                                        </x-table-data>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </section>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
