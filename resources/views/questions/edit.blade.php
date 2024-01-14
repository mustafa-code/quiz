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
                                    {{ __('Edit question') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Edit question data") }}
                                </p>
                            </div>
                    
                            <a href="{{ route("questions.index") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Back') }}
                            </a>
                        </header>
                        
                        <x-alert class="mb-8" />

                        <div x-data="quizSelector(@js($question->tenant_id), @js($question->quiz_id))">
                            <form method="post" action="{{ route('questions.update', $question) }}" class="mt-6 space-y-6">
                                @csrf
                                @method('PUT')

                                <div>
                                    <x-input-label for="question" :value="__('Question')" />
                                    <x-text-input id="question" name="question" type="text" class="mt-1 block w-full" :value="old('question', $question->question)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('question')" />
                                </div>

                                <div>
                                    <x-input-label for="slug" :value="__('Slug')" />
                                    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $question->slug)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                                </div>

                                <div>
                                    <x-input-label for="tenant_id" :value="__('Tenant')" />
                                    <x-select-options id="tenant_id" name="tenant_id" class="mt-1 block w-full" :options="$tenants" x-model="selectedTenant" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('tenant_id')" />
                                </div>

                                <div>
                                    <x-input-label for="quiz_id" :value="__('Quiz')" />
                                    <x-select-options id="quiz_id" name="quiz_id" class="mt-1 block w-full" x-model="selectedQuiz" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('quiz_id')" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-text-area id="description" name="description" class="mt-1 block w-full" :value="old('description', $question->description)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>



                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Edit') }}</x-primary-button>
                                </div>
                            </form>
                        </div>
                    
                    </section>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
