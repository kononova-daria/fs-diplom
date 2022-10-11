<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $session = $data['session'];
        return DB::table('orders')->where('session_id', $session)->get();
    }

    public function store(Request $request)
    {
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
