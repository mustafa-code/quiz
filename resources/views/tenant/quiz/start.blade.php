<x-app-layout>

    <x-slot name="title">
        {{ __('Tenant') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tenant Dashboard') }}
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
                                    {{ __('Quiz') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Take a deep breath and answer all the questions bellow.") }}
                                </p>
                            </div>

                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Time') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Time") }}
                                </p>
                            </div>
                        </header>

                        <x-alert class="mb-8" />

                        @include('tenant.quiz.partials.questions')

                    </section>
                    
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
