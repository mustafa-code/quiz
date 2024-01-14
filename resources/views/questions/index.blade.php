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
                                        <x-table-data>{{ $question->quiz->title }}</x-table-data>
                                        <x-table-data>{{ $question->question }}</x-table-data>
                                        <x-table-data>{{ $question->slug }}</x-table-data>
                                        <x-table-data>{{ $question->created_at }}</x-table-data>
                                        <x-table-data>
                                            <a href="{{ route('questions.edit', $question->id) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ __("Edit") }}
                                            </a>
                                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    {{ __("Delete") }}
                                                </button>
                                            </form>
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
