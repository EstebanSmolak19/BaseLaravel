<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Services\geolocalisationService;
use App\Models\Event;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use App\Http\Request;

class EventController extends Controller
{

    public $geolocation;

    public function __construct(geolocalisationService $geolocalisation)
    {
        $this->geolocation = $geolocalisation;
    }

    public function index()
    {
        $events = Event::orderBy('Date', 'desc')->get();

        return view('index', [
            'events' => $events,
            'user' => Auth::user()
        ]);
    }

    public function create()
    {
        $this->authorize('create', Event::class);

        $types = Type::all();

        return view('create', [
            'types' => $types
        ]);
    }

    public function store(StoreEventRequest $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validated();
        $coords = $this->geolocation->coord($validated['lieu']);

        if ($coords) {
            $validated['latitude'] = $coords['lat'];
            $validated['longitude'] = $coords['lon'];
        }
        
        Event::create($validated);

        return redirect()->route('app.index')->with('success', 'Événement créé avec succès');
    }

    public function show(string $id)
    {
        $event = Event::with('Type')->findOrFail($id);
        $estPasse = $this->estPasse($id);
        $joursAvant = $this->joursAvant($id);
        $formatDate = $this->formatDate($id);

        $this->authorize('view', $event);

        return view('show', [
            'event' => $event,
            'estPasse' => $estPasse,
            'joursAvant' => $joursAvant,
            'formatDate' => $formatDate
        ]);
    }

    public function edit(string $id)
    {
        $event = Event::with('Type')->findOrFail($id);

        $this->authorize('update', $event);

        $types = Type::all();

        return view('edit', [
            "event" => $event,
            'types' => $types
        ]);
    }

    public function update(UpdateEventRequest $request, string $id)
    {
        $event = Event::with('Type')->findOrFail($id);
        $this->authorize('update', $event);

        $validated = $request->validated();
        $coords = $this->geolocation->coord($validated['lieu']);

        if ($coords) {
            $validated['latitude'] = $coords['lat'];
            $validated['longitude'] = $coords['lon'];
        }

        $event->update($validated);

        return redirect()->route('app.index')->with('success', 'Événement mis à jour avec succès');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('app.index')->with('success', 'Événement supprimé avec succès');
    }

    public function estPasse(string $id): bool 
    {
        $event = Event::FindOrFail($id);
        if($event && $event->Date) {
            return strtotime($event->Date) < strtotime(date('Y-m-d'));
        }
        return false;
    }

    public function joursAvant(string $id): int 
    {
        $event = Event::findOrFail($id);

        if ($event && $event->Date) {
            $eventDate = strtotime(date('Y-m-d', strtotime($event->Date)));
            $today = strtotime(date('Y-m-d'));

            $diff = $eventDate - $today;
            $jours = (int) ($diff / 86400);

            return $jours < 0 ? 0 : $jours;
        }
        return 0;
    }

    public function formatDate(string $id): string 
    {
        $event = Event::findOrFail($id);

        if ($event->Date) {
            $timestamp = strtotime($event->Date);

            $mois = [
                1 => 'janvier',
                2 => 'février',
                3 => 'mars',
                4 => 'avril',
                5 => 'mai',
                6 => 'juin',
                7 => 'juillet',
                8 => 'août',
                9 => 'septembre',
                10 => 'octobre',
                11 => 'novembre',
                12 => 'décembre'
            ];

            $jour = date('d', $timestamp);
            $moisNom = $mois[(int)date('m', $timestamp)];
            $annee = date('Y', $timestamp);

            return "$jour $moisNom $annee";
        }

        return '';
    }
}