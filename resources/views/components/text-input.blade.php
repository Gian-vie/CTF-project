@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-gray-700 border-gray-600 text-gray-200 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm placeholder-gray-400']) !!}>
