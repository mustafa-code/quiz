<x-app-layout>
    <x-slot name="title">
        {{ __('Choices') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Choices') }}: {{ $question->question }}
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
                                    {{ __('Choices List') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Manage all choices in this question") }}
                                </p>
                            </div>
                    
                            <a href="{{ route("questions.choices.create", $question) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
                                    <x-table-head>{{ __("Correct") }}</x-table-head>
                                    <x-table-head>{{ __("Order") }}</x-table-head>
                                    <x-table-head>{{ __("Creation Date") }}</x-table-head>
                                    <x-table-head>{{ __("Actions") }}</x-table-head>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($choices as $key => $choice)
                                    <tr>
                                        <x-table-data>{{ ($key + 1) }}</x-table-data>
                                        <x-table-data>{{ $choice->title }}</x-table-data>
                                        <x-table-data>{{ $choice->is_correct ? "Correct": "Not Correct" }}</x-table-data>
                                        <x-table-data>{{ $choice->order }}</x-table-data>
                                        <x-table-data>{{ $choice->created_at }}</x-table-data>
                                        <x-table-data>
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <x-secondary-button>{{ __("Actions") }}</x-secondary-button>
                                                </x-slot>
                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('questions.choices.edit', $choice->id)">
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>
                                                    <form action="{{ route('questions.choices.destroy', $choice->id) }}" method="POST" class="inline-block">
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
                                        <x-table-data colspan="6" class="text-center">
                                            {{ __("No choices found") }}
                                        </x-table-data>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $choices->links() }}

                    </section>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
