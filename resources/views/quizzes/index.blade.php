<x-app-layout>
    <x-slot name="title">
        {{ __('Quizzes') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quizzes') }}
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
                                    {{ __("Manage all quizzes in the system") }}
                                </p>
                            </div>
                    
                            <a href="{{ route("quizzes.create") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create') }}
                            </a>
                        </header>

                        <x-alert class="mb-8" />

                        <!-- Quizzes Table -->
                        <table class="min-w-full leading-normal mb-4">
                            <thead>
                                <tr>
                                    <x-table-head>#</x-table-head>
                                    <x-table-head>{{ __("Title") }}</x-table-head>
                                    <x-table-head>{{ __("Slug") }}</x-table-head>
                                    <x-table-head>{{ __("Tenant") }}</x-table-head>
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
                                        <x-table-data>{{ $quiz->tenant->name }}</x-table-data>
                                        <x-table-data>{{ $quiz->quiz_type_name }}</x-table-data>
                                        <x-table-data>{{ $quiz->start_time ?: "-" }}</x-table-data>
                                        <x-table-data>{{ $quiz->end_time ?: "-" }}</x-table-data>
                                        <x-table-data>
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <x-secondary-button>{{ __("Actions") }}</x-secondary-button>
                                                </x-slot>
                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('quizzes.edit', $quiz->id)">
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>
                                                    <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-dropdown-link href="javascript:;"
                                                                onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                                                            {{ __('Delete') }}
                                                        </x-dropdown-link>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </x-table-data>
                                    </tr>
                                @empty
                                    <tr>
                                        <x-table-data colspan="8" class="text-center">
                                            {{ __("No quizzes found") }}
                                        </x-table-data>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $quizzes->links() }}

                    </section>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
