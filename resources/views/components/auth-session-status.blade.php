@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-[#0f7b46] bg-[#eefaf3] border border-[#b8e3c8] rounded-xl px-3 py-2']) }}>
        {{ $status }}
    </div>
@endif
