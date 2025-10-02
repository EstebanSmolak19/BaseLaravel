<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Services\EventService;
use App\Http\Services\GeolocalisationService;
use App\Models\Event;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Exception;

class EventController extends Controller
{
    protected EventService $eventService;
    protected GeolocalisationService $geolocation;

    public function __construct(EventService $eventService, GeolocalisationService $geolocation)
    {
        $this->eventService = $eventService;
        $this->geolocation = $geolocation;
    }

    // Liste des événements
    public function index()
    {
        try {
            $events = $this->eventService->getAllEvents();
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return view('index', [
            'events' => $events,
            'user' => Auth::user()
        ]);
    }

    // Formulaire création
    public function create()
    {
        $this->authorize('create', Event::class);
        $types = Type::all();
        return view('create', ['types' => $types]);
    }

    // Création événement
    public function store(StoreEventRequest $request)
    {
        $this->authorize('create', Event::class);
        $validated = $request->validated();

        $coords = $this->geolocation->coord($validated['lieu']);
        if ($coords) {
            $validated['latitude'] = $coords['lat'];
            $validated['longitude'] = $coords['lon'];
        }

        try {
            $this->eventService->createEvent($validated);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('app.index')->with('success', 'Événement créé avec succès');
    }

    // Affichage événement
    public function show(string $id)
    {
        try {
            $event = $this->eventService->getEventById($id);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        $this->authorize('view', $event);

        return view('show', [
            'event' => $event,
            'estPasse' => $this->eventService->estPasse($event),
            'joursAvant' => $this->eventService->joursAvant($event),
            'formatDate' => $this->eventService->formatDate($event),
        ]);
    }

    // Formulaire édition
    public function edit(string $id)
    {
        try {
            $event = $this->eventService->getEventById($id);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        $this->authorize('update', $event);
        $types = Type::all();

        return view('edit', ['event' => $event, 'types' => $types]);
    }

    // Mise à jour
    public function update(UpdateEventRequest $request, string $id)
    {
        try {
            $event = $this->eventService->getEventById($id);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        $this->authorize('update', $event);

        $validated = $request->validated();
        $coords = $this->geolocation->coord($validated['lieu']);
        if ($coords) {
            $validated['latitude'] = $coords['lat'];
            $validated['longitude'] = $coords['lon'];
        }

        try {
            $this->eventService->updateEvent($event, $validated);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('app.index')->with('success', 'Événement mis à jour avec succès');
    }

    // Suppression
    public function destroy(string $id)
    {
        try {
            $event = $this->eventService->getEventById($id);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        $this->authorize('delete', $event);

        try {
            $this->eventService->deleteEvent($event);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('app.index')->with('success', 'Événement supprimé avec succès');
    }
}