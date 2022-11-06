<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Order;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrdersController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request): \Illuminate\Support\Collection
    {
        $this->validate($request, [
            'session' => 'required|integer',
        ]);

        $data = $request->all();
        $session = $data['session'];
        return $this->orderRepository->search('session_id', $session);
    }

    public function store(Request $request): Object
    {
        $this->validate($request, [
            'places' => 'required|array',
            'session_id' => 'required|integer'
        ]);

        $data = $request->all();
        $places = $data['places'];
        $session = $data['session_id'];

        $strPlaces = '';

        foreach ($places as $iValue) {
            $strPlaces .= $iValue;
            $order = new Order;
            $data['place_id'] = $iValue;
            $order->fill($data)->save();
        }

        return QrCode::size(200)->generate("$session, $strPlaces");
    }
}
