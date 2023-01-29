<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LookupController extends Controller
{
    public function index()
    {
        return view('pages/lookup');
    }

    public function lookup(Request $request)
    {
        if ($request->input_key == '') {
            Session::flash('msg', 'Vehicle number or transaction code is required');
            Session::flash('color', 'red');
            return view('/lookup');
        } else {
            $data['input_key'] = $request->input_key;
            $data['service_list'] = Services::where('vehicle_number', $request->input_key)->orWhere('transaction_code', $request->input_key)->orderBy('id', 'desc')->get();
            // dd($data['service_list']);
            if (!$data['service_list']->isEmpty()) {
                Session::flash('msg', 'Great Job! You have opportunity to claim a Gifts');
                Session::flash('color', 'green');
            } else {
                Session::flash('msg', 'Please wash your motorcycle at the nearby Juno Motorwash');
                Session::flash('color', 'yellow');
            }
            return view('pages/lookup', $data);
        }
    }
}
