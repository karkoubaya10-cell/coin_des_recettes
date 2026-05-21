<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-[#FA8072] rounded-full font-semibold text-xs text-[#FA8072] uppercase tracking-widest shadow-sm hover:bg-[#FA8072] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#FA8072] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
