<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Type;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return view('index', [
            'events' => $events
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
        Event::create($validated);

        return redirect()->route('app.index')->with('success', 'Événement créé avec succès');
    }

    public function show(string $id)
    {
        $event = Event::with('Type')->findOrFail($id);

        $this->authorize('view', $event);

        return view('show', [
            'event' => $event
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
}