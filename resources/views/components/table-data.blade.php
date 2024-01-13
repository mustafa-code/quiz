<!-- resources/views/components/table-data.blade.php -->

<td {{ $attributes->merge(['class' => 'px-5 py-5 border-b border-gray-200 bg-white text-sm']) }}>
    {{ $slot }}
</td>

