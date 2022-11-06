<?php

namespace App\Http\Controllers;

use App\Services\FilmSessionService;
use Illuminate\Http\Request;
use App\Models\FilmSession;
use Illuminate\Http\Response;

class FilmSessionsController extends Controller
{
    private FilmSessionService $filmSessionService;

    public function __construct(FilmSessionService $filmSessionService)
    {
        $this->filmSessionService = $filmSessionService;
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->filmSessionService->getSessions();
    }

    public function store(Request $request): Response
    {
        $session = new FilmSession;
        $form = $request->all();
        $session->fill($form)->save();
        return response(null, 201);
    }

    public function destroy(int $id): Response
    {
        $this->filmSessionService->deleteSession($id);
        return response(null, 201);
    }
}
