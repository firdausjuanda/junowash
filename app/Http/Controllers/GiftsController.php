<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($data = [])
    {
        return view('pages/gifts', $data);
    }

    public function randomize()
    {
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');
        $response = Services::where('transaction_code', '<>', "")
        ->whereBetween('created_at', [$first_day_this_month, $last_day_this_month])->get();
        $services = [];
        foreach ($response as $val) {
            $services[] = $val->id;
        }
        if ($services) {
            $winner_id = array_rand($services, 1);
            $data['winner_data'] = Services::find($services[$winner_id]);
            return $this->index($data);
        } else {
            return back()->with('success', 'No data');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
