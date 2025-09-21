@extends('layouts.layout')
@section('title', 'Détails de l\'Événement')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card shadow-lg border-0 rounded-4">

                    <div class="card-header bg-primary text-white py-4 rounded-top-4">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="bi bi-calendar-event display-4"></i>
                            </div>
                            <h1 class="h2 mb-2 fw-bold">Détails de l'Événement</h1>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <span class="badge bg-light text-primary fs-6 px-3 py-2">
                                    <i class="bi bi-eye me-1"></i>Mode consultation
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
           
                        <div class="text-center mb-5">
                            <h2 class="display-6 fw-bold text-dark mb-3">{{ $event->Nom }}</h2>
                            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                                <span class="badge bg-info bg-opacity-20 text-info fs-6 px-4 py-2 rounded-pill text-white">
                                    <i class="bi bi-tag me-2"></i>{{ $event->type->Nom ?? 'Type non défini' }}
                                </span>
                            </div>
                        </div>


                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-header bg-transparent border-0 pb-0">
                                        <h5 class="card-title mb-0 text-primary">
                                            <i class="bi bi-text-paragraph me-2"></i>Description
                                        </h5>
                                    </div>
                                    <div class="card-body pt-3">
                                        @if($event->Description && trim($event->Description) !== '')
                                            <p class="card-text text-secondary fs-6 lh-lg mb-0">
                                                {{ $event->Description }}
                                            </p>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="bi bi-file-text text-muted display-6 mb-3"></i>
                                                <p class="text-muted mb-0 fst-italic">
                                                    Aucune description n'a été fournie pour cet événement
                                                </p>
                                                <small class="text-muted">
                                                    Vous pouvez ajouter une description en modifiant l'événement
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Séparateur -->
                        <hr class="my-5 border-2">

                        <div class="text-center">
                            <h5 class="mb-4 text-muted">
                                <i class="bi bi-gear me-2"></i>Actions disponibles
                            </h5>
                            <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                                <!-- Retour -->
                                <a href="{{ route('app.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                                </a>
                                
                                @can('update', $event)
                                <!-- Modifier -->
                                <a href="{{ route('app.edit', $event->Id) }}" class="btn btn-warning btn-lg px-4">
                                    <i class="bi bi-pencil-square me-2"></i>Modifier l'événement
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection