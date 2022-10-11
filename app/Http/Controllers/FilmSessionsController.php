<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilmSession;
use Illuminate\Support\Facades\DB;

class FilmSessionsController extends Controller
{
    public function index()
    {
        $sessions = FilmSession::all();
        foreach ($sessions as $value) {
            $value->film = DB::table('films')->where('id', $value->film_id)->get()->first();
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
        DB::table('orders')->where('session_id', $id)->delete();
        DB::table('film_sessions')->where('id', $id)->delete();
        return 'success';
    }
}
