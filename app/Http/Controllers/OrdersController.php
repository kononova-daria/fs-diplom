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
        return DB::table('orders')->where('session', $session)->get();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $places = $data['place'];
        $session = $data['session'];

        $strPlaces = '';

        foreach ($places as $iValue) {
            $strPlaces .= $iValue;
            $order = new Order;
            $data['place'] = $iValue;
            $order->fill($data)->save();
        }

        return QrCode::size(200)->generate("$session, $strPlaces");
    }
}
