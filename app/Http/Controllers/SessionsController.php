<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use Illuminate\Support\Facades\DB;

class SessionsController extends Controller
{
    public function index()
    {
        $sessions = Session::all();
        foreach ($sessions as $value) {
            $value->film = DB::table('films')->where('id', $value->film)->get()->first();
        }
        return $sessions;
    }

    public function store(Request $request)
    {
        $session = new Session;
        $form = $request->all();
        $session->fill($form)->save();
        return 'success';
    }

    public function destroy($id)
    {
        DB::table('orders')->where('session', $id)->delete();
        DB::table('sessions')->where('id', $id)->delete();
        return 'success';
    }
}
