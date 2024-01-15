{{-- <div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="block text-gray-700 text-lg font-bold mb-2">Quiz Title</h2>
        

    </div>
</div> --}}


<!-- Quiz Form Start -->
<form action="/submit-quiz" method="POST">

    <!-- Loop through questions -->
    @for ($i = 0; $i < 8; $i++)
        <div class="mb-4">
            <p class="text-gray-600">{{ ($i + 1) }}. Question text here?</p>
            <div class="mt-2">
                <!-- Loop through choices for each question -->
                @for ($j = 0; $j < 4; $j++)
                <label class="block">
                    <input type="radio" name="question1" value="choice1" class="mr-2">
                    Choice {{ ($j + 1) }}
                </label>
                @endfor
            </div>
        </div>
    @endfor

    <!-- More questions... -->

    <!-- Submit Button -->
    <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Submit Quiz
        </button>
    </div>
</form>
<!-- Quiz Form End -->
