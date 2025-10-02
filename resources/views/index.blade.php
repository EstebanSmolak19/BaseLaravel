@extends('layouts.layout')

@section('title', 'Liste des Événements')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Liste des Événements</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Type</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)

                    @php
                        $estPasse = strtotime($event->Date) < strtotime(date('Y-m-d'));
                    @endphp

                    <tr>
                        <td>{{ $event->Nom }}</td>
                        <td>{{ $event->Type->Nom ?? 'Type non défini' }}</td>
                        <td>
                            @if($estPasse)
                                <span class="badge bg-info">Événement passé</span>
                            @else
                                <a href="{{ route('app.show', $event->Id) }}" class="btn btn-sm btn-warning me-2">Voir</a>
                                @can('delete', $event)
                                    <form action="{{ route('app.destroy', $event->Id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 d-flex flex-wrap gap-2">
            @can('create', $event)
                <a href="{{ route('app.create') }}" class="btn btn-primary">Créer un Événement</a>
            @endcan

            <a href="{{ route('logout') }}" class="btn btn-danger">Se déconnecter</a>

            @if($user->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">Dashboard Administrateur</a>
            @endif
        </div>
    </div>
</div>
@endsection