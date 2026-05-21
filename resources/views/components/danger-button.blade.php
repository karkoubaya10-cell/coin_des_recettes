<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-[#5B2E91] rounded-full font-semibold text-xs text-[#5B2E91] uppercase tracking-widest hover:bg-[#5B2E91] hover:text-white active:bg-[#5B2E91] focus:outline-none focus:ring-2 focus:ring-[#5B2E91] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
