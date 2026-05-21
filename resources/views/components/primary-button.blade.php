<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center px-5 py-2.5 rounded-full font-bold text-sm uppercase tracking-wide border transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2',
    'style' => 'background-color:#ffd9cc !important; color:#1f2937 !important; border-color:#f0b8a2 !important;'
]) }}>
    {{ $slot }}
</button>
