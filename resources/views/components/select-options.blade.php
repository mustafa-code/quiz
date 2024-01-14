@props(['disabled' => false, 'options' => [], 'value' => ''])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    <option value="" disabled hidden {{ $value? "": "selected" }}>{{ __('Select an option') }}</option>
    @foreach ($options as $option)
        <option value="{{ $option['id'] }}" {{ $value == $option["id"] ? "selected": "" }}>{{ $option['name'] }}</option>
    @endforeach
</select>
