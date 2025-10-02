<?php

namespace App\Http\Services;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class EventService
{
    /**
     * Récupère tous les événements triés par date décroissante.
     */
    public function getAllEvents(): Collection
    {
        try {
            return Event::orderBy('Date', 'desc')->get();
        } catch (Exception $e) {
            throw new Exception('Impossible de récupérer les événements : ' . $e->getMessage());
        }
    }

    /**
     * Récupère un événement par ID avec type.
     */
    public function getEventById(string $id): Event
    {
        try {
            return Event::with('Type')->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Événement introuvable : ' . $e->getMessage());
        }
    }

    /**
     * Crée un nouvel événement.
    */
    public function createEvent(array $data): Event
    {
        try {
            return Event::create($data);
        } catch (Exception $e) {
            throw new Exception('Impossible de créer l\'événement : ' . $e->getMessage());
        }
    }

    /**
     * Met à jour un événement existant.
    */
    public function updateEvent(Event $event, array $data): bool
    {
        try {
            return $event->update($data);
        } catch (Exception $e) {
            throw new Exception('Impossible de mettre à jour l\'événement : ' . $e->getMessage());
        }
    }

    /**
     * Supprime un événement.
     */
    public function deleteEvent(Event $event): ?bool
    {
        try {
            return $event->delete();
        } catch (Exception $e) {
            throw new Exception('Impossible de supprimer l\'événement : ' . $e->getMessage());
        }
    }

    /**
     * Vérifie si un événement est passé.
     */
    public function estPasse(Event $event): bool
    {
        if ($event && $event->Date) {
            return strtotime($event->Date) < strtotime(date('Y-m-d'));
        }
        return false;
    }

    /**
     * Jours restants avant l'événement.
     */
    public function joursAvant(Event $event): int
    {
        if ($event && $event->Date) {
            $eventDate = strtotime(date('Y-m-d', strtotime($event->Date)));
            $today = strtotime(date('Y-m-d'));
            $diff = $eventDate - $today;
            $jours = (int) ($diff / 86400);

            return $jours < 0 ? 0 : $jours;
        }
        return 0;
    }

    /**
     * Formate la date en français.
     */
    public function formatDate(Event $event): string
    {
        if ($event->Date) {
            $timestamp = strtotime($event->Date);
            $mois = [
                1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
                5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
                9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
            ];
            $jour = date('d', $timestamp);
            $moisNom = $mois[(int)date('m', $timestamp)];
            $annee = date('Y', $timestamp);

            return "$jour $moisNom $annee";
        }

        return '';
    }
}