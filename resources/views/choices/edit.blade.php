<x-app-layout>

    <x-slot name="title">
        {{ __('Edit Choice') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Choices') }}
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
                                    {{ __('Edit Choice') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Edit choice data") }}
                                </p>
                            </div>
                    
                            <a href="{{ route("questions.choices.index", $question) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Back') }}
                            </a>
                        </header>
                        
                        <x-alert class="mb-8" />

                        <div>
                            <form method="post" action="{{ route('questions.choices.update', [$question, $choice]) }}" class="mt-6 space-y-6">
                                @csrf
                                @method('PUT')

                                <div>
                                    <x-input-label for="title" :value="__('Title')" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $choice->title)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>

                                <div>
                                    <x-input-label for="order" :value="__('Order')" />
                                    <x-text-input id="order" name="order" type="number" class="mt-1 block w-full" :value="old('order', $choice->order)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                                </div>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="is_correct" name="is_correct" class="form-checkbox w-5 h-5 text-blue-600 rounded" value="1" {{ old('is_correct', $choice->is_correct) ? "checked": "" }} />
                                        <span class="ml-2">{{ __('Correct') }}</span>
                                    </label>
                                    <x-input-error class="mt-2" :messages="$errors->get('is_correct')" />
                                </div>

                                <div>
                                    <x-input-label for="explanation" :value="__('Explanation')" />
                                    <x-text-area id="explanation" name="explanation" class="mt-1 block w-full" :value="old('explanation', $choice->explanation)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('explanation')" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-text-area id="description" name="description" class="mt-1 block w-full" :value="old('description', $choice->description)" />
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
