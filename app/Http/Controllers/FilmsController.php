<?php

namespace App\Http\Controllers;

use App\Services\FilmService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Film;

class FilmsController extends Controller
{
    private FilmService $filmService;

    public function __construct(FilmService $filmService)
    {
        $this->filmService = $filmService;
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->filmService->getFilms(Route::getFacadeRoot()->current()->uri());
    }

    public function store(Request $request): Response
    {
        $film = new Film;
        $form = $request->all();
        $film->fill($form)->save();
        return response(null, 201);
    }

    public function show(int $id): Object
    {
        return $this->filmService->getFilm($id);
    }

    public function destroy(int $id): Response
    {
        $this->filmService->deleteFilm($id);
        return response(null, 201);
    }
}
