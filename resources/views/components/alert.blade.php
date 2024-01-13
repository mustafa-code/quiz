@if (session('message'))
    <div {!! $attributes !!} x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">{{ __('Success') }}!</strong>
                <span class="block sm:inline">{{ session('message') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.859l-4.708-4.708 4.708-4.708a1.002 1.002 0 0 0-1.414-1.414l-4.708 4.708-4.708-4.708a1.002 1.002 0 1 0-1.414 1.414l4.708 4.708-4.708 4.708a1.002 1.002 0 1 0 1.414 1.414l4.708-4.708 4.708 4.708a1.002 1.002 0 0 0 1.414-1.414z" />
                    </svg>
                </span>
            </div>
        @endif
        @if (!session('success') || $errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">{{ __('Error') }}!</strong>
                <span class="block sm:inline">
                    @if (session('message'))
                        {{ session('message') }}
                    @else
                        {{ __('Please check the form for errors.') }}
                    @endif
                </span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.859l-4.708-4.708 4.708-4.708a1.002 1.002 0 0 0-1.414-1.414l-4.708 4.708-4.708-4.708a1.002 1.002 0 1 0-1.414 1.414l4.708 4.708-4.708 4.708a1.002 1.002 0 1 0 1.414 1.414l4.708-4.708 4.708 4.708a1.002 1.002 0 0 0 1.414-1.414z" />
                    </svg>
                </span>
            </div>
        @endif
    </div>
@endif
