<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function index(Request $request): \Illuminate\Support\Collection
    {
        $this->validate($request, [
            'hall' => 'required|integer',
        ]);

        $data = $request->all();
        $hall = $data['hall'];
        return $this->placeRepository->search('hall_id', $hall);
    }

    public function store(Request $request): void
    {
        $this->validate($request, [
            'places' => 'required|array|obj_with_hall',
        ]);

        $data = $request->all();
        $places = $data['places'];
        $hall = $places[0]['hall_id'];

        $this->placeRepository->delete('hall_id', $hall);

        foreach ($places as $iValue) {
            $place = new Place;
            $place->fill($iValue)->save();
        }
    }
}
