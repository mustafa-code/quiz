<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Questions') }}
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
                                    {{ __('Questions List') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Manage all questions in the system") }}
                                </p>
                            </div>
                    
                            <a href="{{ route("questions.create") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create') }}
                            </a>
                        </header>

                        <x-alert class="mb-8" />

                        <!-- Quizzes Table -->
                        <table class="min-w-full leading-normal mb-4">
                            <thead>
                                <tr>
                                    <x-table-head>#</x-table-head>
                                    <x-table-head>{{ __("Tenant") }}</x-table-head>
                                    <x-table-head>{{ __("Quiz") }}</x-table-head>
                                    <x-table-head>{{ __("Question") }}</x-table-head>
                                    <x-table-head>{{ __("Slug") }}</x-table-head>
                                    <x-table-head>{{ __("Creation Date") }}</x-table-head>
                                    <x-table-head>{{ __("Actions") }}</x-table-head>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($questions as $key => $question)
                                    <tr>
                                        <x-table-data>{{ ($key + 1) }}</x-table-data>
                                        <x-table-data>{{ $question->tenant->name }}</x-table-data>
                                        <x-table-data>{{ $question->quiz->title }}</x-table-data>
                                        <x-table-data>{{ $question->question }}</x-table-data>
                                        <x-table-data>{{ $question->slug }}</x-table-data>
                                        <x-table-data>{{ $question->created_at }}</x-table-data>
                                        <x-table-data>
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                        {{ __("Actions") }}
                                                    </button>
                                                </x-slot>
                            
                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('questions.edit', $question->id)">
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>
                                                    <!-- Authentication -->
                                                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-dropdown-link :href="route('logout')"
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
                                        <x-table-data colspan="6" class="text-center">
                                            {{ __("No questions found") }}
                                        </x-table-data>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $questions->links() }}

                    </section>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
