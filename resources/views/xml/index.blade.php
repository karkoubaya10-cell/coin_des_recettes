@extends('layouts.app')

@section('content')
<style>
    .xml-page { background: radial-gradient(circle at 10% 4%, rgba(123, 76, 201, 0.09), transparent 38%), linear-gradient(180deg, #fcf9f7 0%, #f8f1ea 100%); border-radius: 20px; padding: 1rem; }
    .xml-panel { background: #fff; border: 1px solid #eee; border-radius: 16px; }
    .xml-card { border: 1px solid #eee; border-radius: 14px; background: #fff; }
    .xml-card h3 { color: #5b2e91; }
    .xml-pre { background: #fffaf7; border: 1px solid #efe6de; border-radius: 14px; }
    .theme-outline { border: 1px solid #fa8072; color: #fa8072; background: #fff; }
    .theme-outline:hover { background: #fa8072; color: #fff; border-color: #fa8072; }
    .fade-in-up { animation: fadeInUp 0.45s ease both; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(8px);} to { opacity: 1; transform: translateY(0);} }
</style>
<div class="xml-page">
<div class="xml-panel p-4 p-lg-5 fade-in-up">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
            <div>
                <h2 class="section-title mb-1">{{ __('messages.xml_titre') }}</h2>
                <p class="text-muted mb-0">{{ __('messages.xml_desc') }}</p>
            </div>
            <a href="{{ route('recettes.liste') }}#titre-liste-recettes" class="btn theme-outline rounded-pill px-3">{{ __('messages.retour_liste') }}</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="p-3 xml-card h-100">
                    <h3 class="h5 mb-3">{{ __('messages.xml_export_titre') }}</h3>
                    <a href="{{ route('xml.export') }}" class="btn theme-outline rounded-pill px-4">{{ __('messages.xml_export_btn') }}</a>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="p-3 xml-card h-100">
                    <h3 class="h5 mb-3">{{ __('messages.xml_import_titre') }}</h3>
                    <form action="{{ route('xml.import') }}" method="POST" enctype="multipart/form-data" class="d-grid gap-3">
                        @csrf
                        <div>
                            <label for="xml_file" class="form-label">{{ __('messages.xml_choisir_fichier') }}</label>
                            <input type="file" name="xml_file" id="xml_file" class="form-control @error('xml_file') is-invalid @enderror" accept=".xml,text/xml" required>
                            @error('xml_file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn theme-outline rounded-pill px-4">{{ __('messages.xml_import_btn') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            
        </div>
    </div>
</div>
@endsection
