@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#252525]']) }}>
    {{ $value ?? $slot }}
</label>
