{{-- resources/views/components/input.blade.php --}}
@props([
    'type' => 'text',
    'label' => null,
    'name' => null,
    'placeholder' => '',
    'required' => false,
    'icon' => null,
    'error' => null
])

<div class="w-full">
    @if($label)
    <label for="{{ $name }}" class="block text-sm font-bold mb-2 uppercase">
        {{ $label }}
        @if($required)
        <span class="text-pink-600">*</span>
        @endif
    </label>
    @endif

    <div class="relative">
        @if($icon)
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
            {!! $icon !!}
        </div>
        @endif

        <input 
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full px-5 py-3 border-3 border-black rounded-xl font-medium placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-pink-600 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' . ($icon ? ' pl-12' : '')
            ]) }}
        >
    </div>

    @if($error)
    <p class="mt-2 text-sm text-pink-600 font-medium">{{ $error }}</p>
    @endif

    @error($name)
    <p class="mt-2 text-sm text-pink-600 font-medium">{{ $message }}</p>
    @enderror
</div>