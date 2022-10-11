<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionIsValid
{
    public function handle(Request $request, Closure $next)
    {
        $sessions = DB::table('film_sessions')->where('hall_id', $request->input('hall_id'))->get();
        if (count($sessions)) {
            foreach ($sessions as $value) {
                if ($request->input('start') >= $value->start && $request->input('start') <= $value->end) {
                    return response(['В выбранном зале на данное время уже существует сеанс.'],400);
                }
            }
        }
        return $next($request);
    }
}
