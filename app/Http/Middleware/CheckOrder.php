<?php

namespace App\Http\Middleware;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckOrder
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function handle(Request $request, Closure $next)
    {
        foreach ($request->input('places') as $place) {
            $orders = $this->orderRepository->filter(['session_id'=>$request->input('session_id'), 'place_id'=>$place]);
            if (count($orders)) {
                return response(['Выбранные места уже заняты. Пожалуйста, перезагрузите страницу, чтобы получить актуальные данные.'], 400);
            }
        }
        return $next($request);
    }
}
