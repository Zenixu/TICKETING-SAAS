<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventCatalogController extends Controller
{
    /**
     * Tampilkan Halaman Landing / Eksplorasi Event Ala Loket.com.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        
        $query = Event::with('user')->where('status', 'active');

        if ($category) {
            $query->where('material_links->category', $category);
        }

        $events = $query->latest()->get();

        return view('welcome', compact('events', 'category'));
    }

    /**
     * Tampilkan Halaman Detail Event & Pilihan Kategori Tiket (VIP/Regular).
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
