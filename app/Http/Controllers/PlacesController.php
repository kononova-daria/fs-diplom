<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Repositories\PlaceRepository;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $hall = $data['hall'];
        return PlaceRepository::search('hall_id', $hall);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $places = $data['places'];
        $hall = $places[0]['hall_id'];

        PlaceRepository::delete('hall_id', $hall);

        foreach ($places as $iValue) {
            $place = new Place;
            $place->fill($iValue)->save();
        }
    }
}
