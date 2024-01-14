@props(['name', 'options', 'selected' => null])

<div class="flex items-center mb-4">
    @foreach ($options as $option)
        <input id="{{ $name }}_{{ $option["id"] }}" type="radio" name="{{ $name }}" 
        value="{{ $option["id"] }}" class="mr-2" {{ old($name, $selected) == $option["id"] ? 'checked' : '' }}>
        <label for="{{ $name }}_{{ $option["id"] }}" class="mr-4">
            {{ $option["name"] }}
        </label>
    @endforeach
</div>