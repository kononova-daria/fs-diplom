<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return DB::table('halls')->find($id);
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
        $sessions = DB::table('sessions')->where('hall', $id)->get();
        foreach ($sessions as $value) {
            DB::table('orders')->where('session', $value->id)->delete();
        }

        DB::table('places')->where('hall', $id)->delete();
        DB::table('sessions')->where('hall', $id)->delete();
        DB::table('halls')->where('id', $id)->delete();
        return 'success';
    }
}
