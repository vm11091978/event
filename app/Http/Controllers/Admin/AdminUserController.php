<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('admin.user', ['users' => User::all()]);
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
        $user = User::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::find($id);

        // если админ при обновлении пользователя снял галочку с поля "Активен"
        if (empty($request['active'])) {
            $request['active'] = NULL;
        }
        // если админ при обновлении пользователя снял галочку с поля "Админ"
        if (empty($request['is_admin'])) {
            $request['is_admin'] = NULL;
        }
        $user->update($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::find($id);

        $user->events()->detach();
        $user->delete();

        return back();
    }
}
