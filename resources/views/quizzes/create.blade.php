<x-app-layout>
    <x-slot name="title">
        {{ __('Create Quiz') }}
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
                                    {{ __('Create Quiz') }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Add new quiz") }}
                                </p>
                            </div>
                    
                            <a href="{{ route("quizzes.index") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Back') }}
                            </a>
                        </header>

                        <x-alert class="mb-8" />

                        <div x-data="{ quizType: '{{ old('quiz_type', 'out-of-time') }}' }">
                            <form method="post" action="{{ route('quizzes.store') }}" class="mt-6 space-y-6">
                                @csrf
                        
                                <div>
                                    <x-input-label for="title" :value="__('Title')" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>

                                <div>
                                    <x-input-label for="slug" :value="__('Slug')" />
                                    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                                </div>

                                <div>
                                    <x-input-label for="tenant_id" :value="__('Tenant')" />
                                    <x-select-options id="tenant_id" name="tenant_id" class="mt-1 block w-full" :options="$tenants" :value="old('tenant_id')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('tenant_id')" />
                                </div>

                                <!-- Quiz Type Selection -->
                                <div class="mb-4">
                                    <x-input-label :value="__('Quiz Type')" />
                                    <div class="flex items-center mb-4">
                                        @foreach ($quizTypeOptions as $option)
                                            <input id="quiz_type_{{ $option["id"] }}" type="radio" name="quiz_type" 
                                            value="{{ $option["id"] }}" class="mr-2" {{ old('quiz_type') == $option["id"] ? 'checked' : '' }} x-model="quizType">
                                            <label for="quiz_type_{{ $option["id"] }}" class="mr-4">
                                                {{ $option["name"] }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('quiz_type')" />
                                </div>

                                <!-- Start Time -->
                                <div class="mb-4" x-show="quizType === 'in-time'">
                                    <x-input-label for="start_time" :value="__('Start Time')" />
                                    <x-text-input id="start_time" name="start_time" type="datetime-local" class="mt-1 block w-full" :value="old('start_time')" ::required="quizType === 'in-time'" />
                                    <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                                </div>

                                <!-- End Time -->
                                <div class="mb-6" x-show="quizType === 'in-time'">
                                    <x-input-label for="end_time" :value="__('End Time')" />
                                    <x-text-input id="end_time" name="end_time" type="datetime-local" class="mt-1 block w-full" :value="old('end_time')" ::required="quizType === 'in-time'" />
                                    <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-text-area id="description" name="description" class="mt-1 block w-full" :value="old('description')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                </div>
                            </form>
                        </div>

                    </section>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
