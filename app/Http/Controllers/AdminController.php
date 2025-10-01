<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Type;

class AdminController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $totalEvents = Event::count();
        $countEventPast = Event::where('Date', '<', now())->count();
        $countUpcoming = Event::where('Date', '>=', now())->count();

        // Derniers événements pour le tableau
        $events = Event::with('Type')->orderBy('Date', 'desc')->take(10)->get();

        // Préparer les données pour le graphique circulaire des types
        $types = Type::all();
        $typeLabels = $types->pluck('Nom')->toArray();

        // Compter le nombre d'événements par type
        $typeCounts = [];
        foreach ($types as $type) {
            $typeCounts[] = Event::where('TypeId', $type->Id)->count();
        }

        return view('admin.index', [
            'totalEvents'    => $totalEvents,
            'countEventPast' => $countEventPast,
            'countUpcoming'  => $countUpcoming,
            'events'         => $events,
            'typeLabels'     => $typeLabels,
            'typeCounts'     => $typeCounts
        ]);
    }
}