<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $events = new Event;

        $currentUserId = $request->user()->id;
        $eventsForUser = [];
        $eventsNotForUser = [];

        // Отделим те мероприятия, на которые пользователь записан, от всех остальных мероприятий
        foreach ($events->getEvents() as $event) {
            $users = $event->users;

            // Если на какое-нибудь мероприятие никто не записан, сразу положим его в массив мероприятий,
            // на которые текущий пользователь не записан
            if (! isset($users[0])) {
                $eventsNotForUser[] = $event;
            } else {
                // Если на какое-нибудь мероприятие кто-то из пользователей записан, переберём всех этих пользователей
                $flag = false;
                foreach ($users as $user) {
                    // Если хоть кто-то из записаных на мероприятие пользователей соответствует текущему пользователю,
                    // положим это мероприятие в массив мероприятий, на которые текущий пользователь записан
                    if ($user->id === $currentUserId) {
                        $eventsForUser[] = $event;
                        $flag = true;
                    }
					
                }
                // Если никто из записаных на мероприятие пользователей не соответствует текущему пользователю,
                // положим это мероприятие в массив мероприятий, на которые текущий пользователь не записан
                if (! $flag) {
                    $eventsNotForUser[] = $event;
                }
            }
        }

        return view('dashboard', [
            'eventsForUser' => $eventsForUser,
            'eventsNotForUser' => $eventsNotForUser,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserEvents $userEvents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserEvent $userEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $event_id): RedirectResponse
    {
        $currentUserId = $request->user()->id;
        $user = User::find($currentUserId);

        // Проверим, не пытается ли пользователь записаться повторно на мероприятие на которое он уже записан
        if ($user->events()->where('event_id', $event_id)->exists()) {
            // если да - просто вернём пользователя обратно
            return back();
        }

        $user->events()->attach($event_id);

        return back()->with('success', 'Мероприятие успешно добавлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $event_id): RedirectResponse
    {
        $currentUserId = $request->user()->id;
        $user = User::find($currentUserId);

        $user->events()->detach($event_id);

        return back()->with('success', 'Мероприятие успешно удалено');
    }
}
