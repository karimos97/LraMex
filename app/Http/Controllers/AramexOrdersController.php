<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AramexAccount;
use App\Imports\OrdersImport;
use Maatwebsite\Excel\Facades\Excel;

class AramexOrdersController extends Controller
{
    public function loadOrders(Request $request){

        if ($request->import->getMimeType()=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            Excel::import(new OrdersImport, $request->import);
            return response()->json(['message'=>'Orders Imported Successfuly','status'=>true]);
        }
        else {
            return response()->json(['message'=>'Invalid Excel Format','status'=>false],500);
        }



    }
}
