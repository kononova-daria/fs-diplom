<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlacesController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $hall = $data['hall'];
        return DB::table('places')->where('hall_id', $hall)->get();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $places = $data['places'];
        $hall = $places[0]['hall_id'];

        DB::table('places')->where('hall_id', $hall)->delete();

        foreach ($places as $iValue) {
            $place = new Place;
            $place->fill($iValue)->save();
        }
    }
}
