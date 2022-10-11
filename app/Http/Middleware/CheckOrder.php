<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckOrder
{
    public function handle(Request $request, Closure $next)
    {
        foreach ($request->input('places') as $place) {
            $orders = DB::table('orders')->where('session_id', $request->input('session_id'))->where('place_id', $place)->get();
            if (count($orders)) {
                return response(['Выбранные места уже заняты. Пожалуйста, перезагрузите страницу, чтобы получить актуальные данные.'], 400);
            }
        }
        return $next($request);
    }
}
