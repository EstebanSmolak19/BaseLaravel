@extends('layouts.layout')

@section('title', 'Dashboard Administrateur')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Administrateur</h2>
        <div>
            <a href="{{ route('app.index') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-calendar me-1"></i>Voir les événements
            </a>
            <a href="{{ route('logout') }}" class="btn btn-danger">
                <i class="fas fa-sign-out-alt me-1"></i>Se déconnecter
            </a>
        </div>
    </div>

    <div class="row mb-4 justify-content-center align-items-center text-center">
        <x-admin.card 
            label="Événements total"
            :number="$totalEvents"
            color="primary"
            icon="fa-calendar"
        />

        <x-admin.card 
            label="Nombre de festival à Venir"
            :number="$countUpcoming"
            color="info"
            icon="fa-clipboard-list"
        />

        <x-admin.card 
            label="Nombre de festival passé"
            :number="$countEventPast"
            color="warning"
            icon="fa-history"
        />
    </div>

    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Événements créés par mois</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="eventsByMonthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-primary">Répartition par type d'événements</h6>
                </div>
                <div class="card-body">
                    <canvas id="eventsByTypeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Derniers événements créés</h6>
                    <a href="{{ route('app.create') }}" class="btn btn-sm btn-primary">Nouvel événement</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->Nom }}</td>
                                    <td>{{ $event->Type->Nom ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->Date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if(\Carbon\Carbon::parse($event->Date)->isPast())
                                            <span class="badge bg-success">Terminé</span>
                                        @elseif(\Carbon\Carbon::parse($event->Date)->isToday())
                                            <span class="badge bg-warning">En cours</span>
                                        @else
                                            <span class="badge bg-info">À venir</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventsByMonthCtx = document.getElementById('eventsByMonthChart').getContext('2d');
    new Chart(eventsByMonthCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Événements créés',
                data: [12, 19, 15, 25, 22, 30, 28, 24, 32, 28, 35, 40],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
    });

    // Graphique circulaire - Types d'événements (dynamique)
    const typeLabels = @json($typeLabels);
    const typeCounts = @json($typeCounts);

    const ctx = document.getElementById('eventsByTypeChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: typeLabels,
            datasets: [{
                data: typeCounts,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>

<style>
.card { 
    border: none; border-radius: 0.35rem; 
}
.text-center { 
    text-align: center !important; 
}
.shadow { 
    box-shadow: 0 0.15rem 1.75rem rgba(58,59,69,0.15) !important; 
}
.chart-area, .chart-pie, .chart-bar { 
    height: 300px; position: relative; 
}
.badge {
    font-size: 0.75em; 
}
</style>
@endsection