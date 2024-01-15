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

                            @if ($quizSubscriber->shouldStart())
                                <div class="text-center	">
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('15:20') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __("Time") }}
                                    </p>
                                </div>
                            @endif
                        </header>

                        <hr class="mb-8">
                        
                        <x-alert class="mb-8" />

                        {{-- Check if shoudStart --}}
                        @if ($quizSubscriber->shouldStart())
                            @include('tenant.quiz.partials.questions')
                        @else
                            <div class="text-center">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-8">
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $attendTime = \Carbon\Carbon::parse($quizSubscriber->attend_time);
                                        $minutesToStart = $attendTime->diffInMinutes($now, false);
                                    @endphp
                                    
                                    {{ __('Quiz will start in') }} {{ $minutesToStart }} {{ __('minutes') }}
                                </h2>

                                <a href="" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Start the Quiz') }}
                                </a>
    
                            </div>
                        @endif

                    </section>
                    
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
