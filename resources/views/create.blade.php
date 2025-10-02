@extends('layouts.layout')
@section('title', 'Créer un Événement')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="card shadow-lg border-0 rounded-4">

                    <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                        <div class="mb-3">
                            <i class="bi bi-calendar-plus display-4"></i>
                        </div>
                        <h2 class="card-title mb-1 fw-bold">Créer un Événement</h2>
                        <p class="mb-0 opacity-75">Remplissez les informations ci-dessous</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('app.store') }}" method="POST">
                            @csrf
                            
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
                                           value="{{ old('Nom') }}" 
                                           placeholder="Ex: Conférence annuelle 2024"
                                           >

                                    @error('Nom')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="lieu" class="form-label fw-semibold fs-6">
                                    <i class="bi bi-tag text-primary me-2"></i>Lieu
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-pencil text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control @error('lieu') is-invalid @enderror" 
                                           id="lieu" 
                                           name="lieu" 
                                           value="{{ old('lieu') }}" 
                                           placeholder="Ex: Paris"
                                           >

                                    @error('lieu')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="DateEvenement" class="form-label fw-semibold fs-6">
                                    <i class="bi bi-calendar-event text-primary me-2"></i>Date de l'Événement
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-calendar-date text-muted"></i>
                                    </span>
                                    <input type="date"
                                        class="form-control @error('DateEvenement') is-invalid @enderror"
                                        id="Date"
                                        name="Date"
                                        value="{{ old('Date') }}"
                                        required>
                                    @error('DateEvenement')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

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
                                          style="resize: vertical;">{{ old('Description') }}</textarea>
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

                            <hr class="my-4">

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 me-md-3">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Créer l'Événement
                                </button>
                                <a href="{{ route('app.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Footer avec info -->
                    <div class="card-footer bg-light text-center py-3 border-0 rounded-bottom-4">
                        <small class="text-muted">
                            <i class="bi bi-shield-check text-success me-1"></i>
                            Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection