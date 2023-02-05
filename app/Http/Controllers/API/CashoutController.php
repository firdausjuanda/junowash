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
        if($request->exact){
            if($request->start || $request->end){
                return ApiFormatter::createApi('400', 'Invalid input');
            } else {
                $cashout = Cashout::whereDate('created_at', Carbon::parse($request->exact))->get();
            }
        } else {
            if($request->start && $request->end){
                if($request->start > $request->end){
                    return ApiFormatter::createApi('400', 'Invalid input');
                }
                $cashout = Cashout::whereBetween('created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()])->orderBy('id', 'desc')->get();
            } else {
                return ApiFormatter::createApi('400', 'Invalid input');
            }
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
        $cashout = Cashout::find($id);
        return ApiFormatter::createApi('200', 'Success', $cashout);
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
        $data = [];
        foreach ($request->all() as $key => $value) {
            if($key != 'id' && $key != 'status' && $key != 'user'){
                $data[$key] = $value;
            }
        }
        $cashout = Cashout::find($id);
        if(!$cashout){
            return ApiFormatter::createApi(400, 'Not Found');
        } else {
            $cashout->update($data);
            $updated_data = Cashout::find($id);
            return ApiFormatter::createApi(200, 'Success', $updated_data);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $cashout = Cashout::where('id', '=' ,$id)->withTrashed()->first();
        $user = User::find($request->user);
        if(!$cashout){
            return ApiFormatter::createApi(400, 'Not found');
        } else {
            if(!$user){
                return ApiFormatter::createApi(400, 'User not found');
            } else {
                if($user->role != 'admin'){
                    return ApiFormatter::createApi(400, 'Authorization error');
                } else {
                    if($cashout->deleted_at == null){
                        $cashout->delete();
                        return ApiFormatter::createApi(200, 'Success', $cashout);
                    } else {
                        return ApiFormatter::createApi(400, 'Already deleted');
                    }
                }
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        $cashout = Cashout::where('id', '=' ,$id)->first();
        $user = User::find($request->user);
        if(!$cashout){
            return ApiFormatter::createApi(400, 'Not found');
        } else {
            if(!$user){
                return ApiFormatter::createApi(400, 'User not found');
            } else {
                if($user->role != 'admin'){
                    return ApiFormatter::createApi(400, 'Authorization error');
                } else {
                    if($cashout->deleted_at == null){
                        $cashout->delete();
                        return ApiFormatter::createApi(200, 'Success', $cashout);
                    } else {
                        return ApiFormatter::createApi(400, 'Already deleted');
                    }
                }
            }
        }
    }
}
