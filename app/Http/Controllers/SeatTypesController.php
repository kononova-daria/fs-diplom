<?php

namespace App\Http\Controllers;

use App\Models\SeatType;
use Illuminate\Support\Facades\Route;

const SEAT_TYPE_TAKEN = 'taken';
const SEAT_TYPE_SELECTED = 'selected';

class SeatTypesController extends Controller
{
    public function index(): \Illuminate\Support\Collection
    {
        $types = SeatType::all();

        switch (Route::getFacadeRoot()->current()->uri()) {
            case 'admin/types':
                $new_types = [];
                foreach ($types as $value) {
                    if ($value->key !== SEAT_TYPE_TAKEN && $value->key !== SEAT_TYPE_SELECTED) {
                        $new_types[] = $value;
                    }
                }
                return collect($new_types);
            case 'client/types':
                return $types;
            default:
                return collect([]);
        }
    }
}
