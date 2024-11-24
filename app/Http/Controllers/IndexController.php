<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Display a home page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $events = new Event;

        $searchEvents = [];
        if ($request->input('search')) {
            // Get the search value from the request
            $search = $request->input('search');
            // Search in the name and body columns from the events table
            $searchEvents = $events->searchEvents($search);
        }

        return view('index', [
            'events' => $events->getEvents(),
            'searchEvents' => $searchEvents,
        ]);
    }
}
