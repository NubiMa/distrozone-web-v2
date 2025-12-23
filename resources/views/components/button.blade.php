{{-- resources/views/components/button.blade.php --}}
@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, outline
    'size' => 'md', // sm, md, lg
    'fullWidth' => false
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-bold border-3 border-black transition-all duration-200';
    
    $variantClasses = match($variant) {
        'primary' => 'bg-pink-600 text-white hover:bg-pink-700 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px]',
        'secondary' => 'bg-blue-400 text-white hover:bg-blue-500 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px]',
        'outline' => 'bg-white text-black hover:bg-gray-50 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-1px] hover:translate-y-[-1px]',
        default => 'bg-pink-600 text-white'
    };
    
    $sizeClasses = match($size) {
        'sm' => 'px-4 py-2 text-sm rounded-lg',
        'md' => 'px-6 py-3 text-base rounded-xl',
        'lg' => 'px-8 py-4 text-lg rounded-2xl',
        default => 'px-6 py-3 text-base rounded-xl'
    };
    
    $widthClass = $fullWidth ? 'w-full' : '';
    
    $classes = "$baseClasses $variantClasses $sizeClasses $widthClass";
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>