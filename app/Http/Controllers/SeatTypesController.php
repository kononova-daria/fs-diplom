<?php

namespace App\Http\Controllers;

use App\Models\SeatType;
use Illuminate\Support\Facades\Route;

class SeatTypesController extends Controller
{
    public function index()
    {
        $types = SeatType::all();

        switch (Route::getFacadeRoot()->current()->uri()) {
            case 'admin/types':
                $new_types = [];
                foreach ($types as $value) {
                    if ($value-> key !== 'taken' && $value-> key !== 'selected') {
                        $new_types[] = $value;
                    }
                }
                return $new_types;
            case 'client/types':
                return $types;
        }
    }
}
