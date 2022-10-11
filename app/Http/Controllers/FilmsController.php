<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Film;
use App\Repositories\FilmRepository;
use App\Repositories\HallRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\FilmSessionRepository;
use App\Repositories\OrderRepository;

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
                    $halls = HallRepository::search('status', true);
                    $halls = array_filter([...$halls], static function ($value) {
                        $places = PlaceRepository::search('hall_id', $value->id);
                        return count($places);
                    });
                    $sessions = FilmSessionRepository::search('film_id', $film->id);
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
        return FilmRepository::getById($id);
    }

    public function destroy($id)
    {
        $sessions = FilmSessionRepository::search('film_id', $id);
        foreach ($sessions as $value) {
            OrderRepository::delete('session_id', $value->id);
        }
        FilmSessionRepository::delete('film_id', $id);
        FilmRepository::delete('id', $id);
        return 'success';
    }
}
