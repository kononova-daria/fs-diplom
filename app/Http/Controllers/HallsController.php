<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Repositories\HallRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\FilmSessionRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class HallsController extends Controller
{
    public function index()
    {
        return Hall::all();
    }

    public function store(Request $request)
    {
        $hall = new Hall;
        $form = $request->all();
        $hall->fill($form)->save();
        return 'success';
    }

    public function show($id)
    {
        return HallRepository::getById($id);
    }

    public function update(Request $request, $id)
    {
        $hall = Hall::findOrFail($id);
        $data = $request->all();
        foreach ($data as $key => $value) {
            $hall->$key = $value;
        }
        $hall->save();
    }

    public function destroy($id)
    {
        $sessions = FilmSessionRepository::search('hall_id', $id);
        foreach ($sessions as $value) {
            OrderRepository::delete('session_id', $value->id);
        }
        PlaceRepository::delete('hall_id', $id);
        FilmSessionRepository::delete('hall_id', $id);
        HallRepository::delete('id', $id);
        return 'success';
    }
}
