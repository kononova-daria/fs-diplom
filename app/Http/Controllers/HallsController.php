<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Services\HallService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HallsController extends Controller
{
    private HallService $hallService;

    public function __construct(HallService $hallService)
    {
        $this->hallService = $hallService;
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Hall::all();
    }

    public function store(Request $request): Response
    {
        $hall = new Hall;
        $form = $request->all();
        $hall->fill($form)->save();
        return response(null, 201);
    }

    public function show(int $id): Object
    {
        return $this->hallService->getHall($id);
    }

    public function update(Request $request, $id): void
    {
        $hall = Hall::findOrFail($id);
        $data = $request->all();
        foreach ($data as $key => $value) {
            $hall->$key = $value;
        }
        $hall->save();
    }

    public function destroy(int $id): Response
    {
        $this->hallService->deleteHall($id);
        return response(null, 201);
    }
}
