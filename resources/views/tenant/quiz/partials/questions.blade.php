<!-- Quiz Form Start -->
<form action="/submit-quiz" method="POST">

    <!-- Loop through questions -->
    @foreach ($quiz->questions as $key => $question)
        <div class="mb-4">
            <p class="text-gray-600">{{ ($key + 1) }}. {{ $question->question }}</p>
            <div class="grid grid-cols-2 grid-flow-row gap-4 mt-2 px-8">
                <!-- Loop through choices for each question -->
                @foreach ($question->choices as $choice)
                <label class="block">
                    <input type="radio" name="question1" value="choice1" class="mr-2">
                    {{ $choice->title }}
                </label>
                @endforeach
            </div>
        </div>
    @endforeach
    <!-- More questions... -->

    <!-- Submit Button -->
    <div class="flex items-center justify-between">
        <x-primary-button>{{ __('Submit Quiz') }}</x-primary-button>
    </div>
</form>
<!-- Quiz Form End -->
