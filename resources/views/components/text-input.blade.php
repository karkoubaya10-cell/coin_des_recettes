@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#e7ddd4] focus:border-[#c5b0e7] focus:ring-[#c5b0e7] rounded-xl shadow-sm']) }}>
