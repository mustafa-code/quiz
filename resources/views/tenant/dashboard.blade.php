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
                                    {{ __('Quizzes List') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Explore all quizzes in the system and Subscribe to any quiz you want") }}
                                </p>
                            </div>
                        </header>

                        <x-alert class="mb-8" />

                        <!-- Quizzes Table -->
                        <div x-data="{ action: '{{ session('quiz_id') ? route('quiz.subscribe', session('quiz_id')) : "" }}' }">
                            <table class="min-w-full leading-normal mb-4">
                                <thead>
                                    <tr>
                                        <x-table-head>#</x-table-head>
                                        <x-table-head>{{ __("Title") }}</x-table-head>
                                        <x-table-head>{{ __("Slug") }}</x-table-head>
                                        <x-table-head>{{ __("Quiz Type") }}</x-table-head>
                                        <x-table-head>{{ __("Start At") }}</x-table-head>
                                        <x-table-head>{{ __("End At") }}</x-table-head>
                                        <x-table-head>{{ __("Actions") }}</x-table-head>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($quizzes as $key => $quiz)
                                        <tr>
                                            <x-table-data>{{ ($key + 1) }}</x-table-data>
                                            <x-table-data>{{ $quiz->title }}</x-table-data>
                                            <x-table-data>{{ $quiz->slug }}</x-table-data>
                                            <x-table-data>{{ $quiz->quiz_type_name }}</x-table-data>
                                            <x-table-data>{{ $quiz->start_time ?: "-" }}</x-table-data>
                                            <x-table-data>{{ $quiz->end_time ?: "-" }}</x-table-data>
                                            <x-table-data>
                                                @if ($quiz->is_subscribed)
                                                    <a href="{{ route("quiz.un_subscribe", $quiz) }}" class="bg-gray-500 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                                                        {{ __('Un Subscribe') }}
                                                    </a>
                                                @elseif ($quiz->is_subscribable)
                                                    <x-secondary-button
                                                    x-on:click.prevent="action = '{{ route('quiz.subscribe', $quiz) }}'; $dispatch('open-modal', 'quiz-subscription-modal')"
                                                    >{{ __('Subscribe') }}</x-secondary-button>
                                                @else
                                                    <span>{{ __("Closed") }}</span>
                                                @endif
                                            </x-table-data>
                                        </tr>
                                    @empty
                                        <tr>
                                            <x-table-data colspan="7" class="text-center">
                                                {{ __("No quizzes found") }}
                                            </x-table-data>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        
                            <x-modal name="quiz-subscription-modal" :show="$errors->quizSubscription->isNotEmpty()" focusable>
                                <form method="post" :action="action" class="p-6">
                                    @csrf
                        
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Select the date you want to attend the quiz at!') }}
                                    </h2>
                        
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Once you select the date, an invitation will be sent to your email with the date you select.') }}
                                    </p>
                        
                                    <div class="mt-6">
                                        <x-input-label for="attend_time" value="{{ __('Attend time') }}" class="sr-only" />
                                        <x-text-input 
                                            id="attend_time" name="attend_time" 
                                            type="datetime-local" class="mt-1 block w-3/4" 
                                            :value="old('attend_time')" :required="true"
                                            placeholder="{{ __('Attend time') }}"
                                            />
                                        <x-input-error :messages="$errors->quizSubscription->get('attend_time')" class="mt-2" />
                                    </div>
                        
                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>
                        
                                        <x-primary-button class="ms-3">
                                            {{ __('Subscribe') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </x-modal>
                        </div>
                

                        {{ $quizzes->links() }}

                    </section>
                    
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
