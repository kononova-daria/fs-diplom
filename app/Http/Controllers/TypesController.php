<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class TypesController extends Controller
{
    public function index()
    {
        $types = Type::all();

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
