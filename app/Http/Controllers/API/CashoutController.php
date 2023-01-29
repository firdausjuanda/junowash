<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cashout;
use App\Models\User;
use Carbon\Carbon;

class CashoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $start_date = Carbon::
        if(!$request->start && !$request->end && !$request->exact || $request->start && $request->end && $request->exact || $request->start && !$request->end && $request->exact || !$request->start && $request->end && $request->exact || $request->start && !$request->end && !$request->exact || !$request->start && $request->end && !$request->exact){
            return ApiFormatter::createApi('400', 'Invalid input');
        } elseif ($request->exact && !$request->start && !$request->end){
            // $cashout = Cashout::where('created_at', $request->exact)->get();
            $cashout = Cashout::where('created_at', '=' ,date("2023-01-28"))->get();
        } elseif (!$request->exact && $request->start && $request->end) {
            $cashout = Cashout::whereBetween('created_at', [$request->start, $request->end])->get();
        }
        return ApiFormatter::createApi('200', 'Success', $cashout);
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
        if(!$request->amount){
            return ApiFormatter::createApi('400', 'Amount is required!');
        }
        if(!$request->type){
            return ApiFormatter::createApi('400', 'Type is required!');
        } elseif ($request->type != "salary") {
            if(!$request->material){
                return ApiFormatter::createApi('400', 'Material is required!');
            }
        }
        if(!$request->qty){
            return ApiFormatter::createApi('400', 'Quantity is required!');
        }
        if(!$request->user){
            return ApiFormatter::createApi('400', 'User is required!');
        } else {
            $user = User::find($request->user);
            if(!$user) return ApiFormatter::createApi('400', 'User not found!');
        }
        $cashout = Cashout::create(
            [
                'type' => $request->type,
                'amount' => $request->amount,
                'qty' => $request->qty,
                'user' => $request->user,
                'material' => $request->material,
                'status' => "PRP",
            ]
        );
        if($cashout){
            return ApiFormatter::createApi('200', 'Success', $cashout);
        } else {
            return ApiFormatter::createApi('400', 'Something went wrong');
        }
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
