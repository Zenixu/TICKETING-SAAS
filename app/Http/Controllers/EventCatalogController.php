<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventCatalogController extends Controller
{
    /**
     * Tampilkan Halaman Katalog Event untuk User Biasa (Publik).
     */
    public function index()
    {
        $events = Event::with('user')->latest()->get();
        return view('events.index', compact('events'));
    }

    /**
     * Tampilkan Detail Event & Halaman Beli Tiket.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
