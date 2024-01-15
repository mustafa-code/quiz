<x-app-layout>

    <x-slot name="title">
        {{ __('Result') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quiz Result') }}
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
                                    {{ __('Quiz') }}: {{ $quizAttempt->quiz->title }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Here is your result in the quiz") }}
                                </p>
                            </div>
                        </header>

                        <hr class="mb-8">
                        
                        <x-alert class="mb-8" />

                        {{-- Check if shoudStart --}}
                        <div class="text-center">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-8">
                                {{ __('Quiz Finished') }}
                            </h2>

                            <div class="grid grid-cols-2 grid-flow-row gap-4 mt-2 px-8">
                                <div class="text-center">
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Score') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $quizAttempt->score }} / {{ $quizAttempt->quiz->questions->count() }}
                                    </p>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Time') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $quizAttempt->duration }} {{ __('seconds') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="mt-4">
                            @include('tenant.quiz.partials.questions', ['quizAttempt' => $quizAttempt])
                        </div> --}}

                    </section>
                    
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
