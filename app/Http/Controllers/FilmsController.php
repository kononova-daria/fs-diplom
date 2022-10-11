<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Film;

class FilmsController extends Controller
{
    public function index()
    {
        $films = Film::all();

        switch (Route::getFacadeRoot()->current()->uri()) {
            case 'admin/films':
                break;
            case 'client/films':
                foreach ($films as $film) {
                    $halls = DB::table('halls')->where('status', true)->get();
                    $halls = array_filter([...$halls], static function ($value) {
                        $places = DB::table('places')->where('hall_id', $value->id)->get();
                        return count($places);
                    });
                    $sessions = DB::table('film_sessions')->where('film_id', $film->id)->get();
                    $film->halls = collect($halls);
                    foreach ($film->halls as $key=>$hall) {
                        $hall->sessions = [];
                        foreach ($sessions as $session) {
                            if ($session->hall_id === $hall->id) {
                                $hall->sessions[] = $session;
                            }
                        }
                        if (!count($hall->sessions)) {
                            unset($film->halls[$key]);
                        }
                    }
                }
                break;
        }
        return $films;
    }

    public function store(Request $request)
    {
        $film = new Film;
        $form = $request->all();
        $film->fill($form)->save();
        return 'success';
    }

    public function show($id)
    {
        return DB::table('films')->find($id);
    }

    public function destroy($id)
    {
        $sessions = DB::table('film_sessions')->where('film_id', $id)->get();
        foreach ($sessions as $value) {
            DB::table('orders')->where('session_id', $value->id)->delete();
        }

        DB::table('film_sessions')->where('film_id', $id)->delete();
        DB::table('films')->where('id', $id)->delete();
        return 'success';
    }
}
