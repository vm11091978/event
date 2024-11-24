<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $category = new Category;

        return view('admin.event', [
            'events' => Event::all(),
            'categories' => $category->getCategories(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $event = Event::create($request->all());

        if ($request['categories']) {
            $event->categories()->attach($request['categories']);
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $event = Event::find($id);

        // если админ при обновлении мероприятия снял галочку с поля "Опубликовано"
        if (empty($request['active'])) {
            $request['active'] = NULL;
        }
        $event->update($request->all());
        $event->categories()->sync($request['categories']);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $event = Event::find($id);

        $event->categories()->detach();
        $event->users()->detach();
        $event->delete();

        return back();
    }
}
