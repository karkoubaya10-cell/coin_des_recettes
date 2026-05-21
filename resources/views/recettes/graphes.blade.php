@extends('layouts.app')

@section('content')
<style>
    .graphs-page { background: radial-gradient(circle at 10% 4%, rgba(123, 76, 201, 0.09), transparent 38%), linear-gradient(180deg, #fcf9f7 0%, #f8f1ea 100%); border-radius: 20px; padding: 1rem; }
    .graphs-panel { background: #fff; border: 1px solid #eee; border-radius: 16px; }
    .graphs-card { border: 1px solid #eee; border-radius: 14px; background: #fff; }
    .graphs-card h3 { color: #5b2e91; }
    .theme-outline { border: 1px solid #fa8072; color: #fa8072; background: #fff; }
    .theme-outline:hover { background: #fa8072; color: #fff; border-color: #fa8072; }
    .fade-in-up { animation: fadeInUp 0.45s ease both; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(8px);} to { opacity: 1; transform: translateY(0);} }
</style>
<div class="graphs-page">
<div class="graphs-panel p-4 p-lg-5 fade-in-up">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
            <div>
                <h2 class="section-title mb-1">{{ __('messages.graphiques_synthese') }}</h2>
                <p class="text-muted mb-0">{{ __('messages.description_graphes') }}</p>
            </div>
            <a href="{{ route('recettes.liste') }}#titre-liste-recettes" class="btn theme-outline rounded-pill px-3">{{ __('messages.retour_liste') }}</a>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="p-3 graphs-card">
                    <h3 class="h5 mb-3">{{ __('messages.graphe1_titre') }}</h3>
                    <canvas id="chartHistogramme"></canvas>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="p-3 graphs-card h-100">
                    <h3 class="h5 mb-3">{{ __('messages.graphe2_titre') }}</h3>
                    <canvas id="chartSecteur"></canvas>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="p-3 graphs-card h-100">
                    <h3 class="h5 mb-3">{{ __('messages.graphe3_titre') }}</h3>
                    <canvas id="chartCourbe"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labelsHistogramme = @json($labelsHistogramme);
    const valeursHistogramme = @json($valeursHistogramme);
    const labelsSecteur = @json($labelsSecteur);
    const valeursSecteur = @json($valeursSecteur);
    const labelsCourbe = @json($labelsCourbe);
    const valeursCourbe = @json($valeursCourbe);

    new Chart(document.getElementById('chartHistogramme'), {
        type: 'bar',
        data: {
            labels: labelsHistogramme,
            datasets: [{
                label: @json(__('messages.nb_recettes')),
                data: valeursHistogramme,
                backgroundColor: '#4e79a7'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    new Chart(document.getElementById('chartSecteur'), {
        type: 'pie',
        data: {
            labels: labelsSecteur,
            datasets: [{
                data: valeursSecteur,
                backgroundColor: ['#59a14f', '#f28e2b', '#e15759', '#76b7b2', '#edc948', '#4e79a7', '#9c755f']
            }]
        },
        options: { responsive: true }
    });

    new Chart(document.getElementById('chartCourbe'), {
        type: 'line',
        data: {
            labels: labelsCourbe,
            datasets: [{
                label: @json(__('messages.nouveaux_utilisateurs')),
                data: valeursCourbe,
                borderColor: '#af7aa1',
                backgroundColor: 'rgba(175,122,161,0.2)',
                fill: true,
                tension: 0.25
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endsection
