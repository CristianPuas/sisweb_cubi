@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2']) !!}>
