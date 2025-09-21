@extends('layouts.layout')

@section('title', 'Modifier l\'Événement')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card shadow-lg border-0 rounded-4">
    
                    <div class="card-header bg-warning text-white py-4 rounded-top-4">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="bi bi-pencil-square display-4"></i>
                            </div>
                            <h1 class="h2 mb-2 fw-bold">Modifier l'Événement</h1>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <span class="badge bg-light text-warning fs-6 px-3 py-2">
                                    <i class="bi bi-gear me-1"></i>Mode édition
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('app.update', $event->Id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Nom de l'événement -->
                            <div class="mb-4">
                                <label for="Nom" class="form-label fw-semibold fs-6">
                                    <i class="bi bi-tag text-primary me-2"></i>Nom de l'Événement
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-pencil text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control @error('Nom') is-invalid @enderror" 
                                           id="Nom" 
                                           name="Nom" 
                                           value="{{ old('Nom', $event->Nom) }}" 
                                           placeholder="Ex: Conférence annuelle 2024"
                                           required>
                                    @error('Nom')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Type d'événement -->
                            <div class="mb-4">
                                <label for="TypeId" class="form-label fw-semibold fs-6">
                                    <i class="bi bi-collection text-primary me-2"></i>Type d'Événement
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-list-ul text-muted"></i>
                                    </span>
                                    <select class="form-select @error('TypeId') is-invalid @enderror" 
                                            id="TypeId" 
                                            name="TypeId" 
                                            required>
                                        <option value="">-- Sélectionnez un type --</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->Id }}">
                                                {{ $type->Nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('TypeId')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="Description" class="form-label fw-semibold fs-6">
                                    <i class="bi bi-text-paragraph text-primary me-2"></i>Description
                                    <small class="text-muted fw-normal">(optionnel)</small>
                                </label>
                                <textarea class="form-control form-control-lg @error('Description') is-invalid @enderror" 
                                          id="Description" 
                                          name="Description" 
                                          rows="5" 
                                          placeholder="Décrivez votre événement en détail..."
                                          style="resize: vertical;">{{ old('Description', $event->Description) }}</textarea>
                                @error('Description')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Une description détaillée aide les participants à mieux comprendre l'événement
                                </div>
                            </div>

                            <!-- Séparateur -->
                            <hr class="my-5 border-2">

                            <!-- Actions -->
                            <div class="text-center">
                                <h5 class="mb-4 text-muted">
                                    <i class="bi bi-gear me-2"></i>Actions disponibles
                                </h5>
                                <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                                    <!-- Annuler -->
                                    <a href="{{ route('app.show', $event->Id) }}" class="btn btn-outline-secondary btn-lg px-4">
                                        <i class="bi bi-x-circle me-2"></i>Annuler
                                    </a>
                                    
                                    <!-- Sauvegarder -->
                                    <button type="submit" class="btn btn-success btn-lg px-4">
                                        <i class="bi bi-check-circle me-2"></i>Sauvegarder les modifications
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection