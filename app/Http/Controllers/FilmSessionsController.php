<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilmSession;
use App\Repositories\FilmRepository;
use App\Repositories\FilmSessionRepository;
use App\Repositories\OrderRepository;

class FilmSessionsController extends Controller
{
    public function index()
    {
        $sessions = FilmSession::all();
        foreach ($sessions as $value) {
            $value->film = FilmRepository::search('id', $value->film_id)->first();
        }
        return $sessions;
    }

    public function store(Request $request)
    {
        $session = new FilmSession;
        $form = $request->all();
        $session->fill($form)->save();
        return 'success';
    }

    public function destroy($id)
    {
        OrderRepository::delete('session_id', $id);
        FilmSessionRepository::delete('id', $id);
        return 'success';
    }
}
